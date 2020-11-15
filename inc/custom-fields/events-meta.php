<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Информация о мероприятии')
    ->where('post_type', '=', 'events')
    ->add_fields(
        [
            Field::make('date', 'date', 'Дата мероприятия'),
            Field::make('time', 'time_start', 'Время начала')
                ->set_storage_format('H:i')
                ->set_picker_options(
                    [
                        'time_24hr' => true,
                        'altInput' => true,
                        'altFormat' => 'H:i',
                        'dateFormat' => 'H:i',
                        'enableSeconds' => false,
                    ]
                ),
            Field::make('time', 'time_end', 'Время завершения')
                ->set_storage_format('H:i')
                ->set_picker_options(
                    [
                        'time_24hr' => true,
                        'altInput' => true,
                        'altFormat' => 'H:i',
                        'dateFormat' => 'H:i',
                        'enableSeconds' => false,
                    ]
                ),
            Field::make('text', 'organizer', 'Организатор'),
            Field::make('text', 'address', 'Адрес мероприятия'),
            Field::make('text', 'place', 'Место проведения')
        ]
    );
