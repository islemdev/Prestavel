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
  }

  public function boot()
  {
  }
}