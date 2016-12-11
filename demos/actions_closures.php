<?php
namespace Sandbox\Demos;

use Sandbox\Actions;

require 'autoload.php';


Actions::addAction('hello_world', function () {
    echo "The callback is called\n";
});
Actions::doAction('hello_world');
