<?php
require 'autoload.php';

/**
 * Prepend @@ before the text
 *
 * @param string $text
 * @return string
 */
function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_prepend_at');


/**
 * Append @@ after the text
 *
 * @param string $text
 * @return string
 */
function func_append_at($text='') {
    return $text.'@@';
}
Sandbox\Filters::add_filter('append_at', 'func_append_at');

$out = Sandbox\Filters::apple_filter(['prepend_at', 'append_at'], 'This is a text');
echo "Output: ".$out."\n";
