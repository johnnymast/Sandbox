<?php
namespace Sandbox\Tests\Filters;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersClassesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneClassMethod()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\MockClass2;

        Sandbox\Filters::addFilter('prepend_chars', [$instance, 'prependChars']);
        $output = Sandbox\Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoClassMethods()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\MockClass2;

        Sandbox\Filters::addFilter('apply_chars', [$instance, 'prependChars']);
        Sandbox\Filters::addFilter('apply_chars', [$instance, 'appendChars']);

        $output = Sandbox\Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
