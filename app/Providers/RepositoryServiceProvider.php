<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\Http\Interfaces\AuthInterface',
            'App\Http\Repositories\AuthRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\ConfirmEmailPhoneInterface',
            'App\Http\Repositories\ConfirmEmailPhoneRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\PasswordInterface',
            'App\Http\Repositories\PasswordRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\Admin\CategoryInterface',
            'App\Http\Repositories\Admin\CategoryRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\Admin\ItemInterface',
            'App\Http\Repositories\Admin\ItemRepository'
        );
        $this->app->bind(
            'App\Http\Interfaces\Admin\ServiceInterface',
            'App\Http\Repositories\Admin\ServiceRepository'
        );

        $this->app->bind(
            'App\Http\Interfaces\ChatInterface',
            'App\Http\Repositories\ChatRepository'
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
