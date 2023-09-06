<?php

get_template_part('vendor/autoload');

const THEME_TEXT_PREFIX = 'real-estate';

/**
 * Регистрируем типы постов и таксономии
 */
require_once get_theme_file_path( 'inc/entities/real-estate-object.php' );
require_once get_theme_file_path( 'inc/entities/real-estate-object-type.php' );
require_once get_theme_file_path( 'inc/entities/city.php' );

/**
 * Регистриуем метаполя
 */
require_once get_theme_file_path( 'inc/fields/real-estate-object.php' );

/**
 * Регистрируем дополнительные функции
 */
require_once get_theme_file_path( 'inc/functions.php' );

/**
 * Глобальные фильтры
 */
require_once get_theme_file_path( 'inc/filters.php' );

/**
 * Активируем настройки темы
 */
add_action('after_setup_theme', 'setup_theme_supports');
add_action('wp_enqueue_scripts', 'include_theme_assets');

/**
 * Регистрируем AJAX-обработчики
 */
$ajax_handlers = [
    '\theme\ajax_handlers\RealEstateObject',
];
foreach ($ajax_handlers as $ajax_handler_class_name) {
    $handler = new $ajax_handler_class_name();
    $handler->init();
}

/**
 * Пример установки настроек темы
 */
function setup_theme_supports()
{
    // Add post formats support
    add_theme_support('post-formats', [
        'standard',
        'aside',
        'audio',
        'gallery',
        'image',
        'link',
        'quote',
        'video'
    ]);

    // Let plugins and themes to change  <title> tag
    add_theme_support('title-tag');

    // Declare thumbnails support and set initial sizes
    add_theme_support('post-thumbnails');

    // Add logo support
    add_theme_support('custom-logo');

    // Add WC support
    // add_theme_support('woocommerce');

    // Change default post thumbnail size
    set_post_thumbnail_size(432, 324, true);
}

/**
 * Регистрируем стили и скрипты
 * @return void
 */
function include_theme_assets()
{
    // Load frontend folder
    wp_register_script('main', get_theme_file_uri('assets/bundle.js'), [], '1.0.0', TRUE);
    wp_enqueue_script('main');
    wp_register_style('main', get_theme_file_uri('assets/bundle.css'), [], 'prod', 'screen');
    wp_enqueue_style('main');
}