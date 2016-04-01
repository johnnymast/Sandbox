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
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_one_closure()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::add_filter('prepend_chars', function ($text) {
            return '@@' . $text;
        });
        $output = Sandbox\Filters::apply_filter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_two_closures()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::add_filter('apply_chars', function ($text) {
            return '@@' . $text;
        });

        Sandbox\Filters::add_filter('apply_chars', function ($text) {
            return $text . "@@";
        });

        $output = Sandbox\Filters::apply_filter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
