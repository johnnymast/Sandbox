<?php
namespace Sandbox\Demos;

require 'autoload.php';

use Sandbox\Actions;

class Action
{


    /**
     * @param string $text
     */
    public function firstFunc($text = '')
    {
        echo "Called first\n";
    }

    /**
     * @param string $text
     */
    public function secondFunc($text = '')
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
$out = $instance->execute();
