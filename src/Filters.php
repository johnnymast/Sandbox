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
     * @return bool
     */
    static function add_filter($tag = '', $callback = '', $priority = 10)
    {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$filters[$tag]) == false) {
            self::$filters[$tag] = [];
        }
        self::$filters[$tag][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];

        self::filterByPriority(self::$filters[$tag]);
        return true;
    }

    /**
     * @param string $tag
     * @param string $callback
     * @return bool
     */
    static function remove_filter($tag = '', $callback = '') {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$filters[$tag]) == true) {
            foreach(self::$filters[$tag] as $index => $item) {
                if ($item['callback'] == $callback) {
                    unset(self::$filters[$tag][$index]);
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param string $tag
     * @return bool
     */
    public function remove_all_filters($tag = '') {
        if (empty($tag))
            return false;

        if (isset(self::$filters[$tag])) {
            unset(self::$filters[$tag]);
            return true;
        }

        return false;
    }
    
    /**
     * @param string $filter
     * @param string $value
     * @return string
     */
    static function apply_filter($filter = '', $value = '')
    {
        if (is_array($filter)) {
            foreach ($filter as $single) {
                $value = self::execute_filter($single, $value);
            }
        } else {
            $value = self::execute_filter($filter, $value);
        }
        return $value;
    }
    
    /**
     * @param $tag
     * @param string $value
     * @return string
     */
    private static function execute_filter($tag, $value = '')
    {
        if (isset(self::$filters[$tag]) == false)
            return $value;

        reset(self::$filters[$tag]);
        
        do {

            $entry = current(self::$filters[$tag]);
            if (is_callable($entry['callback']))
                $value = call_user_func($entry['callback'], $value);

        } while (next(self::$filters[$tag]));

        return $value;
    }
}