<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

$show_date = carbon_get_theme_option('show_date');
$show_time_start = carbon_get_theme_option('show_time_start');
$show_time_end = carbon_get_theme_option('show_time_end');
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

Container::make('post_meta', 'Информация о мероприятии')
    ->where('post_type', '=', 'events')
    ->add_fields($fields);
