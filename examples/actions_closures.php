<?php
require 'autoload.php';


Sandbox\Actions::add_action('hello_world', function () {
    echo "The callback is called\n";
});
Sandbox\Actions::do_action('hello_world');
