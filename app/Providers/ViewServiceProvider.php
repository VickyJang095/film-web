<?php

namespace App\Providers;

use App\Models\Country;
use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('countries', Country::all());
            $view->with('categories', Category::all());
        });
    }
} 