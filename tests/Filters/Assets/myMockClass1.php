<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

class myMockClass1
{

    /**
     * myMobclass1 constructor.
     */
    public function __construct()
    {
        Sandbox\Filters::add_filter('manipulate_string', [$this, 'prepend_chars']);
        Sandbox\Filters::add_filter('manipulate_string', [$this, 'append_chars']);
    }

    public function prepend_chars($text = '')
    {
        return '@@' . $text;
    }

    public function append_chars($text = '')
    {
        return $text . '@@';
    }

    public function execute()
    {
        return Sandbox\Filters::apply_filter('manipulate_string', 'This is a text');
    }
}