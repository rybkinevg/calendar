<?php

class WPPC_Core
{
    private static $instance;
    public static $post_type = 'events';

    public function __construct()
    {
        $this->hooks();
        $this->include();
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function include()
    {
        require_once(WPPC_DIR . 'inc/Admin.php');
        new WPPC_Admin();
        require_once(WPPC_DIR . 'inc/Ajax.php');
        new WPPC_Ajax();
        require_once(WPPC_DIR . 'inc/Views.php');
        new WPPC_Views();
        require_once(WPPC_DIR . 'inc/Import.php');
        new WPPC_Import();
    }

    public function hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
    }

    public function enqueue()
    {
        wp_register_style(
            'wppc-styles',
            WPPC_URL . 'public/css/styles.css',
            [],
            filemtime(WPPC_DIR . 'public/css/styles.css')
        );

        wp_register_style(
            'wppc-datepicker-styles',
            WPPC_URL . 'public/css/datepicker.min.css',
            [],
            filemtime(WPPC_DIR . 'public/css/datepicker.min.css')
        );

        wp_register_script(
            'wppc-script',
            WPPC_URL . 'public/js/script.js',
            ['wppc-jquery', 'wppc-datepicker-script'],
            filemtime(WPPC_DIR . 'public/js/script.js'),
            true
        );

        wp_register_script(
            'wppc-datepicker-script',
            WPPC_URL . 'public/js/datepicker.min.js',
            ['wppc-jquery'],
            filemtime(WPPC_DIR . 'public/js/datepicker.min.js'),
            true
        );

        /**
         * TODO: Изменить параметр кэширования filemtime
         */

        wp_register_script(
            'wppc-jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',
            [],
            filemtime(WPPC_DIR . 'public/js/datepicker.min.js'),
            true
        );

        if (is_archive(self::$post_type) || is_singular(self::$post_type)) {
            wp_enqueue_style('wppc-datepicker-styles');
            wp_enqueue_style('wppc-styles');
            wp_enqueue_script('wppc-datepicker-script');
            wp_enqueue_script('wppc-script');
            wp_enqueue_script('wppc-jquery');
        }
    }
}
