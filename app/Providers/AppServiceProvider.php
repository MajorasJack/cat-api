<?php

namespace App\Providers;

use App\Modules\EanLookup\Interfaces\EanLookupInterface;
use App\Modules\EanLookup\Repositories\EanScraperRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        app()->bind(EanLookupInterface::class, function () {
            return app(EanScraperRepository::class);
        });
    }

    /**
     * @return void
     */
    public function boot()
    {

    }
}
