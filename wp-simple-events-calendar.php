<?php

/**
 * Plugin Name: WP Simple Events Calendar
 * Plugin URI: https://github.com/rybkinevg/wp-posts-calendar
 * Description: Плагин мероприятий с календарём
 * Version: 0.1.1
 * Author: Евгений Рыбкин
 * Author URI: https://github.com/rybkinevg
 * GitHub Plugin URI: https://github.com/rybkinevg/wp-simple-events-calendar
 * Primary Branch: main
 */

if (!defined('ABSPATH')) {
    exit;
}

define('WPSEC_DIR', plugin_dir_path(__FILE__));
define('WPSEC_URL', plugin_dir_url(__FILE__));

require_once(WPSEC_DIR . 'inc/Core.php');

function wpsec()
{
    return WPSEC_Core::instance();
}

wpsec();
