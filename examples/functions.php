<?php
require 'autoload.php';

function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::addFilter('prepend_at', 'func_prepend_at');


function func_append_at($text='') {
    return $text.'@@';
}
Sandbox\Filters::addFilter('append_at', 'func_append_at');

$out = Sandbox\Filters::applyFilter(['prepend_at', 'prepend_at'], 'This is a text');

echo "Output: ".$out."\n";
