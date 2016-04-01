<?php
require 'autoload.php';

function func_second($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_second',1);

function func_first($text='') {
    return '!!'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_first', 0);

$out = Sandbox\Filters::apply_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
