<?php

namespace App\Repositories\Interfaces;

use App\User;

interface BikeRepositoryInterface
{
    public function getBikesByUser(User $user);

    public function createBike($requestObject);

    public function deleteBikesByUser(User $user);
}