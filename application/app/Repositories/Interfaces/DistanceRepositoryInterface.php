<?php

namespace App\Repositories\Interfaces;

use App\User;

interface DistanceRepositoryInterface
{
    public function getDistancesByBikes(Array $bikes);

    public function createDistance($distance);
}