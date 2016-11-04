<?php

namespace Sandbox\Traits;


// TODO: EWW Get this into a file ..



trait ArrayFilter
{



    private function multiSort() {
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
        usort($array, function($a, $b) use($args) {

            $i = 0;
            $c = count($args);
            $cmp = 0;
            while($cmp == 0 && $i < $c)
            {
                $cmp = strcmp($a[ $args[ $i ] ], $b[ $args[ $i ] ]);
                $i++;
            }

            return $cmp;

        });

        return $array;

    }


    // FIXME: Remove tag
    public static function filterByPriority(&$items = [], $tag='') {
        /**
         * PHP Bug #70289 (https://bugs.php.net/bug.php?id=70289)
         * I had to write my own custom usort because on HHVM and PHP7+ usort will put equal priority
         * values on an earlier index while php 5 does the opposite of this. The PHP core team says its not
         * a bug but i find this a huge bug because i could not rely on the usort() function anymore.
         */

        $items = $this->multiSort($items, 'priority');
        return;
        return usort($items, multiSort('priority'));
        usort($items, function ($left, $right) {
            var_dump($left['priority']);
            echo "\n";
            var_dump($right['priority']);

            if ($left['priority'] === $right['priority']) {
                return 0;
            }
            return $left['priority'] >  $right['priority'] ? -1 : 1;
        });
        return;

        $new = [];
        $num = count($items);
        $verbose = false;

        if ($tag == 'test_add_filter_arranges_priority_correct' || $tag == 'prepend_at')
            $verbose = true;

        // equal set right before left
        // left gt right left first then right
        // right gt left first right then left
        // right et left left first then right

        /**
         * Keep in mind the order as ascending
         */
        if ($num > 1) {
            for ($i = 0; $i < $num; $i ++) {
                $left = $items[$i];

                if (isset($items[$i + 1]) == false) {
                    continue;
                }

                $right = $items[$i + 1];

                if ($left['priority'] === $right['priority']) {
                    if ($verbose == true) fwrite(STDERR, print_r("left (" . $left['priority'] . ") is same priority as right (" . $right['priority'] . "), keeping the same\n"));
                    $new[] = $right;
                    $new[] = $left;
                } elseif ($left['priority'] < $right['priority']) {
                    if ($verbose == true) fwrite(STDERR, print_r("left (" . $left['priority'] . ") is lower priority than right (" . $right['priority'] . "), moving right up array\n"));
                    $new[] = $right;
                    $new[] = $left;
                } elseif($left['priority'] > $right['priority']) {
                    if ($verbose == true) fwrite(STDERR, print_r("left (" . $left['priority'] . ") is higher priority than right (" . $right['priority'] . "), moving left down array\n"));
                    $new[] = $right;
                    $new[] = $left;
                } elseif($right['priority'] > $left['priority']) {
                    if ($verbose == true) fwrite(STDERR, print_r("right (" . $right['priority'] . ") is higher priority than left (" . $left['priority'] . "), moving left up array\n"));

                    $new[] = $left;
                    $new[] = $right;

                }
            }
            $items = $new;
        }
    }
}