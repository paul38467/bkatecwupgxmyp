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

//
// 將一段字串轉為陣列, 移除空元素, 及可選擇是否移除重複的元素
//
if ( ! function_exists('string_to_array_filter'))
{
    function string_to_array_filter(string $string, $unique = false)
    {
        $array = explode("\r\n", $string);
        $array = array_map(function($value) {
                    return trim(single_space($value));
                 }, $array);
        $array = array_filter($array);
        return $unique ? array_unique($array) : $array;
    }
}

//
// 在 blade 顯示正確的 textarea 欄位文字
//
if ( ! function_exists('show_textarea'))
{
    function show_textarea(string $text)
    {
        return nl2br(e($text));
    }
}
