<?php

namespace Sandbox\Tests\Actions;

use Sandbox;
use Sandbox\Tests\Actions\Assets;

require_once dirname(__FILE__) . '/Assets/myCallbackFunctions.php';

/**
 * @since version 1.0
 * @covers Sandbox\Actions
 */
class ActionsFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param callable $callback
     * @return mixed
     */
    private function capture_test_output(callable $callback)
    {
        ob_start();
        call_user_func($callback);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    
    /**
     * @covers Sandbox\Actions::do_action
     */
    public function test_add_action_works_correct_with_one_actions()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);


        Sandbox\Actions::add_action('echo_astrrix', 'Sandbox\Tests\Actions\Assets\my_callback_functions_actions_output_asterix_symbol');

        $expected = '*';
        $output = $this->capture_test_output(
            function () {
                Sandbox\Actions::do_action('echo_astrrix');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Actions::do_action
     */
    public function test_add_action_works_correct_with_two_actions()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);


        Sandbox\Actions::add_action('echo_astrrix', 'Sandbox\Tests\Actions\Assets\my_callback_functions_actions_output_asterix_symbol');
        Sandbox\Actions::add_action('echo_at', 'Sandbox\Tests\Actions\Assets\my_callback_functions_actions_output_at_symbol');

        $expected = '*@';
        $output = $this->capture_test_output(
            function () {
                Sandbox\Actions::do_action('echo_astrrix');
                Sandbox\Actions::do_action('echo_at');
            }
        );
        $this->assertEquals($expected, $output);
    }
}
