<?php

namespace theme\helpers;

use \WP_Error;

/**
 * Class WP
 * @package theme\helpers
 */
class WP
{
    /**
     * @param int|NULL $site_id
     *
     * @return bool
     */
    public static function isMainSite(int $site_id = null): bool
    {
        return is_main_site($site_id);
    }

    /**
     * @return bool
     */
    public static function isAjax(): bool
    {
        return (defined('DOING_AJAX') && DOING_AJAX);
    }

    /**
     * @return bool
     */
    public static function isLoggedUser(): bool
    {
        return is_user_logged_in();
    }

    /**
     * Без аргументов вернет кореневой URI темы
     *
     * @param null|string $path
     *
     * @return mixed
     */
    public static function uri(string $path = null)
    {
        return get_theme_file_uri($path);
    }

    /**
     * Без аргументов вернет кореневой путь темы
     *
     * @param null|string $path
     *
     * @return string
     */
    public static function path(string $path = null)
    {
        return get_theme_file_path($path);
    }

    /**
     * @param array $args
     * @param string|null $request_uri
     * @return string
     */
    public static function url(array $args = [], string $request_uri = null)
    {
        if (is_null($request_uri)) {
            $request_uri = $_SERVER['REQUEST_URI'];
        }

        return add_query_arg($args, home_url($request_uri));
    }

    /**
     * @param $size
     *
     * @return mixed
     */
    public static function getImageSize(string $size = 'thumbnail')
    {
        $sizes = self::getImageSizes();
        $size = key_exists($size, $sizes) ? $size : 'thumbnail';

        return $sizes[$size];
    }

    /**
     * @param bool $unset_disabled
     *
     * @return array
     */
    public static function getImageSizes(bool $unset_disabled = true)
    {
        $wais = &$GLOBALS['_wp_additional_image_sizes'];
        $sizes = [];
        foreach (get_intermediate_image_sizes() as $_size) {
            if (in_array($_size, ['thumbnail', 'medium', 'medium_large', 'large'])) {
                $sizes[$_size] = [
                    'width' => get_option("{$_size}_size_w"),
                    'height' => get_option("{$_size}_size_h"),
                    'crop' => (bool)get_option("{$_size}_crop"),
                ];
            } elseif ($wais[$_size]) {
                $sizes[$_size] = [
                    'width' => $wais[$_size]['width'],
                    'height' => $wais[$_size]['height'],
                    'crop' => $wais[$_size]['crop'],
                ];
            }
            // size registered, but has 0 width and height
            if ($unset_disabled && ($sizes[$_size]['width'] == 0) && ($sizes[$_size]['height'] == 0)) {
                unset($sizes[$_size]);
            }
        }

        return $sizes;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function clearString(string $string): string
    {
        $string = trim($string);
        $string = stripslashes($string);

        return htmlspecialchars($string);
    }

    /**
     * @param int $blog_id
     * @param callable $callback
     * @param array ...$args
     *
     * @return mixed
     */
    public static function runOnBlog(int $blog_id, callable $callback, ...$args)
    {
        switch_to_blog($blog_id);
        $result = call_user_func_array($callback, $args);
        switch_to_blog(get_current_blog_id());

        return $result;
    }

    /**
     * @return bool
     */
    public static function logo()
    {
        if (!has_custom_logo()) {
            return false;
        }

        return wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full');
    }

    /**
     * @param string $text
     * @return string
     */
    public static function l18n(string $text)
    {
        return __($text, 'theme');
    }

    /**
     * @param string $key
     * @param string $message
     * @return WP_Error
     */
    public static function error(string $key, string $message): WP_Error
    {
        return new WP_Error($key, self::l18n($message));
    }

    /**
     * @param array $data
     * @return string
     */
    public static function base64Encode(array $data): string
    {
        $base64_string = json_encode($data);
        $base64_string = base64_encode($base64_string);

        return wp_slash($base64_string);
    }

    /**
     * @param string $base64_string
     * @return array
     */
    public static function base64Decode(string $base64_string): array
    {
        $data = null;
        $base64_string = stripslashes($base64_string);
        if ( $json_string = base64_decode($base64_string) ) {
            $data = json_decode( $json_string );
        }

        return (array) $data;
    }
}