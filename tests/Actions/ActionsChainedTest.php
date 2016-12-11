<?php
namespace Sandbox\Tests\Actions;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Actions
 */
class FiltersChainedTest extends \PHPUnit_Framework_TestCase
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

        Sandbox\Actions::addAction('echo_astrix', function () {
            echo '*';
        });

        $expected = '*';
        $output = $this->captureTestOutput(
            function () {
                Sandbox\Actions::doAction(['echo_astrix']);
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

        Sandbox\Actions::addAction('echo_astrix', function () {
            echo '*';
        });

        Sandbox\Actions::addAction('echo_at', function () {
            echo '@';
        });

        $expected = '*@';
        $output = $this->captureTestOutput(
            function () {
                Sandbox\Actions::doAction(['echo_astrix', 'echo_at']);
            }
        );
        $this->assertEquals($expected, $output);
    }
}
