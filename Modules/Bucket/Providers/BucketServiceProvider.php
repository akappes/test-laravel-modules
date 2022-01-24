<?php


namespace Modules\Bucket\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Bucket\Services\BucketService;
use Modules\Bucket\Services\interfaces\BucketInterface;
use Modules\Bucket\Services\interfaces\StorageInterface;

/**
 * Class ProductServiceProvider
 *
 * @package Modules\Product\Providers
 */
class BucketServiceProvider extends ServiceProvider
{


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            StorageInterface::class,
            BucketService::class
        );

        $this->app->bind(
            BucketInterface::class,
            BucketService::class
        );
    }
}
