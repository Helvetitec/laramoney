<?php

namespace LaraMoney;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Illuminate\Support\Facades\Blade;
use LiveControls\Masks\Http\Livewire\CepMask;
use LiveControls\Masks\Http\Livewire\CnpjMask;
use LiveControls\Masks\Http\Livewire\CpfCnpjMask;
use LiveControls\Masks\Http\Livewire\CpfMask;
use LiveControls\Masks\Http\Livewire\CurrencyMask;
use LiveControls\Masks\Http\Livewire\CustomMask;

class LaraMoneyServiceProvider extends ServiceProvider
{
  public function register()
  { 
      $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laramoney');
  }

  public function boot()
  {
      $this->publishes([
        __DIR__.'/../config/config.php' => config_path('laramoney.php'),
      ], 'laramoney.config');
  }
}
