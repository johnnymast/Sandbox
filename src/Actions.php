<?php
namespace Sandbox;


class Actions
{
    use Traits\ArrayFilter;

    /**
     * @var array
     */
    private static $actions = [];

    /**
     * @return Actions
     */
    public static function get_instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new Actions();
        }
        return $inst;
    }

    public static function getActions() {
        return self::$actions;
    }



    public static function cleanup() {
        //unset(self::$actions);
       self::$actions = [];
    }

    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     * @return bool
     */
    public static function add_action($tag = '', $callback = '', $priority = 10)
    {
        if (empty($tag) || empty($callback)) {
            return false;
        }

        if (isset(self::$actions[$tag]) === false) {
            self::$actions[$tag] = new Hook($tag);
        }

        self::$actions[$tag]->addHook($priority, $callback);

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
        if (isset(self::$actions[$tag]) === false) {
            return $value;
        }

        $hooks = self::$actions[$tag]->getHooks();
        reset(self::$actions[$tag]);

        foreach($hooks as $priority => $callbacks) {
            do {

                $entry = current($callbacks);
                if (is_callable($entry['callback']))
                    $value = call_user_func($entry['callback'], $value);

            } while (next($callbacks));
        }
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
            $found = false;
            $hooks = self::$actions[$tag]->getHooks();

            foreach($hooks as $priority => $callbacks) {
                foreach($callbacks as $entry) {
                    if ($entry['callback'] == $callback) {
                        self::$actions[$tag]->removeCallbackWithPriority($priority, $callback);
                        $found = true;
                    }
                }
            }
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
        if (empty($tag)) {
            return false;
        }

        if (isset(self::$actions[$tag])) {
            self::$actions[$tag]->removeAllHooks();
            unset(self::$actions[$tag]);
            return true;
        }
        return false;
    }
}