<?php

namespace Tickner\GuzzleToReactPromise;

use GuzzleHttp\Promise\PromiseInterface as GuzzlePromiseInterface;
use React\Promise\Deferred as ReactDeferred;
use React\Promise\PromiseInterface as ReactPromiseInterface;

/**
 * Transforms a GuzzleHttp\Promise\PromiseInterface to a React\Promise\PromiseInterface.
 *
 * @param GuzzlePromise $guzzlePromise
 * @return ReactPromise
 */
function guzzleToReactPromise(GuzzlePromiseInterface $guzzlePromise): ReactPromiseInterface {
    $deferred = new ReactDeferred();

    $guzzlePromise->then(
        function($fulfilledValue) use ($deferred) {
            $deferred->resolve($fulfilledValue);
        },
        function($error) use ($deferred) {
            $deferred->reject($error);
        }
    );

    return $deferred->promise();
}

/**
 * An alias for the "guzzleToReactPromise" function.
 *
 * @param GuzzlePromiseInterface $promise
 * @return ReactPromiseInterface
 */
function g2rp(GuzzlePromiseInterface $promise): ReactPromiseInterface {
    return guzzleToReactPromise($promise);
}
