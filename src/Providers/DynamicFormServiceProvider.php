<?php

namespace Mayrajp\Forms\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class DynamicFormServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

    }
    public function register()
    {
        $this->app->make('Mayrajp\Forms\Http\Controllers\Api\CompletedFormController');
        $this->app->make('Mayrajp\Forms\Http\Controllers\Api\DynamicFormController');  
        $this->app->make('Mayrajp\Forms\Http\Controllers\Api\FieldController');

    }
    
}
