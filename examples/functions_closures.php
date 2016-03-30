<?php
require 'autoload.php';

Sandbox\Filters::add_filter('prepend_at', function($text='') {
    return '@@'.$text;
});

$out = Sandbox\Filters::apple_filter('prepend_at', 'This is a text');
echo "Output: ".$out."\n";
