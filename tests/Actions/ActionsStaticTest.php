<?php

namespace Sandbox\Tests\Actions;

use Sandbox;

class ActionsStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_returns_false_on_empty_tag()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);
        
        $this->assertFalse(
            Sandbox\Actions::add_action('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_returns_false_on_empty_callback()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $this->assertFalse(
            Sandbox\Actions::add_action('some_action', '')
        );
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_returns_true_on_success()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {
            /* Void */
        };

        $this->assertTrue(
            Sandbox\Actions::add_action('some_action', $callback)
        );
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_adds_action()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);


        $callback = function () {
            /* void */
        };

        $tag  = 'new_filter';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);

        Sandbox\Actions::add_action($tag, $callback);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_adds_multiple_actions()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'new_action';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback1);
        $hook->addHook($priority, $callback2);

        Sandbox\Actions::add_action($tag, $callback1);
        Sandbox\Actions::add_action($tag, $callback2);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_arranges_priority_correct()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'test_add_action_arranges_priority_correct';

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(1, $callback1);
        $hook->addHook(0, $callback2);

        Sandbox\Actions::add_action($tag, $callback1, 1);
        Sandbox\Actions::add_action($tag, $callback2, 0);

        $actual = $property->getValue()[$tag]->getHooks()[0][0];
        $expected = $hook->getHooks()[0][0];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_in_class_method_has_the_correct_callback()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\myMockClass1;

        $tag = 'do_some_things';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, [$instance, 'first_function']);
        $hook->addHook($priority, [$instance, 'second_function']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    public function test_remove_action_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_action('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    public function test_remove_action_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_action('some_action', '')
        );
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    function test_remove_action_returns_true_on_success()
    {
        $callback = function () {
        };
        Sandbox\Actions::add_action('some_action', $callback);

        $this->assertTrue(
            Sandbox\Actions::remove_action('some_action', $callback)
        );
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    public function test_remove_action_removes_the_action_correctly()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);

        $reset_actions = function () use ($property) {
            $property->setValue([]);
        };
        $reset_actions();

        $tag = 'some_action';

        /**
         * Test callback is a string
         */
        Sandbox\Actions::add_action($tag, 'callback1', 1);
        Sandbox\Actions::add_action($tag, 'callback2', 2);
        Sandbox\Actions::remove_action($tag, 'callback1');

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(2, 'callback2');

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();

        /**
         * Test callback is a closure
         */

        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        Sandbox\Actions::add_action($tag, $callback1, 1);
        Sandbox\Actions::add_action($tag, $callback2, 2);
        Sandbox\Actions::remove_action($tag, $callback1);

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(2, $callback2);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();

        /**
         * Test callback is inside a class
         */
        $tag = 'do_some_things';
        $instance = new Sandbox\Tests\Actions\Assets\myMockClass1;
        Sandbox\Actions::remove_action($tag, [$instance, 'first_function']);

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(10, [$instance, 'second_function']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_actions();
    }

    /**
     * @covers Sandbox\Actions::remove_all_actions
     */
    public function test_remove_all_actions_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_all_actions('')
        );
    }

    /**
     * @covers Sandbox\Actions::remove_all_actions
     */
    public function test_remove_all_actions_returns_true_on_success()
    {
        $callback = function () {
        };
        Sandbox\Actions::add_action('some_action', $callback, 1);

        $this->assertTrue(
            Sandbox\Actions::remove_all_actions('some_action')
        );
    }
}
