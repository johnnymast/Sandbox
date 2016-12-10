<?php
namespace Sandbox\Tests\Actions\Assets;

use Sandbox;

class myMockClass1
{

    public function __construct()
    {
        Sandbox\Actions::add_action('do_some_things', [$this, 'first_function']);
        Sandbox\Actions::add_action('do_some_things', [$this, 'second_function']);
    }

    /**
     * @param array $args
     */
    public function first_function($args = [])
    {
        /* void */
    }

    /**
     * @param array $args
     */
    public function second_function($args = [])
    {
        /* Void */
    }
}
