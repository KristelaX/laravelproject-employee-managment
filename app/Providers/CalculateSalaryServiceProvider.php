<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CalculateSalaryService as CalculateSalaryService;

class CalculateSalaryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Contracts\CalculateSalaryInterface', function ($app) {
            return new CalculateSalaryService();
          });
    }
}
