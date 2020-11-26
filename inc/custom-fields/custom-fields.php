<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'custom_fields');
function custom_fields()
{
    require_once(WPSEC_DIR . 'inc/custom-fields/page-settings.php');
    require_once(WPSEC_DIR . 'inc/custom-fields/events-meta.php');
    require_once(WPSEC_DIR . 'inc/custom-fields/events-organizer-meta.php');
    //require_once(WPSEC_DIR . 'inc/custom-fields/page-import.php');
}
