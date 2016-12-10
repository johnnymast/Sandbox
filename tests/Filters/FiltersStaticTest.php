<?php
namespace Sandbox\Tests\Filters;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::add_filter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Filters::add_filter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::add_filter
     */
    public function test_add_filter_returns_true_on_success()
    {
        $callback = function () {
        };
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

        $callback = function () {
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);

        Sandbox\Filters::add_filter($tag, $callback);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
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

        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback1);
        $hook->addHook($priority, $callback2);

        Sandbox\Filters::add_filter($tag, $callback1);
        Sandbox\Filters::add_filter($tag, $callback2);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
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


        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        $tag = 'test_add_filter_arranges_priority_correct';

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(1, $callback1);
        $hook->addHook(0, $callback2);

        Sandbox\Filters::add_filter($tag, $callback1, 1);
        Sandbox\Filters::add_filter($tag, $callback2, 0);

        $actual = $property->getValue()[$tag]->getHooks()[0][0];
        $expected = $hook->getHooks()[0][0];

        $this->assertSame($expected, $actual);
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

        $tag = 'manipulate_string';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, [$instance, 'prepend_chars']);
        $hook->addHook($priority, [$instance, 'append_chars']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    public function test_remove_filter_returns_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_filter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    public function test_remove_filter_returns_false_on_empty_callback()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_filter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    public function test_remove_filter_returns_true_on_success()
    {
        $callback = function () {
            /* Void */
        };

        Sandbox\Filters::add_filter('some_filter', $callback);

        $this->assertTrue(
            Sandbox\Filters::remove_filter('some_filter', $callback)
        );
    }

    public function test_remove_filter_actually_removes_the_filter()
    {
        $tag = 'shiny_new_filter';
        $priority = 10;

        $callback = function ($string) {
            return $string . '@';
        };

        Sandbox\Filters::add_filter($tag, $callback, $priority);

        $expected = '';
        Sandbox\Filters::remove_filter($tag, $callback);

        $actual = Sandbox\Filters::apply_filter($tag, '');


        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::remove_filter
     */
    public function test_remove_filter_removes_the_filter_correctly()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);

        $reset_filter = function () use ($property) {
            $property->setValue([]);
        };
        $reset_filter();

        $tag = 'some_filter';

        /**
         * Test callback is a string
         */
        Sandbox\Filters::add_filter($tag, 'callback1', 1);
        Sandbox\Filters::add_filter($tag, 'callback2', 2);
        Sandbox\Filters::remove_filter($tag, 'callback1');

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(2, 'callback2');

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_filter();

        /**
         * Test callback is a closure
         */
        $callback1 = function () {
            /* Void */
        };

        $callback2 = function () {
            /* Void */
        };

        Sandbox\Filters::add_filter('some_filter', $callback1, 1);
        Sandbox\Filters::add_filter('some_filter', $callback2, 2);
        Sandbox\Filters::remove_filter('some_filter', $callback1);

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(2, $callback2);


        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_filter();

        /**
         * Test callback is inside a class
         */
        $instance = new Sandbox\Tests\Filters\Assets\myMockClass1;
        Sandbox\Filters::remove_filter('manipulate_string', [$instance, 'prepend_chars']);

        $hook = new Sandbox\Hook('manipulate_string');
        $hook->addHook(10, [$instance, 'append_chars']);

        $expected = $hook;
        $actual = $property->getValue()['manipulate_string'];

        $this->assertEquals($expected, $actual);
        $reset_filter();
    }

    /**
     * @covers Sandbox\Filters::remove_all_filters
     */
    public function test_remove_all_filters_false_on_empty_tag()
    {
        $this->assertFalse(
            Sandbox\Filters::remove_all_filters('')
        );
    }

    /**
     * @covers Sandbox\Filters::remove_all_filters
     */
    public function test_remove_all_filters_returns_true_on_success()
    {
        $callback = function () {
            /* Void */
        };

        Sandbox\Filters::add_filter('some_filter', $callback, 1);

        $this->assertTrue(
            Sandbox\Filters::remove_all_filters('some_filter')
        );
    }
}
