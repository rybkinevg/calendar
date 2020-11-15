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
        add_action('init', [$this, 'register_post_types']);
        add_action('admin_menu', [$this, 'pages']);
    }

    public function include()
    {
        require_once(WPPC_DIR . 'inc/carbon-fields/carbon-fields-plugin.php');
        require_once(WPPC_DIR . 'inc/custom-fields/custom-fields.php');
    }

    public function register_post_types()
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
            'taxonomies'          => [],
            'has_archive'         => true,
            'rewrite'             => true,
            'query_var'           => true,
        ];

        register_post_type(WPPC_Core::$post_type, $args);
    }

    public function pages()
    {
        add_submenu_page(
            'edit.php?post_type=' . WPPC_Core::$post_type,
            'Test',
            'Test menu',
            'manage_options',
            'import',
            [$this, 'page_import']
        );
        add_submenu_page(
            'edit.php?post_type=' . WPPC_Core::$post_type,
            'Test 2',
            'Test menu 2',
            'manage_options',
            'edit.php'
        );
    }

    public function page_import()
    {
        echo '123';
    }
}
