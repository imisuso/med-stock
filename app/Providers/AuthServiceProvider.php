<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Log::info('AuthServiceProvider boot');
    
        Gate::before(function ($user , $ability ) {
            Log::info('gate before');
           // Log::info($user->abilities);
           if($user->abilities->contains($ability)){
               return true;
           }
        });

        Gate::define('checkout_item',function(User $user){
            Log::info('gate checkout_item');
            //Log::info($user->abilities);
            if($user->abilities->contains('checkout_item')){
                return true;
            }
        });

        Gate::define('manage_master_data',function(User $user){
            Log::info('gate checkout_item');
            //Log::info($user->abilities);
            if($user->abilities->contains('manage_master_data')){
                return true;
            }
        });

        // Gate::define('can_owner_stock',function(User $user){
        //     if()
        // });
     
        // Gate::define('manage_master_data',function(User $user){
        //     return $user->email=='admin_stock@med.si';
        // });
    }
}
