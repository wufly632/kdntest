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
        $this->app->bind(\App\Repositories\Promotion\PromotionGoodRepository::class, \App\Repositories\Promotion\PromotionGoodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Product\ProductSkuRepository::class, \App\Repositories\Product\ProductSkuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Promotion\PromotionGoodSkuRepository::class, \App\Repositories\Promotion\PromotionGoodSkuRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Product\ProductAttrValueRepository::class, \App\Repositories\Product\ProductAttrValueRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\User\UserRepository::class, \App\Repositories\User\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\User\SupplierUserRepository::class, \App\Repositories\User\SupplierUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Order\OrderGoodRepository::class, \App\Repositories\Order\OrderGoodRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Order\OrderTrackingmoreRepository::class, \App\Repositories\Order\OrderTrackingmoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Product\ProductSkuImagesRepository::class, \App\Repositories\Product\ProductSkuImagesRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\BannerRepository::class, \App\Repositories\Website\BannerRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Supplier\SupplierUserRepository::class, \App\Repositories\Supplier\SupplierUserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\PushOrder\RequirementRepository::class, \App\Repositories\PushOrder\RequirementRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShiperOrder\PreShipOrderRepository::class, \App\Repositories\ShiperOrder\PreShipOrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShipOrder\PreShipOrderRepository::class, \App\Repositories\ShipOrder\PreShipOrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShipOrder\ShipOrderRepository::class, \App\Repositories\ShipOrder\ShipOrderRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShipOrder\GoodSkuLackRepository::class, \App\Repositories\ShipOrder\GoodSkuLackRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\IconRepository::class, \App\Repositories\Website\IconRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\HomePageCardRepository::class, \App\Repositories\Website\HomePageCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Currency\CurrencyRepository::class, \App\Repositories\Currency\CurrencyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Finance\ShipOrderReceiveDailyRepository::class, \App\Repositories\Finance\ShipOrderReceiveDailyRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Finance\SupplierSettleAccountRepository::class, \App\Repositories\Finance\SupplierSettleAccountRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Finance\SupplierSettleReceiveRepository::class, \App\Repositories\Finance\SupplierSettleReceiveRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Finance\SupplierWithdrawRepository::class, \App\Repositories\Finance\SupplierWithdrawRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Country\CountryAreaRepository::class, \App\Repositories\Country\CountryAreaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\MobileHomePageRepository::class, \App\Repositories\Website\MobileHomePageRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\MobileHomeCardRepository::class, \App\Repositories\Website\MobileHomeCardRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\MobileCategoryRepository::class, \App\Repositories\Website\MobileCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Website\PcCategoryRepository::class, \App\Repositories\Website\PcCategoryRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CateAttr\CategoryAscriptionRepository::class, \App\Repositories\CateAttr\CategoryAscriptionRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\Product\ProductOnOfflineRepository::class, \App\Repositories\Product\ProductOnOfflineRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ShipOrder\LogisticsInfoRepository::class, \App\Repositories\ShipOrder\LogisticsInfoRepositoryEloquent::class);
        //:end-bindings:
    }
}
