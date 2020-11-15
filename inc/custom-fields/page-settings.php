<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', 'Параметры мероприятий')
    ->set_page_parent('edit.php?post_type=' . WPPC_Core::$post_type)
    ->set_page_menu_title('Параметры')
    ->set_page_file('options')
    ->add_tab(
        'Общие параметры',
        [
            Field::make('text', 'wppc_setting', 'Настройка')
        ]
    )
    ->add_tab(
        'Внешний вид',
        [
            Field::make('text', 'wppc_container_classname', 'Класс контейнера'),
            Field::make('text', 'wppc_ul_classname', 'Класс списка'),
            Field::make('text', 'wppc_li_classname', 'Класс элемента списка')
        ]
    );
