<?php

/**
 * Plugin Name: WP Posts Calendar
 * Plugin URI: https://github.com/rybkinevg/wp-posts-calendar
 * Description: Плагин для добавления календаря для разных типов записей
 * Version: 0.3
 * Author: Евгений Рыбкин
 * Author URI: https://github.com/rybkinevg
 * GitHub Plugin URI: https://github.com/rybkinevg/wp-posts-calendar
 * Primary Branch: main
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WPPC_DIR', plugin_dir_path(__FILE__));
define('WPPC_URL', plugin_dir_url(__FILE__));

require_once(WPPC_DIR . 'inc/Core.php');

function wppc()
{
    return WPPC_Core::instance();
}

wppc();
