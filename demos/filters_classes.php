<?php
namespace Sandbox\Demos;

use Sandbox\Filters;

require 'autoload.php';


class Worker
{

    public function prependChars($text = '')
    {
        return '@@' . $text;
    }

    public function appendChars($text = '')
    {
        return $text . '@@';
    }

    public function execute()
    {

        Filters::addFilter('manipulate_string', [$this, 'prependChars']);
        Filters::addFilter('manipulate_string', [$this, 'appendChars']);

        return Filters::applyFilter('manipulate_string', 'This is a text');
    }
}

$worker = new Worker;
$out = $worker->execute();

echo "Result: " . $out . "\n";
