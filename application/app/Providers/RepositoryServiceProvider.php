<?php

namespace App\Providers;

use App\Repositories\BikeRepository;
use App\Repositories\DistanceRepository;
use App\Repositories\MaintenanceLogRepository;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use App\Repositories\Interfaces\MaintenanceLogRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $repositories = [
            BikeRepositoryInterface::class => BikeRepository::class,
            DistanceRepositoryInterface::class => DistanceRepository::class,
            MaintenanceLogRepositoryInterface::class => MaintenanceLogRepository::class,
        ];
        
        foreach ($repositories as $from => $to) {
            $this->app->bind(
                $from,
                $to
            );
        }
            
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
