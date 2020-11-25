<?php

class WPSEC_Core
{
    private static $instance;
    public static $post_type = 'events';

    public function __construct()
    {
        /**
         * Обновление постоянных ссылок для работы кастомного типа записи
         */
        delete_option('rewrite_rules');

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
        require_once(WPSEC_DIR . 'inc/Admin.php');
        new WPSEC_Admin();
        require_once(WPSEC_DIR . 'inc/Ajax.php');
        new WPSEC_Ajax();
        require_once(WPSEC_DIR . 'inc/Views.php');
        new WPSEC_Views();
        require_once(WPSEC_DIR . 'inc/Import.php');
        new WPSEC_Import();
        require_once(WPSEC_DIR . 'inc/Insert.php');
        new WPSEC_Insert();
    }

    public function hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);
    }

    public function enqueue()
    {
        wp_register_style(
            'wpsec-styles',
            WPSEC_URL . 'public/css/styles.css',
            [],
            filemtime(WPSEC_DIR . 'public/css/styles.css')
        );

        wp_register_style(
            'wpsec-datepicker-styles',
            WPSEC_URL . 'public/css/datepicker.min.css',
            [],
            filemtime(WPSEC_DIR . 'public/css/datepicker.min.css')
        );

        wp_register_script(
            'wpsec-script',
            WPSEC_URL . 'public/js/script.js',
            ['wpsec-jquery', 'wpsec-datepicker-script'],
            filemtime(WPSEC_DIR . 'public/js/script.js'),
            true
        );

        wp_register_script(
            'wpsec-datepicker-script',
            WPSEC_URL . 'public/js/datepicker.min.js',
            ['wpsec-jquery'],
            filemtime(WPSEC_DIR . 'public/js/datepicker.min.js'),
            true
        );

        /**
         * TODO: Изменить параметр кэширования filemtime
         */

        wp_register_script(
            'wpsec-jquery',
            'http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js',
            [],
            filemtime(WPSEC_DIR . 'public/js/datepicker.min.js'),
            true
        );

        if (is_archive(self::$post_type) || is_singular(self::$post_type)) {
            wp_enqueue_style('wpsec-datepicker-styles');
            wp_enqueue_style('wpsec-styles');
            wp_enqueue_script('wpsec-datepicker-script');
            wp_enqueue_script('wpsec-script');
            wp_enqueue_script('wpsec-jquery');
        }
    }

    public function admin_enqueue()
    {
        wp_register_style(
            'wpsec-dashicons',
            WPSEC_URL . 'admin/css/wp-posts-calendar.css',
            [],
            filemtime(WPSEC_DIR . 'admin/css/wp-posts-calendar.css')
        );

        wp_enqueue_style('wpsec-dashicons');
    }
}
