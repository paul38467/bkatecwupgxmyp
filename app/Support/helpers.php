<?php
//
// Redirect External URL
//
if (!function_exists('redirect_url'))
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
