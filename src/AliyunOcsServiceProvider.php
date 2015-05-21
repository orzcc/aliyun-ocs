<?php namespace Orzcc\AliyunOcs;

use Illuminate\Support\ServiceProvider;
use RuntimeException;
use Cache;

class AliyunOcsServiceProvider extends ServiceProvider {

    public function boot()
    {
        Cache::extend('ocs', function($app, $config)
        {
            try {
                $memcached = $app['memcached.connector']->connect($config['servers']);
            } catch (RuntimeException $e) { // OCS可能会出现$memcached->getVersion()无法获取的问题
            }
           
            $memcached->setOption(Memcached::OPT_COMPRESSION, false);
            $memcached->setOption(Memcached::OPT_BINARY_PROTOCOL, true);

            if(isset($config['servers']['authname']) && ini_get('memcached.use_sasl')) {
                $memcached->setSaslAuthData($config['servers']['authname'], $config['servers']['authpass']);
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