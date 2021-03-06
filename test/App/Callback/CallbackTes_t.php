<?php

namespace rollun\test\skeleton\Callback;

use rollun\callback\Callback\Callback;
use rollun\test\skeleton\Callback\CallbackTestDataProvider;
use rollun\promise\Promise\Promise;
use rollun\dic\InsideConstruct;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-09-20 at 12:54:48.
 */
class CallbackTest extends CallbackTestDataProvider
{

    protected function setUp()
    {
        $container = include 'config/container.php';
        InsideConstruct::setContainer($container);
    }

    /**
     * @covers \rollun\callback\Callback\Callback::__invoke
     * @dataProvider provider_mainType()
     */
    public function test__invoke($callable, $val, $expected)
    {
        $callback = new Callback($callable);
        /* @var $callback Callback */
        $this->assertEquals($expected, $callback($val));
    }

    /**
     * @covers \rollun\callback\Callback\Callback::__sleep
     * @dataProvider provider_mainType()
     */
    public function test__sleep($callable, $val, $expected)
    {
        $callback = new Callback($callable);
        /* @var $callback Callback */
        $this->assertEquals('array', gettype($callback->__sleep()));
    }

    /**
     * @covers \rollun\callback\Callback\Callback::__wakeup
     * @dataProvider provider_mainType()
     */
    public function test__wakeup($callable, $val, $expected)
    {
        $callback = new Callback($callable);
        /* @var $callback Callback */
        $wakeupedCallback = unserialize(serialize($callback));
        $this->assertEquals($expected, $wakeupedCallback($val));
    }

    /**
     * @covers \rollun\callback\Callback\Callback::__wakeup
     * @dataProvider provider_mainType()
     */
    public function test__wakeupWithPromise($callable, $val, $expected)
    {
        $callback = new Callback($callable);
        $wakeupedCallback = unserialize(serialize($callback));
        $masterPromise = new Promise();
        $slavePromise = $masterPromise->then($wakeupedCallback);
        $masterPromise->resolve($val);
        $this->assertEquals($expected, $slavePromise->wait(false));
    }

}
