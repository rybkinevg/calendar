<?php
if ($query->have_posts()) {
?>
    <ul class="wpsec-list">
        <?php
        while ($query->have_posts()) {
            $query->the_post();
        ?>
            <li class="wpsec-list-item wpsec-event">
                <div class="wpsec-event__header">
                    <div class="wpsec-event__datetime">
                        <span class="wpsec-event__date">
                            <?= date("d.m.Y", strtotime(carbon_get_post_meta(get_the_ID(), 'date'))) ?>
                        </span>
                        @
                        <span class="wpsec-event__time">
                            <?= carbon_get_post_meta(get_the_ID(), 'time_start') ?> - <?= carbon_get_post_meta(get_the_ID(), 'time_end') ?>
                        </span>
                    </div>
                    <h3 class="wpsec-event__title">
                        <a href="<?= get_the_permalink() ?>"><?= get_the_title() ?></a>
                    </h3>
                </div>
                <div class="wpsec-event__body">
                    <span class="wpsec-event__place">
                        <?= carbon_get_post_meta(get_the_ID(), 'place') ?>
                    </span>
                    <span class="wpsec-event__address">
                        <?= carbon_get_post_meta(get_the_ID(), 'address') ?>
                    </span>
                </div>
                <div class="wpsec-event__footer">
                    <div class="wpsec-event__content">
                        <?= get_the_content() ?>
                    </div>
                </div>
            </li>
        <?php
        }
        ?>
    </ul>
<?php
} else {
?>
    <p>Мероприятий не найдено</p>
<?php
}
wp_reset_postdata();
?>