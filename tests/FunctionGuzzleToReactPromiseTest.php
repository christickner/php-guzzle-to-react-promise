<?php

namespace Tickner\GuzzleToReactPromise;

use GuzzleHttp\Promise\Promise as GuzzlePromise;
use PHPUnit\Framework\TestCase;
use React\Promise\Promise as ReactPromise;

final class FunctionGuzzleToReactPromiseTest extends TestCase
{
    /**
     * @test
     */
    public function it_converts_a_guzzle_promise_to_a_react_promise()
    {
        $guzzlePromise = new GuzzlePromise();
        $reactPromise = \Tickner\GuzzleToReactPromise\guzzleToReactPromise($guzzlePromise);
        static::assertInstanceOf(ReactPromise::class, $reactPromise, 'A React Promise is returned from the guzzleToReactPromise');
    }

    /**
     * @test
     */
    public function the_converted_react_promise_gets_fulfilled_when_the_guzzle_promise_resolves()
    {
        $guzzlePromise = new GuzzlePromise();
        $promisedVal = null;

        \Tickner\GuzzleToReactPromise\guzzleToReactPromise($guzzlePromise)
            ->then(
                function($fulfilledValue) use (&$promisedVal) {
                    $promisedVal = $fulfilledValue;
                },
                function() {
                    static::fail('the React promise was rejected but it was expected to be fulfilled');
                },
                function() {
                    static::fail('the React promise was notified but guzzle promises do not support notify');
                }
            )
        ;

        $guzzlePromise->resolve('the val');
        $this->runGuzzlePromisesTaskQueue();

        static::assertSame('the val', $promisedVal, 'the returned React promise works as expected for fulfilled values');
    }

    /**
     * @test
     */
    public function the_converted_react_promise_gets_rejected_when_the_guzzle_promise_is_rejected()
    {
        $guzzlePromise = new GuzzlePromise();
        $rejectedVal = new \Exception('');

        \Tickner\GuzzleToReactPromise\guzzleToReactPromise($guzzlePromise)
            ->then(
                function() {
                    static::fail('the React promise was fulfilled but it was expected to be rejected');
                },
                function($e) use (&$rejectedVal) {
                    $rejectedVal = $e;
                },
                function() {
                    static::fail('the React promise was notified but guzzle promises do not support notify');
                }
            )
        ;

        $guzzlePromise->reject(new \Exception('an error occurred'));
        $this->runGuzzlePromisesTaskQueue();

        static::assertSame('an error occurred', $rejectedVal->getMessage(), 'the returned react promise works as expected for rejected values');
    }

    private function runGuzzlePromisesTaskQueue()
    {
        // Guzzle Promises require the use of a singleton \GuzzleHttp\Promise\TaskQueue
        \GuzzleHttp\Promise\Utils::queue()->run();
    }
}
