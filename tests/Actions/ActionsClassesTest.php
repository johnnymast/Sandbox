<?php
namespace Sandbox\Tests\Actions;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Actions
 */
class FiltersClassesTest extends \PHPUnit_Framework_TestCase
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
    public function test_do_action_works_correct_with_one_class_function()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\myMockClass2;


        Sandbox\Actions::add_action('echo_astrix', [$instance, 'output_astrix_symbol']);

        $expected = '*';
        $output = $this->capture_test_output(
            function () {
                Sandbox\Actions::do_action('echo_astrix');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Actions::do_action
     */
    public function test_do_action_works_correct_with_two_class_functions()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\myMockClass2;


        Sandbox\Actions::add_action('echo_astrix', [$instance, 'output_astrix_symbol']);
        Sandbox\Actions::add_action('echo_at', [$instance, 'output_at_symbol']);

        $expected = '*@';
        $output = $this->capture_test_output(
            function () {
                Sandbox\Actions::do_action('echo_astrix');
                Sandbox\Actions::do_action('echo_at');
            }
        );
        $this->assertEquals($expected, $output);
    }
}
