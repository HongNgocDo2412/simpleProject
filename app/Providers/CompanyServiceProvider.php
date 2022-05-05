<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Company\Repositories\CompanyRepository;
use App\Modules\Company\Services\CompanyService;
use App\Modules\Company\Services\Interfaces\CompanyServiceInterface;
use App\Modules\Company\Repositories\Interfaces\CompanyRepositoryInterface;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
