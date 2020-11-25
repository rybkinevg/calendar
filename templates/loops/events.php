<?php
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
?>
        <li class="wpsec-list-item wpsec-event">
            <h3 class="wpsec-event__title">
                Заголовок -
                <?= get_the_title() ?>
            </h3>
            <div class="wpsec-event__date">
                Дата -
                <?= carbon_get_post_meta(get_the_ID(), 'date') ?>
            </div>
            <div class="wpsec-event__time">
                Время начала -
                <?= carbon_get_post_meta(get_the_ID(), 'time_start') ?>
            </div>
            <div class="wpsec-event__time">
                Время окончания -
                <?= carbon_get_post_meta(get_the_ID(), 'time_end') ?>
            </div>
            <div class="wpsec-event__content">
                Организатор -
                <?= carbon_get_post_meta(get_the_ID(), 'organizer') ?>
            </div>
            <div class="wpsec-event__content">
                Адрес -
                <?= carbon_get_post_meta(get_the_ID(), 'address') ?>
            </div>
            <div class="wpsec-event__content">
                Место -
                <?= carbon_get_post_meta(get_the_ID(), 'place') ?>
            </div>
            <div class="wpsec-event__content">
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