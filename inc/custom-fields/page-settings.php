<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('theme_options', 'Параметры мероприятий')
    ->set_page_parent('edit.php?post_type=' . WPSEC_Core::$post_type)
    ->set_page_menu_title('Параметры')
    ->set_page_file('options')
    ->add_tab(
        'Общие параметры',
        [
            Field::make('html', 'dev_1', 'Раздел в разработке')
                ->set_html('<p>*стрекот сверчков*</p>')

        ]
    )
    ->add_tab(
        'Страница мероприятий',
        [
            Field::make('html', 'dev_2', 'Раздел в разработке')
                ->set_html('<p>*стрекот сверчков*</p>')
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
            Field::make('separator', 'meta_fields_sep', 'Включение дополнительных полей'),
            Field::make('html', 'meta_fields_desc', 'Описание раздела')
                ->set_html('<p>В данном разделе можно включить или отключить дополнительные поля, которые можно заполнять при создании мероприятия.</p><p>Отмеченные поля станут доступны для редактирования, неотмеченные поля, соотвестнно, станут недоступными.</p><p>Галочка напротив описания поля означает, что оно включено, чтобы изменения вступили в силу необходимо сохранить изменения.</p>'),
            Field::make('checkbox', 'show_date', 'Дата мероприятия')
                ->set_option_value('yes')
                ->set_default_value('yes')
                ->set_help_text('Добавлет поле с выбором даты'),
            Field::make('checkbox', 'show_time_start', 'Время начала мероприятия')
                ->set_option_value('yes')
                ->set_default_value('yes')
                ->set_help_text('Добавлет поле с выбором времени начала мероприятия'),
            Field::make('checkbox', 'show_time_end', 'Время окончания мероприятия')
                ->set_option_value('yes')
                ->set_default_value('yes')
                ->set_help_text('Добавлет поле с выбором времени окончания мероприятия'),
            Field::make('checkbox', 'show_address', 'Адрес проведения мероприятия')
                ->set_option_value('yes')
                ->set_default_value('yes')
                ->set_help_text('Добавлет текстовое поле куда можно записать адрес проведенния мероприятия'),
            Field::make('checkbox', 'show_place', 'Место проведения мероприятия')
                ->set_option_value('yes')
                ->set_default_value('yes')
                ->set_help_text('Добавлет текстовое поле куда можно записать место проведенния мероприятия'),
            Field::make('checkbox', 'show_thumb', 'Изображение (миниатюра) мероприятия')
                ->set_option_value('yes')
                ->set_help_text('Добавлет поле с выбором изображения мероприятия')
        ]
    )
    ->add_tab(
        'Внешний вид',
        [
            Field::make('separator', 'events_loop_sep', 'Классы вывода мероприятий'),
            Field::make('text', 'wpsec_container_classname', 'Класс контейнера'),
            Field::make('text', 'wpsec_ul_classname', 'Класс списка'),
            Field::make('text', 'wpsec_li_classname', 'Класс элемента списка'),
            Field::make('separator', 'event_loop_sep', 'Классы вывода одного мероприятия'),
        ]
    );
