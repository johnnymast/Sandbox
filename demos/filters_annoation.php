<?php
namespace Sandbox\Demos;

use Sandbox\Filters;

/*
 * Please note: This use statement is actualy required.
 * Without this use statement Filters::registerFilterObject
 * will not work.
 */
use Sandbox\Annotations\Filter;

require 'autoload.php';

class Test
{
    /**
     * This function is going to be called second
     * It has priority 1.
     *
     * @Filter("prepend_at", priority=1)
     * @param string $text
     * @return string
     */
    public function prependAt($text = '')
    {
        return '@' . $text;
    }

    /**
     * This is the first function going to be called.
     * It has priority 0.
     *
     * @Filter("prepend_at", priority=0)
     * @param string $text
     * @return string
     */
    public function prependAtSecond($text = '')
    {
        return '!!' . $text;
    }
}
Filters::registerFilterObject(new Test());

echo "Result ".Filters::applyFilter('prepend_at', 'Hello world');
