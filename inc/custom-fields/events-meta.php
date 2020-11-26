<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$show_date = carbon_get_theme_option('show_date');
$show_time_start = carbon_get_theme_option('show_time_start');
$show_time_end = carbon_get_theme_option('show_time_end');
$show_address = carbon_get_theme_option('show_address');
$show_place = carbon_get_theme_option('show_place');
$show_thumb = carbon_get_theme_option('show_thumb');

$fields = [];

if ($show_date) {
    $fields[] = Field::make('date', 'date', 'Дата мероприятия');
}

if ($show_time_start) {
    $fields[] = Field::make('time', 'time_start', 'Время начала')
        ->set_storage_format('H:i')
        ->set_picker_options(
            [
                'time_24hr' => true,
                'altInput' => true,
                'altFormat' => 'H:i',
                'dateFormat' => 'H:i',
                'enableSeconds' => false,
            ]
        );
}
if ($show_time_end) {
    $fields[] = Field::make('time', 'time_end', 'Время завершения')
        ->set_storage_format('H:i')
        ->set_picker_options(
            [
                'time_24hr' => true,
                'altInput' => true,
                'altFormat' => 'H:i',
                'dateFormat' => 'H:i',
                'enableSeconds' => false,
            ]
        );
}

if ($show_address) {
    $fields[] = Field::make('text', 'address', 'Адрес проведения мероприятия');
}

if ($show_place) {
    $fields[] = Field::make('text', 'place', 'Место проведения мероприятия');
}

function get_organizators()
{
    $args = [
        'post_type' => 'events_organizer',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ];

    $query = new WP_Query($args);

    $organizers = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $organizers[carbon_get_post_meta(get_the_ID(), 'slug')] = get_the_title();
        }
    } else {
        $organizers['null'] = 'Организаторов не найдено';
    }

    return $organizers;
}

Container::make('post_meta', 'Информация о мероприятии')
    ->where('post_type', '=', 'events')
    ->add_fields($fields);

Container::make('post_meta', 'Организатор мероприятия')
    ->where('post_type', '=', 'events')
    ->add_fields(
        [
            Field::make('select', 'events_organizer', 'Выберите организатора')
                ->set_options('get_organizators'),
            Field::make('html', 'events_null_organizer')
                ->set_conditional_logic(
                    [
                        [
                            'field' => 'events_organizer',
                            'value' => 'null',
                            'compare' => '=',
                        ]
                    ]
                )
                ->set_html('<strong>Ошибка при выборе организатора</strong><p>К сожалению, организаторов не найдено, чтобы иметь возможность выбирать организаторов нужно сначала их создать.</p><p>Можете сохранить ваше мероприятие, а позже, после создания организатора, изменить это мероприятие указав уже созданного организатора.</p><p><a href="/wp-admin/post-new.php?post_type=events_organizer" target="_blank" class="button">Создать организатора</a></p>')
        ]
    );
