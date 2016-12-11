<?php
namespace Sandbox\Tests\Actions;

use Sandbox;

/**
 * @since version 1.0
 * @covers Sandbox\Actions
 */
class ActionsFunctionsTest extends \PHPUnit_Framework_TestCase
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
    public function testAddActionWorksCorrectWithOneAction()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Sandbox\Actions::addAction('echo_astrix', 'Sandbox\Tests\Actions\Assets\outputAstrixSymbol');

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
    public function testAddActionWorksCorrectWithTwoActions()
    {
        $actions = new \ReflectionClass('Sandbox\Actions');
        $property = $actions->getProperty('actions');
        $property->setAccessible(true);
        $property->setValue([]);

        Sandbox\Actions::addAction('echo_astrix', 'Sandbox\Tests\Actions\Assets\outputAstrixSymbol');

        Sandbox\Actions::addAction('echo_at', 'Sandbox\Tests\Actions\Assets\outputAtSymbol');

        $expected = '*@';
        $output = $this->captureTestOutput(
            function () {
                Sandbox\Actions::doAction('echo_astrix');
                Sandbox\Actions::doAction('echo_at');
            }
        );
        $this->assertEquals($expected, $output);
    }

    /**
     * @covers Sandbox\Actions::doAction
     */
    public function testDoActionReturnsValueIfActionIsNotFound()
    {
        $this->assertEquals(Sandbox\Actions::doAction('someaction', 'value'), 'value');
    }
}
