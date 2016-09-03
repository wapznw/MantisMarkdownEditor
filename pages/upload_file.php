<?php
/**
 * User: wdj
 * Date: 16/9/3
 * Time: 下午7:09
 */

header('Content-Type: application/json;charset=utf-8');
$allow_type = array('jpg', 'jpeg', 'gif', 'png'); //定义允许上传的类型

if (empty($_FILES) || empty($_FILES['upload_file'])) {
    exit(json_encode(array(
        'success' => false, 'msg' => ERROR_FILE_TOO_BIG
    )));
}

$file = $_FILES['upload_file'];
if(!preg_match('/image\/*/i', $file['type'])){
    exit(json_encode(array(
        'success' => false, 'msg' => ERROR_FILE_NOT_ALLOWED
    )));
}
if (!is_uploaded_file($file['tmp_name'])) {
    exit(json_encode(array(
        'file'  => $file,
        'success' => false, 'msg' => ERROR_FILE_NOT_ALLOWED
    )));
}

if($file['name'] === 'blob'){
    $file['name'] .= '.png';
}

$pathInfo = pathinfo($file['name']);
$ext = $pathInfo['extension'];
if(!in_array($ext, $allow_type)){
    exit(json_encode(array(
        'file'  => $file,
        'success' => false, 'msg' => ERROR_FILE_NO_UPLOAD_FAILURE
    )));
}

$saveFile = 'upload/image/' . md5(microtime(1)) . $file['name'] . '.png';
$dir = dirname($saveFile);
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
move_uploaded_file($file['tmp_name'], $saveFile);

echo json_encode(array(
    'file'  => $file,
    'success' => true, 'file_path' => '/' . $saveFile
));

