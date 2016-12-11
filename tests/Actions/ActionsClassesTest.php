<?php
namespace Sandbox\Tests\Actions;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Actions
 */
class FiltersClassesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param callable $callback
     * @return mixed
     */
    private function captureTestOutput(callable $callback)
    {
        ob_start();
        call_user_func($callback);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    /**
     * @covers Sandbox\Actions::doAction
     */
    public function testDoActionWorksCorrectWithOneClassMethod()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\MockClass2;


        Sandbox\Actions::addAction('echo_astrix', [$instance, 'outputAstrixSymbol']);

        $expected = '*';
        $output = $this->captureTestOutput(
            function () {
                Sandbox\Actions::doAction('echo_astrix');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Actions::doAction
     */
    public function testDoActionWorksCorrectWithTwoClassMethods()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        $instance = new Sandbox\Tests\Actions\Assets\MockClass2;


        Sandbox\Actions::addAction('echo_astrix', [$instance, 'outputAstrixSymbol']);
        Sandbox\Actions::addAction('echo_at', [$instance, 'outputAtSymbol']);

        $expected = '*@';
        $output = $this->captureTestOutput(
            function () {
                Sandbox\Actions::doAction('echo_astrix');
                Sandbox\Actions::doAction('echo_at');
            }
        );
        $this->assertEquals($expected, $output);
    }
}
