<?php

namespace Tests\Support\Traits;

use Prophecy\Exception\Prediction\AggregateException;
use Prophecy\Prophecy\ObjectProphecy;
use Prophecy\Prophet;

trait UsesProphecyMocks
{
    /**
     * An instance of Prophet used to generate mocks
     *
     * @var Prophet
     */
    protected $prophet;
    /**
     * Camel cased as it extends a phpunit method.
     *
     * Check that any predictions/expectationsdeclared on mocks made are
     * fulfilled, and that no extra calls were made that were not expected.
     *
     * `checkPredictions()` does this and behaves as an assertion, but throws
     * errors rather than passing or failing a test. For this reason, convert
     * any exceptions into a pass/fail message.
     *
     * @return void
     */
    public function tearDown(): void
    {
        if ($this->prophet && $this->prophet->getProphecies()) {
            try {
                $this->prophet->checkPredictions();
                $this->assertTrue(true);
            } catch (AggregateException $e) {
                $this->fail($e->getMessage());
            }
        }
        parent::tearDown();
    }

    /**
     * Create and return a mocked version of the given class, on which
     * expectations can be declared.
     *
     * @param string $class The class to be mocked.
     * @return ObjectProphecy
     */
    public function mock(string $class): ObjectProphecy
    {
        if (!$this->prophet) {
            $this->prophet = new Prophet();
        }
        return $this->prophet->prophesize($class);
    }
}
