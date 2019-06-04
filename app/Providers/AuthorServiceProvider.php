<?php

namespace App\Providers;

use App\Author;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AuthorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $boxAuthors    = Author::orderBy('name', 'asc')->get()->take(27);
        View::share('boxAuthors', $boxAuthors);
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
