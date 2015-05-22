<?php namespace Orzcc\AliyunOcs;

use Illuminate\Support\ServiceProvider;
use Cache;

class AliyunOcsServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;
    
    public function boot() {}

    public function register()
    {
        $this->app->singleton('memcached.connector', 'Orzcc\AliyunOcs\MemcachedConnector');
    }
}