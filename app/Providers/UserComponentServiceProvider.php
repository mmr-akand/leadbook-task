<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\UserComponent;

class UserComponentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('user', function () {
            return new UserComponent();
        });
    }

    public function provides()
    {
        return [
            'user'
        ];
    }
}
