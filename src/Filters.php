<?php
namespace Sandbox;

use Doctrine\Common\Annotations\AnnotationReader;

class Filters
{

    /**
     * @var array
     */
    static private $filters = [];

    /**
     * @var Annotations\FilterAnnotationHandler
     */
    static private $annotation_handler = null;

    /**
     * Initialize the Annotation Handler for
     * dealing with filter objects.
     */
    public static function init()
    {
        if (!self::$annotation_handler) {
            $reader = new AnnotationReader();
            self::$annotation_handler = new Annotations\FilterAnnotationHandler($reader);
        }
    }

    /**
     * @param $object
     */
    public static function register_filter_object($object)
    {
        self::init();
        self::$annotation_handler->read($object);
    }

    /**
     * @param string $tag
     * @param string $callback
     * @param int $priority
     * @return bool
     */
    public static function add_filter($tag = '', $callback = '', $priority = 10)
    {
        if (empty($tag) || empty($callback)) {
            return false;
        }

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
    public static function remove_filter($tag = '', $callback = '')
    {
        if (empty($tag) || empty($callback)) {
            return false;
        }

        if (isset(self::$filters[$tag]) === true) {
            $found = false;
            $hooks = self::$filters[$tag]->getHooks();

            foreach ($hooks as $priority => $callbacks) {
                foreach ($callbacks as $entry) {
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
    public static function remove_all_filters($tag = '')
    {
        if (empty($tag)) {
            return false;
        }

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
    public static function apply_filter($filter = '', $value = '')
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
        if (isset(self::$filters[$tag]) === false) {
            return $value;
        }

        $hooks = self::$filters[$tag]->getHooks();
        reset($hooks);

        foreach ($hooks as $priority => $callbacks) {
            do {
                $entry = current($callbacks);
                if (is_callable($entry['callback'])) {
                    $value = call_user_func($entry['callback'], $value);
                }
            } while (next($callbacks));
        }

        return $value;
    }
}
