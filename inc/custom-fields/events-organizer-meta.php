<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Информация об организаторе')
    ->where('post_type', '=', 'events_organizer')
    ->add_fields(
        [
            Field::make('text', 'name', 'Имя организатора'),
            Field::make('text', 'link', 'Ссылка на организатора'),
            Field::make('text', 'slug', 'Слаг (post_name) организатора')
                ->set_help_text('Поле опционально, если организатор выступает сам за себя, а не как уже созданный тип записи. Должен совпадать со слагом связанного типа записи.')
        ]
    );
