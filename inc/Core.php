<?php

class WPPC_Core
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
        require_once(WPPC_DIR . 'inc/Admin.php');
        new WPPC_Admin();
        require_once(WPPC_DIR . 'inc/Ajax.php');
        new WPPC_Ajax();
        require_once(WPPC_DIR . 'inc/Views.php');
        new WPPC_Views();
        require_once(WPPC_DIR . 'inc/Import.php');
        new WPPC_Import();
        require_once(WPPC_DIR . 'inc/Insert.php');
        new WPPC_Insert();
    }

    public function hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue']);
        add_action('init', [$this, 'github_plugin_updater']);
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

    public function admin_enqueue()
    {
        wp_register_style(
            'wppc-dashicons',
            WPPC_URL . 'admin/css/wp-posts-calendar.css',
            [],
            filemtime(WPPC_DIR . 'admin/css/wp-posts-calendar.css')
        );

        wp_enqueue_style('wppc-dashicons');
    }

    public function github_plugin_updater()
    {
        include_once(WPPC_DIR . 'inc/github-plugin-updater/updater.php');

        define('WP_GITHUB_FORCE_UPDATE', true);

        if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
            $config = [
                'slug' => 'wp-posts-calendar-main/wp-posts-calendar.php', // this is the slug of your plugin
                'proper_folder_name' => 'wp-posts-calendar', // this is the name of the folder your plugin lives in
                'api_url' => 'https://api.github.com/repos/rybkinevg/wp-posts-calendar', // the GitHub API url of your GitHub repo
                'raw_url' => 'https://raw.github.com/rybkinevg/wp-posts-calendar/main', // the GitHub raw url of your GitHub repo
                'github_url' => 'https://github.com/rybkinevg/wp-posts-calendar', // the GitHub url of your GitHub repo
                'zip_url' => 'https://github.com/rybkinevg/wp-posts-calendar/archive/main.zip', // the zip url of the GitHub repo
                'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
                'requires' => '5.5', // which version of WordPress does your plugin require?
                'tested' => '5.5', // which version of WordPress is your plugin tested up to?
                'readme' => 'README.md', // which file to use as the readme for the version number
                'access_token' => '', // Access private repositories by authorizing under Plugins > GitHub Updates when this example plugin is installed
            ];
            new WP_GitHub_Updater($config);
        }
    }
}
