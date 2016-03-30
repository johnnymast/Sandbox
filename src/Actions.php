<?php

namespace Sandbox;


class Actions
{
    use Traits\ArrayFilter;

    /**
     * @var array
     */
    static private $actions = [];


    /**
     * @var array
     */
    static private $filters = [];


    static function debug()
    {
        //  print_r(self::$actions);
        print_r(self::$filters);
    }

    static function addFilter($tag = '', $callback = '', $priority = 10)
    {
        if (isset(self::$filters[$tag]) == false) {
            self::$filters[$tag] = [];
        }
        self::$filters[$tag][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];

        self::filterByPriority(self::$filters[$tag]);
    }

    static function applyFilter($filter = '', $value = '')
    {
        if (is_array($filter)) {
            foreach ($filter as $single) {
                $value = self::executeFilter($single, $value);
            }
        } else {
            $value = self::executeFilter($filter, $value);
        }
        return $value;
    }

    private static function executeFilter($tag, $value = '')
    {
        if (isset(self::$filters[$tag]) == false)
            return $value;

        do {

            $entry = current(self::$filters[$tag]);
            if (is_callable($entry['callback']))
                $value = call_user_func($entry['callback'], $value);

        } while (next(self::$filters[$tag]));

        return $value;
    }
}