<?php
namespace Sandbox;
use Doctrine\Common\Annotations\AnnotationReader;
use Sandbox\Hook;

class Filters
{

    /**
     * @var array
     */
    static private $filters = [];

    /**
     * @var Annotations\FilterAnnotationHandler
     */
    static private $annotaion_handler = null;

    /**
     * Initialize the Annotation Handler for
     * dealing with filter objects.
     */
    static public function init() {
        if (!self::$annotaion_handler) {
            $reader = new AnnotationReader();
            self::$annotaion_handler = new Annotations\FilterAnnotationHandler($reader);
        }
    }

    /**
     * @param $object
     */
    static public function register_filter_object($object) {
        self::init();
        self::$annotaion_handler->read($object);
    }

    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     * @return bool
     */
    static public function add_filter($tag = '', $callback = '', $priority = 10)
    {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$filters[$tag]) === false) {
            self::$filters[$tag] = new Hook($tag);
        }

        self::$filters[$tag]->addHook($priority, $callback);

        return true;
    }

    /**
     * @param string $tag
     * @param string $callback
     * @return bool
     */
    static public function remove_filter($tag = '', $callback = '')
    {
        if (empty($tag) || empty($callback))
            return false;

        if (isset(self::$filters[$tag]) === true) {
            $found = false;
            $hooks = self::$filters[$tag]->getHooks();

            foreach($hooks as $priority => $callbacks) {
                foreach($callbacks as $entry) {
                    if ($entry['callback'] == $callback) {
                        self::$filters[$tag]->removeCallbackWithPriority($priority, $callback);
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
    static public function remove_all_filters($tag = '')
    {
        if (empty($tag))
            return false;

        if (isset(self::$filters[$tag])) {
            self::$filters[$tag]->removeAllHooks();
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
    static public function apply_filter($filter = '', $value = '')
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
        if (isset(self::$filters[$tag]) === false)
            return $value;

        $hooks = self::$filters[$tag]->getHooks();
        reset($hooks);

        foreach($hooks as $priority => $callbacks) {
            do {

                $entry = current($callbacks);
                if (is_callable($entry['callback']))
                    $value = call_user_func($entry['callback'], $value);

            } while (next($callbacks));
        }
        return $value;
    }
}