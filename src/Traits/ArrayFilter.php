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
            if ($left['priority'] == $right['priority']) {
                return 0;
            }
            return $left['priority'] > $right['priority'] ? 1 : -1;
        });
    }
}