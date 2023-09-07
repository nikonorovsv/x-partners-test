<?php

/**
 * @param array|null $conf
 *
 * @return string
 */
function get_vue_app(array $conf = null): string
{
    $component = new \theme\helpers\VueApp($conf);

    return $component->render();
}

/**
 * @param array|null $conf
 */
function the_vue_app(array $conf = null): void
{
    echo get_vue_app($conf);
}

/**
 * Include template with parameters of context
 * Function can have some arguments
 *
 * @param string $template
 * @param array $props
 * @return string
 */
function renderCache(string $template, array $props = []): string
{
    $cache_key = md5($template . serialize($props));
    if (!$output = get_transient($cache_key)) {

        $output = render($template, $props);

        set_transient($cache_key, $output, HOUR_IN_SECONDS);
    }
    return $output;
}

/**
 * @param string $template
 * @param array $data
 * @return string
 */
function render(string $template, array $data = []): string
{
    $template = trim($template, '/');
    $file = get_theme_file_path("parts/$template.php");
    if (!file_exists($file)) {
        return '';
    }
    extract($data);

    ob_start();
    require $file;
    return ob_get_clean();
}

/**
 * @return array
 */
function get_query_vars(): array
{
    global $wp_query;

    return array_filter($wp_query->query_vars, fn($item) => !empty($item));
}

/**
 * @param string $string
 * @return bool
 */
function is_json(string $string): bool
{
    json_decode($string);

    return json_last_error() === JSON_ERROR_NONE;
}

/**
 * @param $data
 * @param false $exit
 */
function ve($data, bool $exit = false): void
{
    echo '<pre>';
    var_export($data);
    echo '</pre>';

    if ($exit) {
        exit;
    }
}

/**
 * Возвращает количество обектов для города по его ID
 *
 * @param int $cityId
 * @return int
 */
function get_city_objects_quantity( int $cityId ): int
{
    global $wpdb;

    $sql = "SELECT COUNT(meta_id) FROM $wpdb->postmeta WHERE meta_key = 'city_id' AND meta_value = %d";

    return (int) $wpdb->get_var( $wpdb->prepare( $sql, $cityId ) );
}

/**
 * Список городов с доступными объектами недвижимости в порядке убывания количества объектов
 *
 * @return array
 */
function get_cities(): array
{
    $query = get_posts( [
        'post_type' => 'city',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
    ] );

    $cities = [];
    foreach ( $query as $cityId ) {
        $count = get_city_objects_quantity( $cityId );
        if ( ! $count ) {
            continue;
        }

        $cities[] = [
            'id'    => $cityId,
            'name'  => get_the_title( $cityId ),
            'url'   => get_permalink( $cityId ),
            'count' => $count
        ];
    }

    usort( $cities, fn( $a, $b ) => ( $b['count'] - $a['count'] ) );

    return $cities;
}