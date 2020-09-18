<?php

namespace App\Http\Controllers;

use App\User;
use App\Repositories\Interfaces\BikeRepositoryInterface;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use App\Repositories\Interfaces\MaintenanceLogRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogViewController extends Controller
{
    private $bikeRepository;
    private $distanceRepository;
    private $maintenanceLogRepository;
    
    public function __construct(
        BikeRepositoryInterface $bikeRepository,
        DistanceRepositoryInterface $distanceRepository,
        MaintenanceLogRepositoryInterface $maintenanceLogRepository
    )
    {
        $this->bikeRepository = $bikeRepository;
        $this->distanceRepository = $distanceRepository;
        $this->maintenanceLogRepository = $maintenanceLogRepository;
    }

    public function index()
    {
        $user_id = Auth::user()->id;

        $bikes = $this->bikeRepository->getBikesByUser(Auth::user());

        $bike_ids = [];

        // this should be in a service too
        $logs = $this->maintenanceLogRepository->getLogsAndRelated($user_id);
        foreach ($bikes as $bike) {
            $bike_ids[] = $bike->id;
        }

        $distances = $this->distanceRepository->getDistancesByBikes($bike_ids);

        return view('log', ['bikes' => $bikes, 'logs' => $logs, 'units' => Auth::user()->units, 'distances' => $distances]);
    }

    public function store(Request $request)
    {
        $requestObject = $request->all();
        $distanceObject['bike_id'] = $requestObject['bike_id']; 
        $distanceObject['metric'] = $requestObject['distance'];
        $distanceObject['imperial'] = round($requestObject['distance'] / 1.609344);
        
        unset($requestObject['distance']);

        $distance = $this->distanceRepository->createDistance($distanceObject);

        $requestObject['distance_id'] = $distance->id;

        $success = $this->maintenanceLogRepository->createLog($requestObject);

        return redirect('home')->withSuccess('Log Saved!');;
    }

    public function delete(Request $request)
    {
        $requestObject = $request->all();
        $id = $requestObject['deleteid']; 

        $success = $this->maintenanceLogRepository->deleteLogsById($id);

        return redirect('home')->withSuccess('Log deleted!');;
    }
}
