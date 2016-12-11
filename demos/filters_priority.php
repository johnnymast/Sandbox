<?php
namespace Sandbox\Demos;

use Sandbox\Filters;

require 'autoload.php';

function func_second($text = '')
{
    return '@@' . $text;
}
Filters::addFilter('prepend_at', 'Sandbox\Demos\func_second', 1);

function func_first($text = '')
{
    return '!!' . $text;
}
Filters::addFilter('prepend_at', 'Sandbox\Demos\func_first', 0);

$out = Filters::applyFilter('prepend_at', 'This is a text');

/**
 * The result should be:
 *
 * Result: @@!!This is a text
 */
echo "Result: " . $out . "\n";
