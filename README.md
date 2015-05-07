# Aliyun OCS
Aliyun ocs for Laravel5.

## Requirements

* >= PHP 5.4 with [ext-memcached](http://php.net/manual/en/book.memcached.php)
* To use ocs must with [SASL](http://docs.php.net/manual/en/memcached.setsaslauthdata.php) support, make sure memcached.use_sasl ON at php.ini

## Installation

This package can be installed through Composer.
```bash
composer require orzcc/aliyun-ocs
```

This service provider must be registered.
```bash
// config/app.php

'providers' => [
    '...',
    'Orzcc\AliyunOcs\AliyunOcsServiceProvider',
];
```

At last, you can edit the config file: config/cache.php.

add a stores config to the file, change your ocs config
```bash
'ocs' => [
    'driver'  => 'ocs',
    'servers' => [
        [
            'host' => 'Your ocs host',
            'port' => 11211,	// ocs port
            'pconn' => false,
            'weight' => 1,
            'timeout' => 15,
            'retry' => 15,
            'status' => true,
            'fcallback' => null,
            'authname' => 'Your ocs auth name',
            'authpass' => 'Your ocs auth pass',
        ],
    ],
],
```

change default to ocs
```bash
'default' => 'ocs';
```

## Usage

You can now use Laravel5's cache follow the document, http://laravel.com/docs/5.0/cache