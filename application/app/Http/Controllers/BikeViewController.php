<?php

namespace App\Http\Controllers;

use App\User;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use App\Models\StravaBikeModel;
use App\Services\StravaService;
use App\StravaSettings;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class BikeViewController extends Controller
{
    private $bikeRepository;
    private $distanceRepository;
    
    public function __construct(
        BikeRepositoryInterface $bikeRepository,
        DistanceRepositoryInterface $distanceRepository)
    {
        $this->bikeRepository = $bikeRepository;
        $this->distanceRepository = $distanceRepository;
    }

    public function index()
    {
        $bikes = $this->bikeRepository->getBikesByUser(Auth::user());
        $bike_ids = [];
        $distances_array = [];

        $strava_settings = new StravaSettings;
        $strava_authorised = $strava_settings->IsStravaAuthorised(Auth::user()->id);

        foreach ($bikes as $bike) {
            $bike_ids[] = $bike->id;
        }

        // this need further improving - move to a service perhaps
        $distances = $this->distanceRepository->getDistancesByBikes($bike_ids);

        foreach ($distances as $distance) {
            $distances_array[$distance->bike_id] = [
                'metric' => $distance->metric,
                'imperial' => $distance->imperial,
            ];
        }

        return view('bike', ['bikes' => $bikes, 'distances' => $distances_array, 'units' => Auth::user()->units, 'strava_authorised' => $strava_authorised]);
    }

    public function store(Request $request)
    {
        // need to add backend validation
        $requestObject = $request->all();

        $requestObject['id'] = Str::uuid();
        $requestObject['user_id'] = Auth::user()->id;

        $bike = $this->bikeRepository->createBike($requestObject);

        return redirect('bikes')->withSuccess('Bike Saved!');
    }
}
