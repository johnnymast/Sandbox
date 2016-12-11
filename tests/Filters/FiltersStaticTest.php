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
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Sandbox\Filters::addFilter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterReturnsFalseOnEmptyCallback()
    {
        $this->assertFalse(
            Sandbox\Filters::addFilter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        $this->assertTrue(
            Sandbox\Filters::addFilter('some_tag', $callback)
        );
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterAddsFilterCorrectly()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () {
            /* void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback);

        Sandbox\Filters::addFilter($tag, $callback);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterAddsMultipleFiltersCorrectly()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () {
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        $tag = 'new_filter';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, $callback1);
        $hook->addHook($priority, $callback2);

        Sandbox\Filters::addFilter($tag, $callback1);
        Sandbox\Filters::addFilter($tag, $callback2);

        $actual = $property->getValue()[$tag];
        $expected = $hook;
        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterSortsPriorityCorrect()
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

        Sandbox\Filters::addFilter($tag, $callback1, 1);
        Sandbox\Filters::addFilter($tag, $callback2, 0);

        /** @var Sandbox\Hook $hooks */
        /** @var \ReflectionProperty $property */

        $hooks = $property->getValue()[$tag];
        $actual = $hooks->getHooks()[0][0];
        $expected = $hook->getHooks()[0][0];

        $this->assertSame($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::addFilter
     */
    public function testAddFilterInClassMethodHasTheCorrectCallback()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Filters\Assets\MockClass1;

        $tag = 'manipulate_string';
        $priority = 10;

        $hook = new Sandbox\Hook($tag);
        $hook->addHook($priority, [$instance, 'prependChars']);
        $hook->addHook($priority, [$instance, 'appendChars']);

        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Sandbox\Filters::removeFilter('', 'some_callback')
        );
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseOnEmptyCallback()
    {
        $this->assertFalse(
            Sandbox\Filters::removeFilter('some_tag', '')
        );
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Sandbox\Filters::addFilter('some_filter', $callback);

        $this->assertTrue(
            Sandbox\Filters::removeFilter('some_filter', $callback)
        );
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterActuallyRemovesTheFilter()
    {
        $tag = 'shiny_new_filter';
        $priority = 10;

        $callback = function ($string) {
            return $string . '@';
        };

        Sandbox\Filters::addFilter($tag, $callback, $priority);

        $expected = '';
        Sandbox\Filters::removeFilter($tag, $callback);

        $actual = Sandbox\Filters::applyFilter($tag, '');


        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterRemovesTheFilterCorrectly()
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
        Sandbox\Filters::addFilter($tag, 'callback1', 1);
        Sandbox\Filters::addFilter($tag, 'callback2', 2);
        Sandbox\Filters::removeFilter($tag, 'callback1');

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
            /* void */
        };

        $callback2 = function () {
            /* void */
        };

        Sandbox\Filters::addFilter('some_filter', $callback1, 1);
        Sandbox\Filters::addFilter('some_filter', $callback2, 2);
        Sandbox\Filters::removeFilter('some_filter', $callback1);

        $hook = new Sandbox\Hook($tag);
        $hook->addHook(2, $callback2);


        $expected = $hook;
        $actual = $property->getValue()[$tag];

        $this->assertEquals($expected, $actual);
        $reset_filter();

        /**
         * Test callback is inside a class
         */
        $instance = new Sandbox\Tests\Filters\Assets\MockClass1;
        Sandbox\Filters::removeFilter('manipulate_string', [$instance, 'prependChars']);

        $hook = new Sandbox\Hook('manipulate_string');
        $hook->addHook(10, [$instance, 'appendChars']);

        $expected = $hook;
        $actual = $property->getValue()['manipulate_string'];

        $this->assertEquals($expected, $actual);
        $reset_filter();
    }

    /**
     * @covers Sandbox\Filters::removeFilter
     */
    public function testRemoveFilterReturnsFalseIfFilterCouldNotBeFound()
    {
        $this->assertFalse(Sandbox\Filters::removeFilter('i_do_not_exist', 'no_callback_here'));
    }

    /**
     * @covers Sandbox\Filters::removeAllFilters
     */
    public function testRemoveAllFiltersReturnsFalseOnEmptyTag()
    {
        $this->assertFalse(
            Sandbox\Filters::removeAllFilters('')
        );
    }

    /**
     * @covers Sandbox\Filters::removeAllFilters
     */
    public function testRemoveAllFiltersReturnsTrueOnSuccess()
    {
        $callback = function () {
            /* void */
        };

        Sandbox\Filters::addFilter('some_filter', $callback, 1);

        $this->assertTrue(
            Sandbox\Filters::removeAllFilters('some_filter')
        );
    }

    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterReturnsValueIfActionIsNotFound()
    {
        $this->assertEquals(Sandbox\Filters::applyFilter('some_filter', 'value'), 'value');
    }
}
