<?php namespace Orzcc\AliyunOcs;

use Illuminate\Support\ServiceProvider;
use Cache;

class AliyunOcsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;
    
    public function boot()
    {
        Cache::extend('ocs', function($app, $config)
        {
            $this->app->singleton('memcached.connector', function()
            {
                return new MemcachedConnector;
            });

            $memcached = $app['memcached.connector']->connect($config['servers']);
            $prefix = $app['config']['cache.prefix'];
            $store = new \Illuminate\Cache\MemcachedStore($memcached, $prefix);
            
            return new \Illuminate\Cache\Repository($store);
        });
    }

    public function register() {}
}