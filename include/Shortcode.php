<?php

class WPPC_Shortcode
{
    public function __construct()
    {
        add_shortcode('wppc_calendar', [$this, 'shortcode_calendar']);
    }

    public function shortcode_calendar($atts)
    {
        $atts = shortcode_atts(
            [
                'id'         => 'calendar',
                'post_type'  => 'post',
                'orderby'    => 'date',
                'class_name' => 'wppc-calendar'
            ],
            $atts
        );

        $args = [
            'posts_per_page' => -1
        ];

        $args['post_type'] = $atts['post_type'];

        if ($atts['orderby'] == 'date') {
            $args['orderby'] = $atts['orderby'];
        } else {
            $args['meta_key'] = $atts['orderby'];
        }

        $posts_query = new WP_Query($args);

        $datesArr = [];

        if ($posts_query->have_posts()) {
            while ($posts_query->have_posts()) {
                $posts_query->the_post();
                if ($atts['orderby'] == 'date') {
                    array_push($datesArr, get_the_date('Y-m-d'));
                } else {
                    array_push($datesArr, get_post_meta(get_the_ID(), $atts['orderby']));
                }
            }
        }

        wp_localize_script(
            'wppc-script',
            'calendar_data',
            [
                'dates_array' => $datesArr,
                'id'          => $atts['id']
            ]
        );

        $calendar_id = $atts['id'];
        $calendar_class = $atts['class_name'];

        return "<table id='$calendar_id' class='wppc-calendar $calendar_class'>
                    <thead>
                        <tr>
                            <td class='wppc-prev-month'>‹
                            <td class='wppc-month' colspan='5'>
                            <td class='wppc-next-month'>›
                        <tr>
                            <td>Пн
                            <td>Вт
                            <td>Ср
                            <td>Чт
                            <td>Пт
                            <td>Сб
                            <td>Вс
                    <tbody>
                </table>";
    }
}
