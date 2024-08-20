<?php

if (!function_exists('formatBookTitle')) {
    function formatBookTitle($name)
    {
        return str_replace(':attr', $name, app('site')->site_options['book_title']);
    }
}
