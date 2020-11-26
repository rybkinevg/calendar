<?php

class WPSEC_Ajax
{
    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('wp_ajax_events_filter', [$this, 'events_filter_callback']);
        add_action('wp_ajax_nopriv_events_filter', [$this, 'events_filter_callback']);
    }

    public function enqueue()
    {
        if (is_archive(WPSEC_Core::$post_type) || is_singular(WPSEC_Core::$post_type)) {
            wp_localize_script(
                'wpsec-script',
                'ajax',
                [
                    'action' => 'events_filter',
                    'url' => admin_url('admin-ajax.php'),
                    'dates' => $this->get_events_array()
                ]
            );
        }
    }

    public function events_filter_callback()
    {
        if (isset($_GET['date'])) {
            $date = date("Y-m-d", strtotime($_GET['date']));

            $args = [
                'post_type' => WPSEC_Core::$post_type,
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => '_time_start',
                'meta_query' => [
                    [
                        'key' => 'date',
                        'value' => $date,
                        'compare' => '='
                    ]
                ]
            ];
        }

        if (isset($_GET['s'])) {
            $args = [
                'post_type' => WPSEC_Core::$post_type,
                'posts_per_page' => -1,
                'post_status' => 'publish',
                'order' => 'ASC',
                'orderby' => 'relevance',
                's' => $_GET['s']
            ];
        }

        $query = new WP_Query($args);

        include(WPSEC_DIR . 'templates/loops/events.php');

        wp_die();
    }

    public function get_events_array()
    {
        $events = [];

        $args = [
            'post_type' => WPSEC_Core::$post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ];

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $date = carbon_get_post_meta(get_the_ID(), 'date');
                if (!in_array($date, $events)) {
                    array_push($events, $date);
                }
            }
        }
        wp_reset_postdata();

        return $events;
    }
}
