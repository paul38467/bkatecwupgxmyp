<?php
//
// Redirect External URL
//
if ( ! function_exists('redirect_url'))
{
    function redirect_url(string $url, string $name = '')
    {
        $lists = config('cfg.redirectUrlLists');

        if (!empty($name) && array_key_exists($name, $lists))
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

//
// 移除 EOL
// "\r\n" - for Windows, "\r" - for Mac and "\n" - for Linux
//
if ( ! function_exists('remove_eol'))
{
    function remove_eol($var)
    {
        return is_string($var) ? str_replace(["\r\n", "\r", "\n"], "", $var) : $var;
    }
}

//
// 使用樣板作比對時，要將路徑裡的 / 轉為 \/
//
if ( ! function_exists('path_to_pattern'))
{
    function path_to_pattern(string $path)
    {
        return str_replace('/', '\/', replace_windows_path($path));
    }
}

//
// 將 Windows 路徑使用的 \ 轉為 /
//
if ( ! function_exists('replace_windows_path'))
{
    function replace_windows_path(string $path)
    {
        return str_replace(DIRECTORY_SEPARATOR, "/", $path);
    }
}
