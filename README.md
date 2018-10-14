# Blockip

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]

**Block requests from specified IPs quick and easy in Laravel. Highly customizable.**

## Version Compatibility

 Laravel        | blockip
:---------------------|:----------
 5.3.x                | 1.x
 5.4.x                | 2.x
 5.5/5.6/5.7          | 3.x

## Installation

Via Composer

``` bash
$ composer require olssonm/blockip
```

Add the service provider to the providers array in `config/app.php` (auto-detection also available in newer Laravel-versions).

``` php
<?php

    'providers' => [
        Olssonm\Blockip\BlockipServiceProvider::class
    ]
```

## Usage

This backage sets up the `blockip`-middleware for use in your application. All routes that uses the middlareware is protected from unwanted requests.

#### Use in a group

``` php
<?php

    Route::group(['middleware' => 'blockip'], function() {
        Route::get('/', ['as' => 'start', 'uses' => 'StartController@index']);
        Route::get('/page', ['as' => 'page', 'uses' => 'StartController@page']);
    });
```

#### Singe route

``` php
<?php

    Route::get('/', [
        'as' => 'start',
        'uses' => 'StartController@index',
        'middleware' => 'blockip'
    ]);
```

## Configuration

Run the command `$ php artisan vendor:publish --provider="Olssonm\Blockip\BlockipServiceProvider"` to publish the packages configuration. In `config/blockip.php` you can edit your settings:

``` php
<?php

return [

    // IPs to block
    'ips' => [
        '37.123.187.245',   // an example of a single IP
        '23.20.0.0/14'      // an example of an IP-range with CIDR-notation
    ],

    // Message for blocked requests
    'error_message'     => '401 Unauthorized.',

    // Uncomment to use a view instead of plaintext message
    // 'error_view'     => 'blockip::default',

    // Environments where the middleware is active
    'envs'              => [
        'testing',
        'development',
        'production'
    ],

    // Main handler for the getIp(), getIpsToBlock() and getError-methods().
    // Check the documentation on how to customize this to your liking.
    'handler'           => Olssonm\Blockip\Handlers\BlockipHandler::class,

];
```

Everything here is pretty much self explanatory, but because the blockip-handler is customizable you can pretty much change every aspect of the middleware.

If you want to write your own handler, you should implement the `Olssonm\Blockip\Handlers\BaseHandler`-interface, like so:

``` php
<?php

use Olssonm\Blockip\Handlers\BaseHandler;

class MyHandler implements BaseHandler {

    /**
     * @return string
     */
    public function getIp() {
        // Method to retrieve the request IP
    }

    /**
     * @return array
     */
    public function getIpsToBlock() {
        // Method to set what IPs to be blocked
    }

    /**
     * @return response
     */
    public function getError() {
        // Method to set the response
    }
}
```

Using the system you have the ability to for example make your `getIpsToBlock()`-method check IPs from an API, your `getError()` return a JSON-response etc. etc.

**Note:** the default handler already checks for the special `HTTP_CF_CONNECTING_IP`-header when using the Cloudflare CDN.

## Testing

``` bash
$ composer test
```

or

``` bash
$ phpunit
```

Laravel always runs in the "testing" environment while running tests. Make sure that `testing` is set in the `envs`-array in `blockip.php`.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

© 2018 [Marcus Olsson](https://marcusolsson.me).

[ico-version]: https://img.shields.io/packagist/v/olssonm/blockip.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/olssonm/blockip/master.svg?style=flat-square
[link-packagist]: https://packagist.org/packages/olssonm/blockip
[link-travis]: https://travis-ci.org/olssonm/blockip
