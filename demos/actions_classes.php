<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Sandbox\Actions;

class Action
{


    /**
     * @param string $text
     */
    public function firstFunc()
    {
        echo "Called first\n";
    }

    /**
     * @param string $text
     */
    public function secondFunc()
    {
        echo "Called second\n";
    }

    /**
     * Register and call the actions.
     *
     * @return mixed
     */
    public function execute()
    {
        Actions::addAction('say_hello', [$this, 'firstFunc'], 0);
        Actions::addAction('say_hello', [$this, 'secondFunc'], 1);
        return Actions::doAction('say_hello');
    }
}

$instance = new Action;
/**
 * Result should be:
 *
 * Called first
 * Called second
 *
 */
$instance->execute();

/**
 * This is not required in your code. I have to add this to reset my unit tests.
 */
Actions::removeAllActions('say_hello');
