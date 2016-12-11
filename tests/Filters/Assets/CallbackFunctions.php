<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

/**
 * @param string $text
 * @return string
 */
function filterPrepend($text = '')
{
    return '@@' . $text;
}

/**
 * @param string $text
 * @return string
 */
function filterAppend($text = '')
{
    return $text . '@@';
}
