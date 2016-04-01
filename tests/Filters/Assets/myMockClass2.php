<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

class myMockClass2
{
    public function prepend_chars($text = '')
    {
        return '@@' . $text;
    }

    public function append_chars($text = '')
    {
        return $text . '@@';
    }
}