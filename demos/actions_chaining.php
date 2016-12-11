<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Sandbox\Actions;

Actions::addAction('say_hi', function ($name = '') {
    echo "Hi: " . $name . "\n";
    return $name;
});

Actions::addAction('say_bye', function ($name = '') {
    echo "Bye: " . $name . "\n";
    return $name;
});

Actions::doAction(['say_hi', 'say_bye'], 'GitHub');
