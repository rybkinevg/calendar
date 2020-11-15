<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('carbon_fields_register_fields', 'custom_fields');
function custom_fields()
{
    require_once(WPPC_DIR . 'inc/custom-fields/events-meta.php');
}
