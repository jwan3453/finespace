<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind('App\Repositories\UserRepositoryInterface', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\CategoryRepositoryInterface', 'App\Repositories\CategoryRepository');
        $this->app->bind('App\Repositories\BrandRepositoryInterface', 'App\Repositories\BrandRepository');
        $this->app->bind('App\Repositories\ProductRepositoryInterface', 'App\Repositories\ProductRepository');
        $this->app->bind('App\Repositories\ShoppingCartRepositoryInterface', 'App\Repositories\ShoppingCartRepository');
        $this->app->bind('App\Repositories\OrderRepositoryInterface', 'App\Repositories\OrderRepository');
        $this->app->bind('App\Repositories\OrderItemRepositoryInterface', 'App\Repositories\OrderItemRepository');
        $this->app->bind('App\Repositories\UserAccountRepositoryInterface', 'App\Repositories\UserAccountRepository');
        $this->app->bind('App\Repositories\SmsCodeLogRepositoryInterface', 'App\Repositories\SmsCodeLogRepository');
        $this->app->bind('App\Repositories\ImageRepositoryInterface', 'App\Repositories\ImageRepository');
        $this->app->bind('App\Repositories\SettingRepositoryInterface', 'App\Repositories\SettingRepository');
        $this->app->bind('App\Repositories\StoreRepositoryInterface', 'App\Repositories\StoreRepository');
        $this->app->bind('App\Repositories\SpecInfoRepositoryInterface','App\Repositories\SpecInfoRepository');
    }
}
