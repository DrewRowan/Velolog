<?php

namespace App\Repositories;

use App\Models\Distance;
use App\Repositories\Interfaces\DistanceRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DistanceRepository implements DistanceRepositoryInterface
{
    public function getDistancesByBikes(array $bikes)
    {
        return Distance::whereIn('bike_id', $bikes)
            ->select(DB::raw('max(metric) as metric, max(imperial) as imperial, bike_id'))
            ->groupBy('bike_id')
            ->get();
    }

    public function createDistance($distance)
    {
        return Distance::create($distance);
    }
}