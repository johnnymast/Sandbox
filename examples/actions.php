<?php
require 'autoload.php';

//FIXME: rename file
function func_hello_world($text) {
    echo $text."\n";
}
Sandbox\Actions::add_action('hello_world', 'func_hello_world');
Sandbox\Actions::do_action('hello_world', 'Hello World');

