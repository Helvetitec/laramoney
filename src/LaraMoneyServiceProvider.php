<?php

namespace LaraMoney;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class LaraMoneyServiceProvider extends ServiceProvider
{
  public function register()
  { 
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laramoney');
      $this->app->singleton('laramoney', function () {
          return new LaraMoney();
      });
  }

  public function boot()
  {
      AliasLoader::getInstance()->alias(
          'Money',
          \LaraMoney\Facades\Money::class
      );
      $this->publishes([
        __DIR__.'/../config/config.php' => config_path('laramoney.php'),
      ], 'laramoney.config');
  }
}
