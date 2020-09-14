<?php

namespace App\Repositories;

use App\Models\Bike;
use App\User;
use App\Repositories\Interfaces\BikeRepositoryInterface;

class BikeRepository implements BikeRepositoryInterface
{
    public function getBikesByUser(User $user)
    {
        return Bike::where('user_id', $user->id)->get();
    }

    public function createBike($requestObject)
    {
        return Bike::create($requestObject);
    }

    public function deleteBikesByUser(User $user)
    {
        return Bike::where('user_id', $user->id)->delete();
    }
}