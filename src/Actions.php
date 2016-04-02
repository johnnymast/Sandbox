<?php
/**
 * Created by PhpStorm.
 * User: developer
 * Date: 30-03-16
 * Time: 21:41
 */

namespace Sandbox;


class Actions
{
    use Traits\ArrayFilter;

    /**
     * @var array
     */
    private static $actions = [];


    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     * @return bool
     */
    public static function add_action($tag = '', $callback = '', $priority = 10)
    {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$actions[$tag]) === false) {
            self::$actions[$tag] = [];
        }
        self::$actions[$tag][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];

        self::filterByPriority(self::$actions[$tag]);
        return true;
    }

    /**
     * @param string $action
     * @param string $value
     * @return string
     */
    public static function do_action($action = '', $value = '')
    {
        if (is_array($action)) {
            foreach ($action as $single) {
                $value = self::execute_action($single, $value);
            }
        } else {
            $value = self::execute_action($action, $value);
        }
        return $value;
    }

    /**
     * @param $tag
     * @param string $value
     * @return string
     */
    private static function execute_action($tag, $value = '')
    {
        if (isset(self::$actions[$tag]) === false)
            return $value;

        reset(self::$actions[$tag]);

        do {

            $entry = current(self::$actions[$tag]);

            if (is_callable($entry['callback']))
                call_user_func($entry['callback'], $value);

        } while (next(self::$actions[$tag]));

        // FIXME
        return $value;
    }

    /**
     * @param string $tag
     * @param string $callback
     * @return bool
     */
    static public function remove_action($tag = '', $callback = '')
    {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$actions[$tag]) === true) {
            $data = array();
            $found = false;

            foreach (self::$actions[$tag] as $item) {
                if ($item['callback'] == $callback) {
                    $found = true;
                } else {
                    $data[] = $item;
                }
            }

            self::$actions[$tag] = $data;
            return $found;
        }
        return false;
    }

    /**
     * @param string $tag
     * @return bool
     */
    static public function remove_all_actions($tag = '')
    {
        if (empty($tag))
            return false;

        if (isset(self::$actions[$tag])) {
            unset(self::$actions[$tag]);
            return true;
        }

        return false;
    }
}