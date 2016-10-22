<?php

namespace Tickner\GuzzleToReactPromise;

use GuzzleHttp\Promise\Promise as GuzzlePromise;
use React\Promise\Deferred as ReactDeferred;
use React\Promise\Promise as ReactPromise;

/**
 * Transforms a GuzzleHttp\Promise\Promise to a React\Promise\Promise.
 *
 * @param GuzzlePromise $guzzlePromise
 * @return ReactPromise
 */
function guzzleToReactPromise(GuzzlePromise $guzzlePromise) {
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
 * @param GuzzlePromise $promise
 * @return ReactPromise
 */
function g2rp(GuzzlePromise $promise) {
    return guzzleToReactPromise($promise);
}
