<?php
namespace Sandbox\Tests\Filters;
use Sandbox\Tests\Filters\Assets;
use Sandbox;

/**
 * TODO: Lege string ..
 *
 *
 */
class FiltersStaticTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function test_add_filter_adds_filter() {
        $filters  = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback = function () { };
        $testagaints = [
            'new_filter' => [
                [
                    'callback' => $callback,
                    'priority' => 10,
                ]
            ]
        ];

        Sandbox\Filters::add_filter('new_filter', $callback);
        $this->assertEquals($testagaints, $property->getValue());
    }

    /**
     *
     */
    public function test_add_filter_adds_multiple_filters() {
        $filters  = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () { };
        $callback2 = function () { };
        $testagaints = [
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
        $this->assertEquals($testagaints, $property->getValue());
    }

    /**
     *
     */
    public function test_add_filter_arranges_priority_correct() {
        $filters  = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $callback1 = function () { };
        $callback2 = function () { };
        $testagaints = [
            'new_filter' => [
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

        Sandbox\Filters::add_filter('new_filter', $callback1, 1);
        Sandbox\Filters::add_filter('new_filter', $callback2, 0);

        $this->assertEquals($testagaints['new_filter'][1], $property->getValue()['new_filter'][0]);
    }

    //FIXME: Implement this when im not drunk ...

    public function test_add_filter_in_class_method_has_the_correct_callback() {
        $filters  = new \ReflectionClass('Sandbox\Filters');
        $property = $filters->getProperty('filters');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Filters\Assets\myMobclass1;

        $testagaints = [
            'manipulate_string' => [
                [
                    'callback' => [$instance, 'append_chars'],
                    'priority' => 10,
                ],
                [
                    'callback' => [$instance, 'prepend_chars'],
                    'priority' => 10,
                ],
            ]
        ];
        $this->assertEquals($testagaints, $property->getValue());
    }
}
