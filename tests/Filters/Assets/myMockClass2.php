<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

class myMockClass2
{
    /**
     * @param string $text
     * @return string
     */
    public function prependChars($text = '')
    {
        return '@@' . $text;
    }

    /**
     * @param string $text
     * @return string
     */
    public function appendChars($text = '')
    {
        return $text . '@@';
    }
}
