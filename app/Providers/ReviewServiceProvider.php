<?php

namespace App\Providers;

use App\Review;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ReviewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $recentReviews    = Review::orderBy('created_at','desc')->take(6)->get();
        View::share('recentReviews', $recentReviews);
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
