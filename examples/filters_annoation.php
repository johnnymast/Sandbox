<?php
require 'autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', true);

class Test
{
    /**
     * @Filter("prepend_at", priority=1)
     * @param string $text
     * @return string
     */
    public function prepend_at($text = '')
    {
        return '@' . $text;
    }

    /**
     * @Filter("prepend_at", priority=0)
     * @param string $text
     * @return string
     */
    public function prepend_at_second($text = '')
    {
        return '!!' . $text;
    }
}
Sandbox\Filters::registerFilterObject(new Test());

echo "Result ".Sandbox\Filters::applyFilter('prepend_at', 'Hello world');
echo "KLAAR\n";