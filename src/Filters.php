<?php
namespace Sandbox;


class Filters
{
    use Traits\ArrayFilter;

    /**
     * @var array
     */
    static private $filters = [];
    
    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     */
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

    /**
     * @param string $filter
     * @param string $value
     * @return string
     */
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

    /**
     * @param $tag
     * @param string $value
     * @return string
     */
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