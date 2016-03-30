<?php
require 'autoload.php';

Sandbox\Actions::add_action('say_hi', function($name='') {
    echo "Hi: ".$name."\n";
});

Sandbox\Actions::add_action('say_bye', function($name='') {
    echo "Bye: ".$name."\n";
});

Sandbox\Actions::do_action(['say_hi', 'say_bye'], 'GitHub');
