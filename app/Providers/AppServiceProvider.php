<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Sip_ref_activity;
use App\Sip_trx_user_config;
use App\Sip_trx_site_config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Schema::defaultStringLength(254);

        $activities = Sip_ref_activity::where('sip_ref_activities_status','active')->get();
        View::share('shared_activities', $activities);

        $site_config = Sip_trx_site_config::first();

        if(is_object($site_config)){
            View::share('site_config', $site_config);  
        }
        
        $user_config = new Sip_trx_user_config;   
        View::share('user_config', $user_config); 
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
