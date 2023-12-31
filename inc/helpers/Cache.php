<?php

namespace theme\helpers;

use \Closure;

/**
 * Trait Cache
 * @package theme\helpers
 */
trait Cache
{

    /**
     * This method is saved your code result in Cache
     * and will return result from Cache if that exists.
     * It's final method because we get information about
     * call chain from debug_backtrace() PHP function.
     *
     * @param string $key
     * @param Closure $fallback
     *
     * @return mixed
     */
    protected final static function cache(Closure $fallback, string $key = 'single')
    {
        global $wp_object_cache;

        $d_bt = debug_backtrace()[1];
        $class = $d_bt['class'];
        $key = join('/', [$d_bt['function'], md5($key)]);

        $cache = $wp_object_cache->get($class, $key);
        if (!$cache) {
            $cache = $fallback();
            $wp_object_cache->set($class, $cache, $key);
        }

        return $cache;
    }
}