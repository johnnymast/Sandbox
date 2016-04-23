<?php
require 'autoload.php';
use Sandbox\Annotations\Filter;
error_reporting(E_ALL);
ini_set('display_errors', true);

class Test
{
    /**
     * @Filter("name", dataType="string")
     * @param string $text
     * @return string
     */
    public function prepend_at($text = '')
    {
        return '@' . $text;
    }
}
Sandbox\Filters::register_filter_object(new Test());

e
cho "KLAAR\n";