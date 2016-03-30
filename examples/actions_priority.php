<?php
require 'autoload.php';

function func_second($text) {
    echo "Called second\n";
}

function func_first($text) {
    echo "Called first\n";
}

Sandbox\Actions::add_action('say_hello', 'func_second', 1);
Sandbox\Actions::add_action('say_hello', 'func_first', 0);
Sandbox\Actions::do_action('say_hello');
