<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

/**
 * @param string $text
 * @return string
 */
function my_callback_functions_filter_prepend($text = '')
{
    return '@@' . $text;
}

/**
 * @param string $text
 * @return string
 */
function my_callback_functions_filter_append($text = '')
{
    return $text . '@@';
}
