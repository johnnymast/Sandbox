<?php
require dirname(__FILE__).'/vendor/autoload.php';

// TODO: Invalid callbacks

Sandbox\Actions::addFilter('prepend_at', function($text) {
    return '@@'.$text;
}, 1);

Sandbox\Actions::addFilter('prepend_at', function($text) {
    return '!!'.$text;
}, 2);

Sandbox\Actions::addFilter('prepend_at', function($text) {
    return $text.'@@';
},1);

//Sandbox\Actions::debug();
$out = Sandbox\Actions::applyFilter(array('append_at', 'prepend_at'), 'hello');

echo 'done: '.$out;
echo "\n";
