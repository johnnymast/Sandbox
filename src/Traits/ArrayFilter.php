<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30-03-16
 * Time: 21:17
 */

namespace Sandbox\Traits;


trait ArrayFilter
{

    public static function filterByPriority($items = []) {


        /**
         * PHP Bug #70289 (https://bugs.php.net/bug.php?id=70289)
         * I had to write my own custom usort because on HHVM and PHP7+ usort will put equal priority
         * values on an earlier index while php 5 does the opposite of this. The PHP core team says its not
         * a bug but i find this a huge bug because i could not rely on the usort() function anymore.
         */

        $new = [];
        $num = count($items);

        if ($num > 1) {
            for ($i = 0; $i < $num; $i += 1) {
                $left = $items[$i];

                if (isset($items[$i + 1]) == false) {
                    continue;
                }

                $right = $items[$i + 1];

                if ($left['priority'] == $right['priority']) {
                    fwrite(STDERR, print_r("a (" . $left['priority'] . ") is same priority as b (" . $right['priority'] . "), keeping the same\n"));
                    $new[] = $left;
                    $new[] = $right;
                } elseif ($left['priority'] < $right['priority']) {
                    fwrite(STDERR, print_r("a (" . $left['priority'] . ") is higher priority than b (" . $right['priority'] . "), moving b down array\n"));
                    $new[] = $left;
                    $new[] = $right;
                } else {
                    fwrite(STDERR, print_r("b (" . $right['priority'] . ") is higher priority than a (" . $left['priority'] . "), moving b up array\n"));
                    $new[] = $right;
                    $new[] = $left;
                };
            }
            $items = $new;
        }
        return $items;
    }
}