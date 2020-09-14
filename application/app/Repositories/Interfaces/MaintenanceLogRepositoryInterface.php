<?php

namespace App\Repositories\Interfaces;

interface MaintenanceLogRepositoryInterface
{
    public function getLogsAndRelated($userId);

    public function createLog($data);

    public function deleteLogsById($id);
}