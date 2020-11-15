<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', 'Импорт мероприятий')
    ->set_page_parent('edit.php?post_type=' . WPPC_Core::$post_type)
    ->set_page_menu_title('Импорт')
    ->set_page_file('import')
    ->add_tab(
        'Общие параметры',
        [
            Field::make('text', 'wppc_import', 'Настройка')
        ]
    );
