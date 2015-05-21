<?php namespace Orzcc\AliyunOcs;

use Illuminate\Support\ServiceProvider;
use Cache;

class AliyunOcsServiceProvider extends ServiceProvider {

    public function boot()
    {
        Cache::extend('ocs', function($app, $config)
        {
            $memcached = $app['memcached.connector']->connect($config['servers']);
           
            $memcached->setOption(Memcached::OPT_COMPRESSION, false);
            $memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);

            if(isset($config['authname']) && ini_get('memcached.use_sasl')) {
                $memcached->setSaslAuthData($config['authname'], $config['authpass']);
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