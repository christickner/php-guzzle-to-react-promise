# tickner/guzzle-to-react-promise

A function that will allow you to easily convert a [Guzzle Promise](https://github.com/guzzle/promises) to a [React Promise](https://github.com/reactphp/promise). 
 
## Install

`composer require tickner/guzzle-to-react-promise`

## Why?

React and Guzzle have different promise implementations and they do not interop very well. In a project using ReactPHP, you may need to work with Guzzle for things like async access to the AWS SDK. If this happens, you will find your promise chains break unexpectedly when a Guzzle request promise is returned.

Using the function that this package provides, you can transform that promise into the React promise that your application would prefer to use.

## Example

```php
<?php

use GuzzleHttp\Promise\Promise as GuzzlePromise;
use function Tickner\GuzzleToReactPromise\guzzleToReactPromise;

$guzzlePromise = new GuzzlePromise(); // or a guzzle http request

$reactPromise = guzzleToReactPromise($guzzlePromise);

$reactPromise
    ->then(
        function($fulfilledValue) {
            echo $fulfilledValue;
        }
    )
;

$guzzlePromise->resolve('the val');
```

When the Guzzle Promise `TaskQueue` runs, the Guzzle Promise is resolved, and your React promise will also resolve and echo `the val`. 

> A shorter alias function is available: `g2rp`

## Tests and Contributing

To contribute, clone the repository and install the composer dependencies.
 
 `composer install`
 
 To test, run phpunit in the root dir.

`vendor/bin/phpunit`

## License

Released under the the terms of the [MIT License](https://opensource.org/licenses/MIT).
