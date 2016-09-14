<?php
namespace Sandbox\Tests\Filters;

use Sandbox;
use Sandbox\Tests\Filters\Assets;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Filters::add_filter
     */
    function test_add_filter_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::add_filter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    function test_add_filter_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Filters::add_filter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    function test_add_filter_returns_true_on_success()
    {
        $callback = function () {};
        $this->assertTrue(
            Sandbox\Filters::add_filter('some_tag', $callback)
        );
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_adds_filter()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {};
        $expected = [
            'new_filter' => [
                [
                    'callback' => $callback,
                    'priority' => 10,
                ]
            ]
        ];

        Sandbox\Filters::add_filter('new_filter', $callback);
        $this->assertEquals($expected, $property->getValue());
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_adds_multiple_filters()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {};
        $callback2 = function () {};
        $expected = [
            'new_filter' => [
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

        Sandbox\Filters::add_filter('new_filter', $callback1);
        Sandbox\Filters::add_filter('new_filter', $callback2);
        $this->assertEquals($expected, $property->getValue());
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_arranges_priority_correct()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {};
        $callback2 = function () {};
        $expected = [
            'test_add_filter_arranges_priority_correct' => [
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

        Sandbox\Filters::add_filter('test_add_filter_arranges_priority_correct', $callback1, 1);
        Sandbox\Filters::add_filter('test_add_filter_arranges_priority_correct', $callback2, 0);
        $x = $property->getValue();

        $this->assertSame($expected['test_add_filter_arranges_priority_correct'][1]['priority'], $property->getValue()['test_add_filter_arranges_priority_correct'][0]['priority']);
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_in_class_method_has_the_correct_callback()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Filters\Assets\myMockClass1;

        $expected = [
            'manipulate_string' => [
                [
                    'callback' => [$instance, 'prepend_chars'],
                    'priority' => 10,
                ],
                [
                    'callback' => [$instance, 'append_chars'],
                    'priority' => 10,
                ],
            ]
        ];
        $x = $property->getValue();
        // FIXME
       // $this->assertSame($expected, $property->getValue());
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    function test_remove_filter_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_filter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    function test_remove_filter_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_filter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    function test_remove_filter_returns_true_on_success()
    {
        $callback = function () {};
        Sandbox\Filters::add_filter('some_filter', $callback);

        $this->assertTrue(
            Sandbox\Filters::remove_filter('some_filter', $callback)
        );
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    function test_remove_filter_removes_the_filter_correctly()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);

        $reset_filter = function() use ($property) {
            $property->setValue([]);
        };
        $reset_filter();

        /**
         * Test callback is a string
         */
        Sandbox\Filters::add_filter('some_filter', 'callback1', 1);
        Sandbox\Filters::add_filter('some_filter', 'callback2', 2);
        Sandbox\Filters::remove_filter('some_filter', 'callback1');

        $expected = [
            'some_filter' => [
                [
                    'callback' => 'callback2',
                    'priority' => 2
                ]
            ]
        ];
        $this->assertSame($expected, $property->getValue());
        $reset_filter();

        /**
         * Test callback is a closure
         */
        $callback1 = function () {};
        $callback2 = function () {};
        Sandbox\Filters::add_filter('some_filter', $callback1, 1);
        Sandbox\Filters::add_filter('some_filter', $callback2, 2);
        Sandbox\Filters::remove_filter('some_filter', $callback1);

        $expected = [
            'some_filter' => [
                [
                    'callback' => $callback2,
                    'priority' => 2
                ]
            ]
        ];
        $this->assertSame($expected, $property->getValue());
        $reset_filter();

        /**
         * Test callback is inside a class
         */
        $instance = new Sandbox\Tests\Filters\Assets\myMockClass1;
        Sandbox\Filters::remove_filter('manipulate_string', [$instance, 'prepend_chars']);
        $expected = [
            'manipulate_string' => [
                [
                    'callback' => [$instance, 'append_chars'],
                    'priority' => 10,
                ]
            ]
        ];
        $this->assertSame($expected, $property->getValue());
        $reset_filter();
    }

    /**
     * @covers Sandbox\Filters::remove_all_filters
     */
    function test_remove_all_filters_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_all_filters('')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_all_filters
     */
    function test_remove_all_filters_returns_true_on_success()
    {
        $callback = function () {};
        Sandbox\Filters::add_filter('some_filter', $callback, 1);

        $this->assertTrue(
            Sandbox\Filters::remove_all_filters('some_filter')
        );
    }
}
