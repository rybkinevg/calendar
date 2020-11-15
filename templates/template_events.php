<?php

get_header();

$args = [
    'post_type' => WPPC_Core::$post_type,
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

<div class="<?= (carbon_get_theme_option('wppc_container_classname')) ? carbon_get_theme_option('wppc_class') : 'wppc-container' ?>">
    <div class="wppc-controll">
        <input id="wppc-datepicker" type='text' class='wppc-datepicker' autocomplete="off" />
    </div>
    <div class="wppc-events">
        <ul class="wppc-list">
            <?php include(WPPC_DIR . 'templates/loops/events.php') ?>
        </ul>
    </div>
</div>

<?php get_footer(); ?>