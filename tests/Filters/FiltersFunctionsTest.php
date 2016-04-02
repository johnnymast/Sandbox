<?php
namespace Sandbox\Tests\Filters;

use Sandbox;
use Sandbox\Tests\Filters\Assets;

require_once dirname(__FILE__) . '/Assets/myCallbackFunctions.php';

/**
 * @since version 1.0
 * @covers Sandbox\Filters
 */
class FiltersFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_one_function()
    {
        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::add_filter('prepend_chars', 'Sandbox\Tests\Filters\Assets\my_callback_functions_filter_prepend');
        $output = Sandbox\Filters::apply_filter('prepend_chars', $string);

        $expected = '@@' . $string;
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Filters::apply_filter
     */
    public function test_apply_filter_works_correct_with_two_functions()
    {

        $filters = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $string = 'Hello World';

        Sandbox\Filters::add_filter('apply_chars', 'Sandbox\Tests\Filters\Assets\my_callback_functions_filter_prepend');
        Sandbox\Filters::add_filter('apply_chars', 'Sandbox\Tests\Filters\Assets\my_callback_functions_filter_append');
        $output = Sandbox\Filters::apply_filter('apply_chars', $string);

        $expected = '@@' . $string . '@@';
        $this->assertEquals($expected, $output);
    }
}
