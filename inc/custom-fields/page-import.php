<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', 'Импорт мероприятий')
    ->set_page_parent('edit.php?post_type=' . WPSEC_Core::$post_type)
    ->set_page_menu_title('Импорт')
    ->set_page_file('import')
    ->add_fields(
        [
            Field::make('separator', 'import_settings_sep', 'Параметры импорта'),
            Field::make('select', 'import_settings', 'Выберите тип файла')
                ->add_options(
                    [
                        'text/csv' => 'CSV',
                        'text/xml' => 'XML'
                    ]
                ),
            Field::make('file', 'import_file', 'Загрузите файл')
                ->set_value_type('url')
                ->set_type(
                    [
                        'text/csv',
                        'text/xml'
                    ]
                )
        ]
    );
