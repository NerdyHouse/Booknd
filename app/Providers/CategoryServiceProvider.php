<?php

namespace App\Providers;

use App\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $allCategories = Category::orderBy('name', 'asc')->get();
        $boxCats    = Category::inRandomOrder()->get()->take(27);
        View::share('allCategories', $allCategories);
        View::share('boxCategories', $boxCats);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
