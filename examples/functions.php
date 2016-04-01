<?php
require 'autoload.php';

function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_prepend_at');

$out = Sandbox\Filters::apply_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
