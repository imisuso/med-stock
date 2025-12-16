<?php

namespace App\Providers;

use App\APIs\PortalAPI;
use App\Contracts\ADUser;
use Hashids\Hashids;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton( abstract: Hashids::class, concrete: fn () => new Hashids(config('app.key')));

     //   $this->app->bind(abstract: ADUser::class, concrete: PortalAPI::class);
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
