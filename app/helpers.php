<?php

if (!function_exists('current_namespace')) {
    /**
     * 当前使用的命名空间位置，相对于Controllers
     * @return string
     */
    function current_namespace(): string
    {
        $namespace = Route::current()->action['namespace'];
        $arr = explode('\\', $namespace);
        if (count($arr) > 5) {
            return array_pop($arr);
        } else {
            if (isset($arr[3])) {
                return $arr[3];
            }
        }
        return '';
    }
}

/**
 * 当前路由名称
 */
if (!function_exists('route_name')) {

    function route_name()
    {
        return Route::currentRouteName();
    }
}

