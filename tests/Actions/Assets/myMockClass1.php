<?php
namespace Sandbox\Tests\Actions\Assets;

use Sandbox;

class myMockClass1
{

    public function __construct()
    {
        Sandbox\Actions::addAction('do_some_things', [$this, 'firstAction']);
        Sandbox\Actions::addAction('do_some_things', [$this, 'secondAction']);
    }

    /**
     * @param array $args
     */
    public function firstAction($args = [])
    {
        /* void */
    }

    /**
     * @param array $args
     */
    public function secondAction($args = [])
    {
        /* void */
    }
}
