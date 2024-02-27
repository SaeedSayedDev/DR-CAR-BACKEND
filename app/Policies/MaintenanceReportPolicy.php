<?php

namespace App\Policies;

use App\Models\MaintenanceReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceReportPolicy
{
    use HandlesAuthorization;

    public function view(User $user, MaintenanceReport $maintenanceReport)
    {
        return $user->id === $maintenanceReport->garage_id;
    }

    public function update(User $user, MaintenanceReport $maintenanceReport)
    {
        return $user->id === $maintenanceReport->garage_id;
    }

    public function delete(User $user, MaintenanceReport $maintenanceReport)
    {
        return $user->id === $maintenanceReport->garage_id;
    }
}
