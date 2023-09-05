<?php

add_action( 'init', function () {

    register_post_type( 'real_estate_object', [
        'label'  => null,
        'labels' => [
            'name'               => __( 'Недвижимость', THEME_TEXT_PREFIX ),
            'singular_name'      => __( 'Объект недвижимости', THEME_TEXT_PREFIX ),
            'add_new'            => __( 'Добавить объект недвижимости', THEME_TEXT_PREFIX ),
            'add_new_item'       => __( 'Добавление объекта недвижимости', THEME_TEXT_PREFIX ),
            'edit_item'          => __( 'Редактирование объекта недвижимости', THEME_TEXT_PREFIX ),
            'new_item'           => __( 'Новый объект недвижимости', THEME_TEXT_PREFIX ),
            'view_item'          => __( 'Смотреть объект недвижимости', THEME_TEXT_PREFIX ),
            'search_items'       => __( 'Искать объект недвижимости', THEME_TEXT_PREFIX ),
            'not_found'          => __( 'Объектов недвижимости не найдено', THEME_TEXT_PREFIX ),
            'not_found_in_trash' => __( 'Нет удалённых объектов недвижмиости', THEME_TEXT_PREFIX ),
            'menu_name'          => __( 'Недвжиимость', THEME_TEXT_PREFIX ),
            'featured_image'     => __( 'Основное изображение', THEME_TEXT_PREFIX ),
            // 'parent_item_colon'  => '',
        ],
        'description'            => 'Тип записи для объектов недвжимости',
        'public'                 => true,
        // 'publicly_queryable'  => null,
        // 'exclude_from_search' => null,
        // 'show_ui'             => null,
        // 'show_in_nav_menus'   => null,
        'show_in_menu'           => null,
        // 'show_in_admin_bar'   => null,
        'show_in_rest'        => null,
        'rest_base'           => null,
        'menu_position'       => null,
        'menu_icon'           => null,
        //'capability_type'   => 'post',
        //'capabilities'      => 'post',
        //'map_meta_cap'      => null,
        'hierarchical'        => false,
        'supports'            => [ 'title', 'editor', 'thumbnail', 'custom-fields' ],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );
});