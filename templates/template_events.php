<?php

get_header();

$args = [
    'post_type' => WPPC_Core::$post_type,
    'posts_per_page' => -1,
];

$query = new WP_Query($args);

?>

<div class="wppc-container">
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