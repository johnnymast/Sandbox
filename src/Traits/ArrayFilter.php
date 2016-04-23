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
    public static function filterByPriority(&$items = []) {
        usort($items, function ($left, $right) {
            echo 'Checking: '.$left['priority'].' vs '.$right['priority']."\n";

            if ($left['priority'] === $right['priority']) {
                return 1;
            }

            if ($left['priority'] <= $right['priority']) {
                echo "LINKS\n";
                return 1;
            }
            return (((int)$left['priority'] > (int)$right['priority']) ? 1 : 0);
        });
    }
}