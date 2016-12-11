<?php
namespace Sandbox\Tests\Filters;

use Sandbox;
use Sandbox\Tests\Filters\Assets\FilterObject;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FilterObjectTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test that Filter Object Loads the Objects correctly.
     *
     * @covers Sandbox\Filters::registerFilterObject
     */
    public function testRegisterFilterObjectLoadsClasses()
    {
        $testObject = new FilterObject();
        Sandbox\Filters::registerFilterObject($testObject);
        Sandbox\Filters::removeAllFilters('prepend_at');
    }

    /**
     * Test that Sandbox\Filters::applyFilter triggers a filter
     * inside the filter Object.
     *
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksOnFilterObject()
    {
        $testObject = new FilterObject();
        Sandbox\Filters::registerFilterObject($testObject);

        $string = 'Hello World';
        $expected = '@!!'.$string;
        $actual = Sandbox\Filters::applyFilter('prepend_at', $string);
        $this->assertEquals($expected, $actual);
        Sandbox\Filters::removeAllFilters('prepend_at');
    }

    /**
     * Test that filters can be removed using Sandbox\Filters::removeFilter
     * from inside a filter Object.
     *
     * @covers Sandbox\Filters::removeFilter
     */
    public function testFiltersCanBeRemovedFromInsideFilterObject()
    {
        $testObject = new FilterObject();
        Sandbox\Filters::registerFilterObject($testObject);

        $string = 'Hello World';
        $expected = '@!!'.$string;
        $actual = Sandbox\Filters::applyFilter('prepend_at', $string);
        $this->assertEquals($expected, $actual);

        /**
         * Trigger removal of one instance of the prepend_at filter.
         */
        Sandbox\Filters::applyFilter('remove_filter_test', $string);

        $string = 'Hello World';
        $expected = '@'.$string;
        $actual = Sandbox\Filters::applyFilter('prepend_at', $string);

        $this->assertEquals($expected, $actual);
        Sandbox\Filters::removeAllFilters('prepend_at');
    }
}
