<?php
namespace App\Policies;
use App\Models\MaintenanceRequest;
use App\Models\User;
class MaintenanceRequestPolicy
{
    public function view(User $u, MaintenanceRequest $r): bool
    {
        return $u->isAdmin() || $r->technician_id === $u->id;
    }
    public function update(User $u, MaintenanceRequest $r): bool
    {
        return $u->isAdmin() || $r->technician_id === $u->id;
    }
    public function delete(User $u, MaintenanceRequest $r): bool
    {
        return $u->isAdmin();
    }
}
