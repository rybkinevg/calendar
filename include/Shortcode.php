<?php

class WPPC_Shortcode
{
    public function __construct()
    {
        add_shortcode('wppc_calendar', [$this, 'shortcode_calendar']);
    }

    public function shortcode_calendar()
    {
        ob_start();
?>
        Text
<?php
        return ob_get_clean();
    }
}
