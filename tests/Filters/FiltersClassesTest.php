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
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_one_class_function()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\myMockClass2;

        Sandbox\Filters::add_filter('prepend_chars', [$instance, 'prepend_chars']);
        $output = Sandbox\Filters::apply_filter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_two_class_functions()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';
        $instance = new Sandbox\Tests\Filters\Assets\myMockClass2;

        Sandbox\Filters::add_filter('apply_chars', [$instance, 'prepend_chars']);
        Sandbox\Filters::add_filter('apply_chars', [$instance, 'append_chars']);

        $output = Sandbox\Filters::apply_filter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
