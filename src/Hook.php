<?php
namespace Sandbox;

class Hook
{

    /**
     * @var string
     */
    protected $tag;

    /**
     * @var array
     */
    protected $hooks = [];


    /**
     * Hook constructor.
     * @param string $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param int $priority
     * @param string $callback
     */
    public function addHook($priority = 10, $callback = '')
    {
        $this->hooks[$priority][] = [
            'callback' => $callback,
            'priority' => $priority,
        ];
        ksort($this->hooks);
    }

    /**
     * @return array
     */
    public function getHooks()
    {
        return $this->hooks;
    }

    /**
     * @param int $priority
     * @param string $callback
     */
    public function removeCallbackWithPriority($priority = 10, $callback = '')
    {
        $hooks = $this->getHooks();
        if (isset($hooks[$priority]) == true) {
            $callbacks = $hooks[$priority];
            foreach ($callbacks as $index => $entry) {
                if ($entry['callback'] == $callback) {
                    unset($this->hooks[$priority][$index]);

                    if (count($this->hooks[$priority]) == 0) {
                        unset($this->hooks[$priority]);
                    }

                    if (count($this->hooks[$priority]) > 0) {
                        $newhooks = [];
                        foreach ($this->hooks[$priority] as $hook) {
                            $newhooks[] = $hook;
                        }
                        $this->hooks[$priority] = $newhooks;
                    }
                }
            }
        }
    }

    /**
     *
     */
    public function removeAllHooks()
    {
        unset($this->hooks);
    }
}
