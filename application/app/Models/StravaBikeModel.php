<?php

namespace App\Models;

use Exception;
use GuzzleHttp\Client;
use app\Services\StravaService;
use App\StravaSettings;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StravaBikeModel extends Model
{
    private $stravaService;
    private $stravaSettings;
    private $bikeRepository;
    private $distanceRepository;
    
    public function __construct(
        BikeRepositoryInterface $bikeRepository,
        DistanceRepositoryInterface $distanceRepository
    )
    {
        $this->bikeRepository = $bikeRepository;
        $this->distanceRepository = $distanceRepository;
        $this->stravaService = new StravaService();
        $this->stravaSettings = StravaSettings::where('user_id', Auth::user()->id)->first();
    }

    // this function is a load of shit and needs refactoring
    // need to build up something so that we can fetch new miles on log in
    public function fetchStravaGear()
    {
        $athlete = $this->getAthlete();

        if (empty($athlete->bikes)) {
            return redirect('bikes')->with('error', 'No bikes found');
        }

        $deletedRows = $this->bikeRepository->deleteBikesByUser(Auth::user());

        foreach ($athlete->bikes as $bike) {
            try {
                $bike = $this->stravaService->gear($this->stravaSettings->access_token, $bike->id);
            } catch (Exception $e) {
                return redirect('bikes')->with('error', 'Issue syncing bikes. Please try again');
            }

            $bikeObject['id'] = $bike->id;
            $bikeObject['name'] = $bike->name;
            $bikeObject['make'] = $bike->brand_name;
            $bikeObject['model'] = $bike->model_name;
            $bikeObject['user_id'] = Auth::user()->id;
            $this->bikeRepository->createBike($bikeObject);

            // strava delivers in meters
            $distances = $bike->distance / 1000;

            $distanceArray['bike_id'] = $bike->id; 
            $distanceArray['metric'] = round($distances);
            $distanceArray['imperial'] = round($distances / 1.609344);
            $distance = $this->distanceRepository->createDistance($distanceArray);
        }
    }

    public function updateDistances()
    {
        $athlete = $this->getAthlete();

        if (empty($athlete->bikes)) {
            return redirect('bikes')->with('error', "Error updating bikes' distances");
        }

        foreach ($athlete->bikes as $bike) {
            // strava delivers in meters
            $distances = $bike->distance / 1000;

            $distanceArray['bike_id'] = $bike->id; 
            $distanceArray['metric'] = round($distances);
            $distanceArray['imperial'] = round($distances / 1.609344);
            $distance = $this->distanceRepository->createDistance($distanceArray);
        }
    }

    private function getAthlete()
    {
        // this really should be in a different function/model
        // comparing epoch time of token expiry vs now
        if (empty($this->stravaSettings->expires_at) || $this->stravaSettings->expires_at < time()) {
            $refreshedToken = $this->stravaService->refreshToken($this->stravaSettings->refresh_token);

            $this->stravaSettings->access_token = $refreshedToken->access_token;
            $this->stravaSettings->refresh_token = $refreshedToken->refresh_token;
            $this->stravaSettings->expires_at = $refreshedToken->expires_at;

            $this->stravaSettings->save();
        }

        try {
            $athlete = $this->stravaService->athlete($this->stravaSettings->access_token);

        } catch (Exception $e) {
            return redirect('bikes')->with('error', 'Trouble connecting to strava');
        }

        return $athlete;
    }
    
}
