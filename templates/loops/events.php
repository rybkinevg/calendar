<?php
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
?>
        <li class="wppc-list-item wppc-event">
            <h3 class="wppc-event__title">
                Заголовок -
                <?= get_the_title() ?>
            </h3>
            <div class="wppc-event__date">
                Дата -
                <?= carbon_get_post_meta(get_the_ID(), 'date') ?>
            </div>
            <div class="wppc-event__time">
                Время начала -
                <?= carbon_get_post_meta(get_the_ID(), 'time_start') ?>
            </div>
            <div class="wppc-event__time">
                Время окончания -
                <?= carbon_get_post_meta(get_the_ID(), 'time_start') ?>
            </div>
            <div class="wppc-event__content">
                Организатор -
                <?= carbon_get_post_meta(get_the_ID(), 'organizer') ?>
            </div>
            <div class="wppc-event__content">
                Адрес -
                <?= carbon_get_post_meta(get_the_ID(), 'address') ?>
            </div>
            <div class="wppc-event__content">
                Место -
                <?= carbon_get_post_meta(get_the_ID(), 'place') ?>
            </div>
            <div class="wppc-event__content">
                Контент -
                <?= get_the_content() ?>
            </div>
        </li>
    <?php
    }
} else {
    ?>
    <p>Мероприятий не найдено</p>
<?php
}
wp_reset_postdata();
?>