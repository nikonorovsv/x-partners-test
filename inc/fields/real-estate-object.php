<?php

// Регистрируем метаполе для привязки объекта недвижимости к городу
register_meta( 'post', 'city_id', [
    'object_subtype'    => 'real_estate_object',
    'type'              => 'number',
    'description'       => __( 'ID города', THEME_TEXT_PREFIX ),
    'single'            => true,
    'sanitize_callback' => 'absint',
    'auth_callback'     => null,
    'show_in_rest'      => true,
] );

// ACF скрывает блок метаполей, так можно отобразить их в админке
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// Привязываем объект к городу по адресу в момент добавления или обновления
add_action('save_post', function ($post_id, $post) {
    if (
        (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        || wp_is_post_revision($post_id)
        || wp_is_post_autosave($post_id)
        || $post->post_type !== 'real_estate_object'
    ) {
        return;
    }

    $objectCityId = get_post_meta($post_id, 'city_id', true);
    if ($objectCityId) {
        return;
    }

    $address = get_field('address', $post_id);
    if (!$address) {
        return;
    }

    $cities = get_posts([
        'post_type'      => 'city',
        'post_status'    => 'publish',
        'posts_per_page' => -1
    ]);

    foreach ($cities as $city) {
        if (stripos($address, $city->post_title) === false) {
            continue;
        }

        update_post_meta($post_id, 'city_id', $city->ID);
    }
}, 10, 2);