<?php namespace Orzcc\AliyunOcs;

use Illuminate\Support\ServiceProvider;
use Cache;

class AliyunOcsServiceProvider extends ServiceProvider {

    public function boot()
    {
        Cache::extend('ocs', function($app, $config)
        {
            $memcached = $app['memcached.connector']->connect($config['servers']);
            if(isset($config['servers']['authname']) && ini_get('memcached.use_sasl')) {
                $user = $config['servers']['authname'];
                $pass = $config['servers']['authpass'];

                $memcached->setOption(Memcached::OPT_COMPRESSION, false);
                $memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
                $memcached->setSaslAuthData($user, $pass);
            }

            $prefix = $app['config']['cache.prefix'];
            $store = new \Illuminate\Cache\MemcachedStore($memcached, $prefix);
            
            return new \Illuminate\Cache\Repository($store);
        });
    }

    public function register()
    {
        //
    }
}