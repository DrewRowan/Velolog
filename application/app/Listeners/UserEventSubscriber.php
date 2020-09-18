<?php

namespace App\Listeners;

use App\Models\StravaBikeModel;
use App\StravaSettings;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserEventSubscriber
{
    private $bikeRepository;
    private $distanceRepository;

    public function __construct(
        BikeRepositoryInterface $bikeRepository,
        DistanceRepositoryInterface $distanceRepository
    )
    {
        $this->bikeRepository = $bikeRepository;
        $this->distanceRepository = $distanceRepository;
    }
    /**
     * Handle user login events.
     */
    public function handleUserLogin($event)
    {
        // check if strava settings set yet
        $stravaSettings = StravaSettings::where('user_id', Auth::user()->id)->first();

        if  (!empty($stravaSettings)) {
            //update distance
            $stravaBikeModel = new StravaBikeModel(
                $this->bikeRepository,
                $this->distanceRepository
            );
            $stravaBikeModel->updateDistances();
        }

    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {}

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@handleUserLogin'
        );

        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@handleUserLogout'
        );
    }
}