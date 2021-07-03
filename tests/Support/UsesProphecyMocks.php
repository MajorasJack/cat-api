<?php

namespace Tests\Support;

use Closure;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;
use Prophecy\Argument;

trait UsesProphecyMocks
{
    /**
     * @var Prophet
     */
    protected Prophet $prophet;

    /**
     * @var Argument
     */
    protected Argument $argument;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->prophet = new Prophet;
        $this->argument = new Argument;
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        if ($this->prophet->getProphecies()) {
            $this->prophet->checkPredictions();
            // The above is an assertion (it will fail if expected calls aren't made/
            // unexpected calls are made) but phpunit doesn't recognise these. If no
            // exception is thrown here, assert true to stop phpunit reporting the
            // test as risky if no other assertions are made.
            $this->assertTrue(true);
        }
        parent::tearDown();
    }

    /**
     * @param $abstract
     * @param Closure|null $mock
     * @return ObjectProphecy
     */
    public function mock($abstract, ?Closure $mock = null): ObjectProphecy
    {
        return $this->prophet->prophesize($abstract);
    }

    /**
     * @param string $facade
     * @param ObjectProphecy $mock
     * @param $resolver
     * @return void
     */
    public function facadeShouldReturn(string $facade, ObjectProphecy $mock, $resolver)
    {
        $manager = $this->mock(get_class($facade::getFacadeRoot()));
        switch (gettype($resolver)) {
            case 'string' :
                $manager->$resolver()->shouldBeCalled()->willReturn($mock->reveal());
                break;
            case 'array':
                foreach ($resolver as $callback) {
                    $callback($manager)->shouldBeCalled()->willReturn($mock->reveal());
                }
                break;
            case 'object':
                $resolver($manager)->shouldBeCalled()->willReturn($mock->reveal());
                break;
            default:
                throw new BadArgumentException(
                    'Invalid resolver in UsesProphecyMocks::facadeShouldReturn'
                );
        }
        $facade::swap($manager->reveal());
    }
}
