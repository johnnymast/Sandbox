<?php
namespace Sandbox\Tests\Filters;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneFunction()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::addFilter('prepend_chars', 'Sandbox\Tests\Filters\Assets\filterPrepend');

        $output = Sandbox\Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoFunctions()
    {

        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::addFilter('apply_chars', 'Sandbox\Tests\Filters\Assets\filterPrepend');
        Sandbox\Filters::addFilter('apply_chars', 'Sandbox\Tests\Filters\Assets\filterAppend');
        $output = Sandbox\Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
