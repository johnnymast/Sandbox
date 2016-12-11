<?php
namespace Sandbox\Tests\Filters;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersClosuresTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithOneClosure()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::addFilter('prepend_chars', function ($text) {
            return '@@' . $text;
        });
        $output = Sandbox\Filters::applyFilter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::applyFilter
     */
    public function testApplyFilterWorksCorrectWithTwoClosures()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::addFilter('apply_chars', function ($text) {
            return '@@' . $text;
        });

        Sandbox\Filters::addFilter('apply_chars', function ($text) {
            return $text . "@@";
        });

        $output = Sandbox\Filters::applyFilter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
