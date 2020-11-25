<?php

class WPSEC_Views
{
    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        add_filter('template_include', [$this, 'get_templates']);
    }

    public function get_templates($template)
    {
        if (is_archive(WPSEC_Core::$post_type)) {
            if ($new_template = WPSEC_DIR . 'templates/template_events.php')
                $template = $new_template;
        }
        if (is_singular(WPSEC_Core::$post_type)) {
            if ($new_template = WPSEC_DIR . 'templates/template_single_event.php')
                $template = $new_template;
        }

        return $template;
    }

    public static function import_page_view()
    {
        require_once(WPSEC_DIR . 'templates/template_import_page.php');
    }
}
