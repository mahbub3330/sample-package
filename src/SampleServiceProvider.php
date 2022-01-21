<?php

namespace Gglink\Sample;

use Illuminate\Support\ServiceProvider;

class SampleServiceProvider extends ServiceProvider
{
    protected $rootPath;

    /**
     * Register Sample Application
     * @return void
     */

    public function register()
    {
        $this->rootPath = realpath(__DIR__.'/../');
    }

    public function boot()
    {
        $this->loadRoutesFrom($this->rootPath . '/routes/web.php');
        $this->loadViewsFrom($this->rootPath . '/resources/views', 'sample');
        $this->mergeConfigFrom($this->rootPath. '/config/config.php', 'sample');
    }


}
