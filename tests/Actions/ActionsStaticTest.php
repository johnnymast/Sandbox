<?php

namespace Sandbox\Tests\Filters\Actions;

use Sandbox;
use Sandbox\Tests\Actions\Assets;

class ActionsStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    function test_add_action_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::add_action('', 'some_callback')
        );
    }

    /**
     *
     */
    function test_add_action_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Actions::add_action('some_action', '')
        );
    }

    /**
     *
     */
    function test_add_action_returns_true_on_success()
    {
        $callback = function () {
        };
        $this->assertTrue(
            Sandbox\Actions::add_action('some_action', $callback)
        );
    }

    /**
     *
     */
    public function test_add_action_adds_action()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
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
     *
     */
    public function test_add_action_adds_multiple_filters()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
        };
        $callback2 = function () {
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

        Sandbox\Actions::add_action('some_action', $callback1);
        Sandbox\Actions::add_action('some_action', $callback2);
        $this->assertEquals($expected, $property->getValue());
    }

    /**
     *
     */
    public function test_add_action_arranges_priority_correct()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
        };
        $callback2 = function () {
        };
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

        Sandbox\Actions::add_action('some_action', $callback1, 1);
        Sandbox\Actions::add_action('some_action', $callback2, 0);

        $this->assertEquals($expected['some_action'][1], $property->getValue()['some_action'][0]);
    }

    /**
     *
     */
    public function test_add_action_in_class_method_has_the_correct_callback()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
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
        $this->assertSame($expected, $property->getValue());
    }

    /**
     *
     */
    function test_remove_action_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_action('', 'some_callback')
        );
    }

    /**
     *
     */
    function test_remove_action_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_action('some_action', '')
        );
    }

    /**
     *
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
     *
     */
    function test_remove_action_removes_the_action_correctly()
    {
        $filters = new \ReflectionClass('Sandbox\Actions');
        $property = $filters->getProperty('actions');
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
     *
     */
    function test_remove_all_actions_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Actions::remove_all_actions('')
        );
    }

    /**
     *
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
