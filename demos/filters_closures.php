<?php
namespace Sandbox\Demos;

use Sandbox\Filters;

require 'autoload.php';

Filters::addFilter('prepend_at', function ($text = '') {
    return '@@' . $text;
});

$out = Filters::applyFilter('prepend_at', 'This is a text');

/**
 * The result should be
 *
 * Result: @@This is a text
 */
echo "Result: " . $out . "\n";
