<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Employee\Repositories\EmployeeRepository;
use App\Modules\Employee\Services\EmployeeService;
use App\Modules\Employee\Services\Interfaces\EmployeeServiceInterface;
use App\Modules\Employee\Repositories\Interfaces\EmployeeRepositoryInterface;

class EmployeeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeServiceInterface::class, EmployeeService::class);
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
