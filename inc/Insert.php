<?php

class WPPC_Insert
{
    public $data;

    public function __construct()
    {
        $this->hooks();
        $this->data = WPPC_Import::$imported_data;
    }

    public function hooks()
    {
        if (is_admin()) {
            add_action('wp_ajax_insert', [$this, 'insert']);
        }
    }

    public function enqueue()
    {
    }

    public function insert()
    {
        check_ajax_referer('insert', 'nonce');

        $keys = $this->clear_post_data($_POST['formData']);
        $array = $_POST['data'];

        wp_send_json_success($_POST['formData']);
    }

    public function clear_post_data($post)
    {
        unset($post['action']);
        unset($post['nonce']);

        foreach ($post as $key => $value) {
            if ($value == 'unset') {
                unset($post[$key]);
            }
        }

        return $post;
    }
}
