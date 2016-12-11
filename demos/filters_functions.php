<?php
namespace Sandbox\Demos;

use Sandbox\Filters;

require 'autoload.php';

/**
 * This function will return '@@This is a text';
 *
 * @param string $text
 * @return string
 */
function prependAt($text = '')
{
    return '@@' . $text;
}

Filters::addFilter('prepend_at', 'prependAt');
$out = Filters::applyFilter('prepend_at', 'This is a text');

/**
 * The result should be
 *
 * Result: @@This is a text
 */
echo "Result: " . $out . "\n";
