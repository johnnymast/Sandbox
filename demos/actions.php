<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Sandbox\Actions;

function helloWorld($text)
{
    echo $text . "\n";
}

Actions::AddAction('hello_world', 'helloWorld');
Actions::doAction('hello_world', 'Hello World');

