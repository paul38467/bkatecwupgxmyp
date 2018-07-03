<?php
//
// Redirect External URL
//
if ( ! function_exists('redirect_url'))
{
    function redirect_url(string $url, string $name = '')
    {
        $lists = config('cfg.redirectUrlLists');

        if (array_key_exists($name, $lists))
        {
            $url = $lists[$name] . $url;
        }

        return config('cfg.redirectUrlBase') . $url;
    }
}

//
// 將兩個或以上的 space 轉為一個
//
if ( ! function_exists('single_space'))
{
    function single_space($var)
    {
        // u 代表 Unicode, 可以比對全形的空格
        return is_string($var) ? preg_replace('/\s+/u', ' ', $var) : $var;
    }
}
