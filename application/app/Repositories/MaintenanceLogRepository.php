<?php

namespace App\Repositories;

use App\Models\MaintenanceLog;
use App\Repositories\Interfaces\MaintenanceLogRepositoryInterface;

class MaintenanceLogRepository implements MaintenanceLogRepositoryInterface
{
    public function getLogsAndRelated($userId)
    {
        return MaintenanceLog::getLogsAndRelated($userId);
    }

    public function createLog($data)
    {
        return MaintenanceLog::create($data);
    }

    public function deleteLogsById($id)
    {
        return MaintenanceLog::where('id', $id)->delete();
    }
}