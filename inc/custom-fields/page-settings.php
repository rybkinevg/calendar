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
        'Страница мероприятий',
        [
            Field::make('separator', 'events_sep', '123')
        ]
    )
    ->add_tab(
        'Страница мероприятия',
        [
            Field::make('separator', 'relative_events_sep', 'Похожие мероприятия'),
            Field::make('checkbox', 'relative_events', 'Показывать похожие мероприятия')
                ->set_option_value('yes'),
            Field::make('separator', 'events_icons_sep', 'Иконки'),
        ]
    )
    ->add_tab(
        'Дополнительные поля мероприятий',
        [
            Field::make('separator', 'events_meta_sep', '123'),
        ]
    )
    ->add_tab(
        'Внешний вид',
        [
            Field::make('separator', 'events_loop_sep', 'Классы вывода мероприятий'),
            Field::make('text', 'wppc_container_classname', 'Класс контейнера'),
            Field::make('text', 'wppc_ul_classname', 'Класс списка'),
            Field::make('text', 'wppc_li_classname', 'Класс элемента списка'),
            Field::make('separator', 'event_loop_sep', 'Классы вывода одного мероприятия'),
        ]
    );
