<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Components\CompanyComponent;

class CompanyComponentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('company', function () {
            return new CompanyComponent();
        });
    }

    public function provides()
    {
        return [
            'company'
        ];
    }
}
