<?php

get_header();

$args = [
    'post_type' => WPSEC_Core::$post_type,
    'posts_per_page' => -1,
    'meta_query' => [
        [
            'key' => 'date',
            'value' => date('Y-m-d'),
            'compare' => '='
        ]
    ]
];

$query = new WP_Query($args);

?>

<div class="<?= (carbon_get_theme_option('wpsec_container_classname')) ? carbon_get_theme_option('wpsec_class') : 'wpsec-container' ?>">
    <div class="wpsec-controll">
        <input id="wpsec-datepicker" type='text' class='wpsec-datepicker' autocomplete="off" />
    </div>
    <div class="wpsec-events">
        <ul class="wpsec-list">
            <?php include(WPSEC_DIR . 'templates/loops/events.php') ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>