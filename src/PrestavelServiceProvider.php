<?php

namespace Islemdev\Prestavel;

use Islemdev\Prestavel\PrestavelConnector;
use Illuminate\Support\ServiceProvider;

class PrestavelServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->bind('PrestavelConnector', function($app) {
        return new PrestavelConnector(config('prestavel.api_url'), config('prestavel.api_token'));
    });


    //config
    $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'prestavel');

  }

  public function boot()
  {
    if ($this->app->runningInConsole()) {

        $this->publishes([
          __DIR__.'/../config/config.php' => config_path('prestavel.php'),
        ], 'config');
    
      }
  }
}