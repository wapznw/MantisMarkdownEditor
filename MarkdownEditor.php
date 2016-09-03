<?php


/**
 * MarkdownEditor
 *
 * @package    MantisPlugin
 * @subpackage MantisPlugin
 * @copyright  Copyright 2016  Daojiang - wapznw@gmail.com
 * @link       http://blog.50r.cn
 */

/**
 *
 */
class MarkdownEditorPlugin extends MantisPlugin {

    function register() {
        $this->name = 'MarkdownEditor';
        $this->description = 'MarkdownEditor';
        $this->page = '';

        $this->version = MANTIS_VERSION;
        $this->requires = array(
            'MantisCore' => '2.0.0',
        );

        $this->author = 'DaoJiang';
        $this->contact = 'wapznw@gmail.com';
        $this->url = 'http://blog.50r.cn';
    }


    /**
     * Default plugin configuration.
     *
     * @return array
     */
    public function config() {
        return array();
    }


    /**
     * Plugin hooks
     *
     * @return array
     */
    function hooks() {
        $t_hooks = array(
            'EVENT_CORE_HEADERS' => 'core_headers',
            'EVENT_LAYOUT_RESOURCES' => 'resources',
            'EVENT_LAYOUT_PAGE_FOOTER' => 'load_js'
        );
        return $t_hooks;
    }

    function core_headers() {
        http_csp_add('default-src', "'self'");
        http_csp_add('frame-ancestors', "'none'");
        http_csp_add('style-src', "'self'");
        http_csp_add('style-src', "'unsafe-inline'");
        http_csp_add('script-src', "'self'");
        http_csp_add('script-src', "'unsafe-inline'");
        http_csp_add('img-src', "'self'");
        http_csp_add('img-src', "data:");
        http_csp_add('font-src', "'self'");
        http_csp_add('font-src', 'data:');
    }

    function resources() {
        $this->import_editor_css();
    }

    function load_js() {
        $this->import_editor_js();
        html_javascript_link('../plugins/MarkdownEditor/pages/markdown-editor.js');
    }

    function import_editor_js() {
        html_javascript_link('../plugins/MarkdownEditor/vendor/simditor/module.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/simditor/hotkeys.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/simditor/uploader.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/simditor/simditor.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/marked/marked.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/to-markdown/to-markdown.js');
        html_javascript_link('../plugins/MarkdownEditor/vendor/simditor-markdown/simditor-markdown.js');
    }

    function import_editor_css() {
        html_css_link('plugins/MarkdownEditor/vendor/simditor/simditor.css');
        html_css_link('plugins/MarkdownEditor/vendor/simditor-markdown/simditor-markdown.css');
    }
}

































