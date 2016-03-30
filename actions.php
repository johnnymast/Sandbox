<?php
require dirname(__FILE__).'/vendor/autoload.php';

// TODO: Invalid callbacks

Sandbox\Filters::addFilter('prepend_at', function($text) {
    return '@@'.$text;
}, 1);

Sandbox\Filters::addFilter('prepend_at', function($text) {
    return '!!'.$text;
}, 2);

Sandbox\Filters::addFilter('prepend_at', function($text) {
    return $text.'@@';
},1);

//Sandbox\Actions::debug();
$out = Sandbox\Filters::applyFilter(array('append_at', 'prepend_at'), 'hello');

echo 'done: '.$out;
echo "\n";
