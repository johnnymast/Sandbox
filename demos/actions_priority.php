<?php
namespace Sandbox\Demos;

use Sandbox\Actions;

require 'autoload.php';

/**
 * This function is going to be called second.
 */
function secondFunction()
{
    echo "Called second\n";
}

/**
 * This function is going to be called first.
 */
function firstFunction()
{
    echo "Called first\n";
}

Actions::addAction('say_hello', 'firstFunction', 0);
Actions::addAction('say_hello', 'secondFunction', 1);
Actions::doAction('say_hello');
