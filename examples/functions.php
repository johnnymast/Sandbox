<?php
require 'autoload.php';

function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Actions::addFilter('prepend_at', 'func_prepend_at');


function func_append_at($text='') {
    return $text.'@@';
}
Sandbox\Actions::addFilter('append_at', 'func_append_at');

Sandbox\Actions::debug();
$out = Sandbox\Actions::applyFilter(['prepend_at', 'prepend_at'], 'This is a text');

echo "Output: ".$out."\n";
