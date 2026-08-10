<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenanceRequestPolicy
{
    public function view(User $user, MaintenanceRequest $request): bool
    {
        return $user->isAdmin()
            || $request->technician_id === $user->id;
    }

    public function update(User $user, MaintenanceRequest $request): bool
    {
        // INTENTIONAL EXAM ISSUE: students must strengthen this rule.
        return $user->isAdmin() || $request->technician_id === $user->id;
    }

    public function delete(User $user, MaintenanceRequest $request): bool
    {
        return $user->isAdmin();
    }
}
