<?php

class WPPC_Core
{
    private static $instance;

    public function __construct()
    {
        $this->hooks();
        $this->include();
    }

    public function include()
    {
        require_once(WPPC_DIR . 'include/Shortcode.php');
        new WPPC_Shortcode();
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

        wp_enqueue_style('wppc-styles');

        wp_register_script(
            'wppc-script',
            WPPC_URL . 'public/js/script.js',
            [],
            filemtime(WPPC_DIR . 'public/js/script.js'),
            true
        );

        wp_enqueue_script('wppc-script');
    }

    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}
