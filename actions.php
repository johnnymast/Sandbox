<?php
require dirname(__FILE__).'/vendor/autoload.php';

function func_prepend_at($text='') {
    return '@@'.$text;
}
Sandbox\Filters::add_filter('prepend_at', 'func_prepend_at');


function func_append_at($text='') {
    return $text.'@@';
}
Sandbox\Filters::add_filter('append_at', 'func_append_at');
$out = Sandbox\Filters::apple_filter(['prepend_at', 'append_at'], 'This is a text');

echo "Output: ".$output."\n";
