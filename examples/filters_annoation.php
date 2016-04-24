<?php
require 'autoload.php';
use Sandbox\Annotations\Filter;
error_reporting(E_ALL);
ini_set('display_errors', true);

class Test
{
    /**
     * @Filter("prepend_at", priority=2)
     * @param string $text
     * @return string
     */
    public function prepend_at($text = '')
    {
        return '@' . $text;
    }

    /**
     * @Filter("prepend_at", priority=2)
     * @param string $text
     * @return string
     */
    public function prepend_at_second($text = '')
    {
        return '!!' . $text;
    }
}
Sandbox\Filters::register_filter_object(new Test());

echo "Result ".Sandbox\Filters::apply_filter('prepend_at', 'Hello world');
echo "KLAAR\n";