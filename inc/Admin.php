<?php

class WPPC_Admin
{
    public function __construct()
    {
        $this->hooks();
        $this->include();
    }

    public function hooks()
    {
        add_action('init', [$this, 'create_post_types']);
        add_action('init', [$this, 'create_taxonomies']);
        add_action('admin_menu', [$this, 'create_import_page']);
    }

    public function include()
    {
        require_once(WPPC_DIR . 'inc/carbon-fields/carbon-fields-plugin.php');
        require_once(WPPC_DIR . 'inc/custom-fields/custom-fields.php');
    }

    public function create_post_types()
    {
        $args = [
            'label'  => null,
            'labels' => [
                'name'               => 'Мероприятия', // основное название для типа записи
                'singular_name'      => 'Мероприятие', // название для одной записи этого типа
                'add_new'            => 'Добавить мероприятие', // для добавления новой записи
                'add_new_item'       => 'Добавление мероприятия', // заголовка у вновь создаваемой записи в админ-панели.
                'edit_item'          => 'Редактирование мероприятия', // для редактирования типа записи
                'new_item'           => 'Новое мероприятие', // текст новой записи
                'view_item'          => 'Смотреть мероприятие', // для просмотра записи этого типа.
                'search_items'       => 'Искать мероприятие', // для поиска по этим типам записи
                'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                'parent_item_colon'  => '', // для родителей (у древовидных типов)
                'menu_name'          => 'Мероприятия', // название меню
            ],
            'description'         => '',
            'public'              => true,
            'show_in_menu'        => null, // показывать ли в меню адмнки
            // 'show_in_admin_bar'   => null, // зависит от show_in_menu
            'show_in_rest'        => true, // добавить в REST API. C WP 4.7
            'rest_base'           => null, // $post_type. C WP 4.7
            'menu_position'       => null,
            'menu_icon'           => null,
            'hierarchical'        => false,
            'supports'            => ['title', 'editor'],
            'taxonomies'          => ['event_types'],
            'has_archive'         => true,
            'rewrite'             => true,
            'query_var'           => true,
        ];

        register_post_type(WPPC_Core::$post_type, $args);
    }

    public function create_taxonomies()
    {
        $args = [
            'label'                 => '',
            'labels'                =>
            [
                'name'              => 'Тип мероприятия',
                'singular_name'     => 'Тип мероприятия',
                'search_items'      => 'Искать тип',
                'all_items'         => 'Все типы',
                'view_item '        => 'Показать тип',
                'parent_item'       => 'Родительский тип',
                'parent_item_colon' => 'Родительский тип:',
                'edit_item'         => 'Изменить тип',
                'update_item'       => 'Обновить тип',
                'add_new_item'      => 'Добавить новый тип',
                'new_item_name'     => 'Новый тип',
                'menu_name'         => 'Тип мероприятия',
            ],
            'description'           => 'Типы мероприятий',
            'public'                => true,
            'publicly_queryable'    => false,
            'hierarchical'          => true,
            'rewrite'               => true,
            'capabilities'          => [],
            'meta_box_cb'           => null,
            'show_admin_column'     => false,
            'show_in_rest'          => true,
            'rest_base'             => null
        ];

        register_taxonomy('event_types', [WPPC_Core::$post_type], $args);
    }

    public function create_import_page()
    {
        add_submenu_page(
            'edit.php?post_type=' . WPPC_Core::$post_type,
            'Импорт мероприятий',
            'Импорт',
            'manage_options',
            'import',
            [WPPC_Views::class, 'import_page_view']
        );
    }
}
