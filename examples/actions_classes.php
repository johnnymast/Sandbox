<?php
require 'autoload.php';

class Action {

    public function func_second($text) {
        echo "Called second\n";
    }

    public function func_first($text) {
        echo "Called first\n";
    }


    public function execute() {

        Sandbox\Actions::add_action('say_hello', [$this, 'func_second'], 1);
        Sandbox\Actions::add_action('say_hello', [$this, 'func_first'], 0);

        return Sandbox\Actions::do_action('say_hello');
    }
}

$instance = new Action;
$out = $instance->execute();
