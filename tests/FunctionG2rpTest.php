<?php

namespace Tickner\GuzzleToReactPromise;

use GuzzleHttp\Promise\Promise as GuzzlePromise;
use PHPUnit\Framework\TestCase;
use React\Promise\Promise as ReactPromise;

final class FunctionG2rpTest extends TestCase
{
    /**
     * @test
     */
    public function g2rp_is_an_alias_for_guzzle_to_react_promise_function(): void
    {
        $guzzlePromise = new GuzzlePromise();
        $reactPromise = \Tickner\GuzzleToReactPromise\g2rp($guzzlePromise);
        static::assertInstanceOf(ReactPromise::class, $reactPromise, 'A React Promise is returned from g2rp function');
        // see FunctionGuzzleToReactPromiseTest.php
    }
}
