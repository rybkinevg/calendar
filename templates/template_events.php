<?php

get_header();

$args = [
    'post_type' => WPSEC_Core::$post_type,
    'posts_per_page' => -1,
    'order' => 'ASC',
    'orderby' => 'meta_value_num',
    'meta_key' => '_time_start',
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

<div class="wpsec-container">
    <div class="wpsec-loader">
        <!-- <div class="sk-double-bounce">
            <div class="sk-child sk-double-bounce-1"></div>
            <div class="sk-child sk-double-bounce-2"></div>
        </div> -->
        <div class="sk-fading-circle">
            <div class="sk-circle sk-circle-1"></div>
            <div class="sk-circle sk-circle-2"></div>
            <div class="sk-circle sk-circle-3"></div>
            <div class="sk-circle sk-circle-4"></div>
            <div class="sk-circle sk-circle-5"></div>
            <div class="sk-circle sk-circle-6"></div>
            <div class="sk-circle sk-circle-7"></div>
            <div class="sk-circle sk-circle-8"></div>
            <div class="sk-circle sk-circle-9"></div>
            <div class="sk-circle sk-circle-10"></div>
            <div class="sk-circle sk-circle-11"></div>
            <div class="sk-circle sk-circle-12"></div>
        </div>
    </div>
    <div class="wpsec-controll">
        <div class="wpsec-controll__inner">
            <form id="wpsec-search">
                <div class="search-wrapper">
                    <input type="search" name="search" id="search" autocomplete="off" placeholder="Поиск по названию">
                    <input type="submit" value="Искать">
                </div>
            </form>
            <input type="text" name="organizer" id="organizer" autocomplete="off" placeholder="Поиск по организатору">
            <input type="text" name="type" id="type" autocomplete="off" placeholder="Поиск по типу">
            <div id="wpsec-datepicker" class='wpsec-datepicker'></div>
        </div>
    </div>
    <div class="wpsec-events">
        <?php include(WPSEC_DIR . 'templates/loops/events.php') ?>
    </div>
</div>

<?php get_footer(); ?>