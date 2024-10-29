<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CouponRepositoryInterface;
use App\Interfaces\DeliveryAreaRepositoryInterface;
use App\Interfaces\ProductGalleryRepositoryInterface;
use App\Interfaces\ProductOptionRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProductSizeRepositoryInterface;
use App\Interfaces\SettingRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\DeliveryAreaRepository;
use App\Repositories\ProductGalleryRepository;
use App\Repositories\ProductOptionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProductSizeRepository;
use App\Repositories\SettingRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductGalleryRepositoryInterface::class, ProductGalleryRepository::class);
        $this->app->bind(ProductSizeRepositoryInterface::class, ProductSizeRepository::class);
        $this->app->bind(ProductOptionRepositoryInterface::class, ProductOptionRepository::class);
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(DeliveryAreaRepositoryInterface::class, DeliveryAreaRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
