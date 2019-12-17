<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        Gate::define('manage-dashboard', function ($user) {
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });
        Gate::define('manage-dashboard-pegawai', function ($user) {
            return count(array_intersect(["KASIR","GUDANG"], json_decode($user->roles)));
        });
        Gate::define('manage-users', function ($user) {
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });
        Gate::define('manage-penjualan', function ($user) {
            return count(array_intersect(["ADMIN","KASIR"], json_decode($user->roles)));
        });
        Gate::define('manage-pembelian', function ($user) {
            return count(array_intersect(["ADMIN","GUDANG"], json_decode($user->roles)));
        });
        Gate::define('manage-category', function ($user) {
            return count(array_intersect(["ADMIN","KASIR","GUDANG"], json_decode($user->roles)));
        });
        Gate::define('manage-product', function ($user) {
            return count(array_intersect(["ADMIN","KASIR","GUDANG"], json_decode($user->roles)));
        });
        Gate::define('manage-stock', function ($user) {
            return count(array_intersect(["ADMIN","GUDANG"], json_decode($user->roles)));
        });
        Gate::define('manage-customers', function ($user) {
            return count(array_intersect(["ADMIN","KASIR"], json_decode($user->roles)));
        });
        Gate::define('manage-suppliers', function ($user) {
            return count(array_intersect(["ADMIN","GUDANG"], json_decode($user->roles)));
        });
    }
}
