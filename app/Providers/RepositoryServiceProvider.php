<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\Good\GoodRepository::class, \App\Repositories\Good\GoodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\CategoryRepository::class, \App\Repositories\CateAttr\CategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\CategoryAttributeRepository::class, \App\Repositories\CateAttr\CategoryAttributeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\AttributeRepository::class, \App\Repositories\CateAttr\AttributeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\AttributeValueRepository::class, \App\Repositories\CateAttr\AttributeValueRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Good\GoodSkuRepository::class, \App\Repositories\Good\GoodSkuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Good\GoodSkuImageRepository::class, \App\Repositories\Good\GoodSkuImageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\GoodAttrValueRepository::class, \App\Repositories\CateAttr\GoodAttrValueRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Product\ProductRepository::class, \App\Repositories\Product\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Promotion\PromotionRepository::class, \App\Repositories\Promotion\PromotionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Coupon\CouponRepository::class, \App\Repositories\Coupon\CouponRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Order\OrderRepository::class, \App\Repositories\Order\OrderRepositoryEloquent::class);
        //:end-bindings:
    }
}
