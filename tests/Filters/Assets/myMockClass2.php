<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

class myMockClass2
{
    /**
     * @param string $text
     * @return string
     */
    public function prepend_chars($text = '')
    {
        return '@@' . $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function append_chars($text = '')
    {
        return $text . '@@';
    }
}
