<?php

add_action( 'init', function () {

    register_taxonomy( 'taxonomy', [ 'real_estate_object' ], [
        'label'                 => '',
        'labels'                => [
            'name'              => __( 'Типы объектов недвижимости', THEME_TEXT_PREFIX ),
            'singular_name'     => __( 'Тип объектов недвижимости', THEME_TEXT_PREFIX ),
            'search_items'      => __( 'Найти типы объектов недвижимости', THEME_TEXT_PREFIX ),
            'all_items'         => __( 'Все типы объектов недвижимости', THEME_TEXT_PREFIX ),
            'view_item '        => __( 'Просмотреть тип объекта', THEME_TEXT_PREFIX ),
            'parent_item'       => __( 'Родительский тип', THEME_TEXT_PREFIX ),
            'parent_item_colon' => __( 'Родительский тип:', THEME_TEXT_PREFIX ),
            'edit_item'         => __( 'Редактировать тип объекта', THEME_TEXT_PREFIX ),
            'update_item'       => __( 'Обновить тип объекта недвжимости', THEME_TEXT_PREFIX ),
            'add_new_item'      => __( 'Добавить новый тип объекта', THEME_TEXT_PREFIX ),
            'new_item_name'     => __( 'Новое название типа объекта', THEME_TEXT_PREFIX ),
            'menu_name'         => __( 'Типы', THEME_TEXT_PREFIX ),
            'back_to_items'     => __( '← Вернуться к типам объектов', THEME_TEXT_PREFIX ),
        ],
        'description'           => '',
        'public'                => true,
        'hierarchical'          => true,

        'rewrite'               => true,
        'capabilities'          => array(),
        'meta_box_cb'           => null,
        'show_admin_column'     => false,
        'show_in_rest'          => null,
        'rest_base'             => null,
    ] );
});

