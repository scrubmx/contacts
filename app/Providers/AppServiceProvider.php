<?php

namespace App\Providers;

use App\Contracts\SanitizeBeforeSave;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Waavi\Sanitizer\Sanitizer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
