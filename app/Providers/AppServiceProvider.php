<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register policies
        if (class_exists(\App\Policies\SalesOrderPolicy::class) && class_exists(\App\Models\SalesOrder::class)) {
            \Illuminate\Support\Facades\Gate::policy(\App\Models\SalesOrder::class, \App\Policies\SalesOrderPolicy::class);
        }
    }}
