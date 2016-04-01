<?php
require 'autoload.php';

Sandbox\Filters::add_filter('prepend_at', function($text='') {
    return '@@'.$text;
});

Sandbox\Filters::add_filter('append_at', function($text='') {
    return $text.'@@';
});


$out = Sandbox\Filters::apply_filter(['prepend_at', 'append_at'], 'This is a text');
echo "Output: ".$out."\n";
