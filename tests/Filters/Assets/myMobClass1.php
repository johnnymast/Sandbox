<?php
namespace Sandbox\Tests\Filters\Assets;
use Sandbox;

class myMobclass1
{
    public function prepend_chars($text='') {
        return '@@'.$text;
    }

    public function append_chars($text='') {
        return $text.'@@';
    }

    public function execute() {

        Sandbox\Filters::add_filter('manipulate_string', [$this, 'prepend_chars']);
        Sandbox\Filters::add_filter('manipulate_string', [$this, 'append_chars']);

        return Sandbox\Filters::apple_filter('manipulate_string', 'This is a text');
    }

}