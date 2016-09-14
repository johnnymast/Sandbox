<?php

namespace Sandbox\Traits;

function multiSort ()
{
    //get args of the function
    $args = func_get_args();
    $c = count($args);
    if ($c < 2) {
        return false;
    }
    //get the array to sort
    $array = array_splice($args, 0, 1);
    $array = $array[0];
    //sort with an anoymous function using args
    usort($array, function ($a, $b) use ($args) {

        $i = 0;
        $c = count($args);
        $cmp = 0;
        while ($cmp == 0 && $i < $c) {
            $cmp = strcmp($a[$args[$i]], $b[$args[$i]]);
            $i++;
        }

        return $cmp;

    });

    return $array;

}

trait ArrayFilter
{

    public static function filterByPriority (&$items = [])
    {
        /**
         * PHP Bug #70289 (https://bugs.php.net/bug.php?id=70289)
         * I had to write my own custom usort because on HHVM and PHP7+ usort will put equal priority
         * values on an earlier index while php 5 does the opposite of this. The PHP core team says its not
         * a bug but i find this a huge bug because i could not rely on the usort() function anymore.
         */
        $items = multiSort($items, 'priority');
    }
}