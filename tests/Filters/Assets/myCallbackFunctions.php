<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

/**
 * @param string $text
 * @return string
 */
function my_callback_functions_prepend($text = '')
{
    return '@@' . $text;
}

/**
 * @param string $text
 * @return string
 */
function my_callback_functions_append($text = '')
{
    return $text . '@@';
}