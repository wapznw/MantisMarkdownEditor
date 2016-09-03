<?php
/**
 * User: wdj
 * Date: 16/9/3
 * Time: 上午1:35
 */

function gpc_get_fileCustom($p_var_name, $p_default = null) {
    if (isset($_FILES[$p_var_name])) {

        # FILES are not escaped even if magic_quotes is ON, this applies to Windows paths.
        $t_result = $_FILES[$p_var_name];
    } else if (isset($_POST[$p_var_name])) {
        $f = $_POST[$p_var_name][0];

        $h = "data:image/png;base64,";
        if (substr($f, 0, strlen($h)) == $h) {

            $data = base64_decode(substr($f, strlen($h)));
            $fn = tempnam("/tmp", "CLPBRD");
            file_put_contents($fn, $data);
            chmod($fn, 0777);
            $t_result = array();
            $pi = pathinfo($fn);
            $t_result[0]['name'] = $pi['filename'] . ".png";
            $t_result[0]['type'] = "image/png";
            $t_result[0]['size'] = strlen($data);
            $t_result[0]['tmp_name'] = $fn;
            $t_result[0]['error'] = 0;
        }
    } else if (func_num_args() > 1) {
        # check for a default passed in (allowing null)
        $t_result = $p_default;
    } else {

        error_parameters($p_var_name);
        trigger_error(ERROR_GPC_VAR_NOT_FOUND, ERROR);
    }
    return $t_result;

}
header('Content-Type: application/json;charset=utf-8');
$f_files = gpc_get_fileCustom('upload_file', -1);
if ($f_files == -1) {
    # _POST/_FILES does not seem to get populated if you exceed size limit so check if bug_id is -1
    //trigger_error(ERROR_FILE_TOO_BIG, ERROR);
    echo json_encode(array(
        'success'   => false,
        'msg'   => ERROR_FILE_TOO_BIG
    ));
    exit;
}
$dir = dirname($_SERVER['SCRIPT_NAME']);
//exit(json_encode($f_files));
//$file = $f_files[0];
$file = $f_files;
//move_uploaded_file($file['tmp_name'], md5(microtime(1)).'.png');
$filepath = 'upload/image/'.md5(microtime(1)).$file['name'].'.png';
$dir = dirname($filepath);
if(!is_dir($dir)){
    mkdir($dir, 0777 ,true);
}
if(is_uploaded_file($file['tmp_name'])){
    move_uploaded_file($file['tmp_name'], $filepath);
}else{
    file_put_contents($filepath, file_get_contents($file['tmp_name']));
    usleep(300);
}
echo json_encode(array(
    'success'   => true,
    'file_path'   => '/'.$filepath
));
