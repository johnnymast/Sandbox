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

    /**
     * @param string $text
     * @return string
     */
    public function prepend_chars($text='') {
        return '@@'.$text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function append_chars($text='') {
        return $text.'@@';
    }

    /**
     * @return string
     */
    public function execute() {
        return Sandbox\Filters::apply_filter('manipulate_string', 'This is a text');
    }
}