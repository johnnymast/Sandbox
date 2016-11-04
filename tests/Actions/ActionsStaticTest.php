<?php

namespace Sandbox\Tests\Actions;

use Sandbox;
use Sandbox\Tests\Actions\Assets;
use SebastianBergmann\PeekAndPoke\Proxy as Proxy;

class ActionsStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Actions::add_action
     */
    function test_add_action_returns_false_on_empty_tag()
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
    function test_add_action_returns_false_on_empty_callback()
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
    function test_add_action_returns_true_on_success()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {};
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
        };
        $expected = [
            'some_action' => [
                [
                    'callback' => $callback,
                    'priority' => 10,
                ]
            ]
        ];

        Sandbox\Actions::add_action('some_action', $callback);
        $this->assertEquals($expected, $property->getValue());
    }

    /**
     * @covers Sandbox\Actions::add_action
     */
    public function test_add_action_adds_multiple_actions()
    {
        Sandbox\Actions::cleanup();

        $callback1 = function () {
            return 'callback1';
        };
        $callback2 = function () {
            return 'callback1';
        };
        $expected = [
            'some_action' => [
                [
                    'callback' => $callback1,
                    'priority' => 10,
                ],
                [
                    'callback' => $callback2,
                    'priority' => 10,
                ],
            ]
        ];

        Sandbox\Actions::add_action('some_action', $callback1, 10);
        Sandbox\Actions::add_action('some_action', $callback2, 10);

        $got = Sandbox\Actions::getActions();
        $this->assertSame($expected, $got);
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

        $callback1 = function () {};
        $callback2 = function () {};
        $expected = [
            'some_action' => [
                [
                    'callback' => $callback1,
                    'priority' => 1,
                ],
                [
                    'callback' => $callback2,
                    'priority' => 0,
                ],
            ]
        ];
      //  $this->expectOutputString(''); // tell PHPUnit to expect '' as output

        Sandbox\Actions::add_action('some_action', $callback1, 1);
        Sandbox\Actions::add_action('some_action', $callback2, 0);

        $this->assertSame($expected['some_action'][1], $property->getValue()['some_action'][0]);

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

        $expected = [
            'do_some_things' => [
                [
                    'callback' => [$instance, 'first_function'],
                    'priority' => 10,
                ],
                [
                    'callback' => [$instance, 'second_function'],
                    'priority' => 10,
                ],
            ]
        ];
        //FIXME
        //$this->assertSame($expected, $property->getValue());
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    function test_remove_action_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_action('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Actions::remove_action
     */
    function test_remove_action_returns_false_on_empty_callback()
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
    function test_remove_action_removes_the_action_correctly()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);

        $reset_actions = function () use ($property) {
            $property->setValue([]);
        };
        $reset_actions();

        /**
         * Test callback is a string
         */
        Sandbox\Actions::add_action('some_action', 'callback1', 1);
        Sandbox\Actions::add_action('some_action', 'callback2', 2);
        Sandbox\Actions::remove_action('some_action', 'callback1');

        $expected = [
            'some_action' => [
                [
                    'callback' => 'callback2',
                    'priority' => 2
                ]
            ]
        ];
        $this->assertSame($expected, $property->getValue());
        $reset_actions();

        /**
         * Test callback is a closure
         */
        $callback1 = function () {
            return 1;
        };
        $callback2 = function () {
            return 2;
        };

        Sandbox\Actions::add_action('some_action', $callback1, 1);
        Sandbox\Actions::add_action('some_action', $callback2, 2);
        Sandbox\Actions::remove_action('some_action', $callback1);

        $expected = [
            'some_action' => [
                [
                    'callback' => $callback2, // FIXME: SHOULD FAIL
                    'priority' => 2
                ]
            ]
        ];
        // print_r($expected);
        $this->assertSame($expected, $property->getValue());
        $reset_actions();

        /**
         * Test callback is inside a class
         */
        $instance = new Sandbox\Tests\Actions\Assets\myMockClass1;
        Sandbox\Actions::remove_action('do_some_things', [$instance, 'first_function']);
        $expected = [
            'do_some_things' => [
                [
                    'callback' => [$instance, 'second_function'],
                    'priority' => 10,
                ]
            ]
        ];
        $this->assertSame($expected, $property->getValue());
        $reset_actions();
    }

    /**
     * @covers Sandbox\Actions::remove_all_actions
     */
    function test_remove_all_actions_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_all_actions('')
        );
    }

    /**
     * @covers Sandbox\Actions::remove_all_actions
     */
    function test_remove_all_actions_returns_true_on_success()
    {
        $callback = function () {
        };
        Sandbox\Actions::add_action('some_action', $callback, 1);

        $this->assertTrue(
            Sandbox\Actions::remove_all_actions('some_action')
        );
    }
}
