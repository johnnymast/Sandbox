<?php
namespace Sandbox\Tests\Filters\Assets;

use Sandbox;

class MockClass1
{

    /**
     * myMockClass1 constructor.
     */
    public function __construct()
    {
        Sandbox\Filters::addFilter('manipulate_string', [$this, 'prependChars']);
        Sandbox\Filters::addFilter('manipulate_string', [$this, 'appendChars']);
    }

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

    /**
     * @return string
     */
    public function execute()
    {
        return Sandbox\Filters::addFilter('manipulate_string', 'This is a text');
    }
}
