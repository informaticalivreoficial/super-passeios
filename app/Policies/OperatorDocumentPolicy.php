<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\OperatorDocument;
use App\Models\User;

class OperatorDocumentPolicy
{
    public function viewAny(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function view(User|Customer $user, OperatorDocument $document): bool
    {
        if ($user instanceof Customer) {
            return $user->isProprietary();
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function create(User|Customer $user): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function update(User|Customer $user, OperatorDocument $document): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function delete(User|Customer $user, OperatorDocument $document): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin();
    }

    public function publish(User|Customer $user, OperatorDocument $document): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }

    public function viewAcceptances(User|Customer $user, OperatorDocument $document): bool
    {
        if ($user instanceof Customer) {
            return false;
        }

        return $user->isSuperAdmin() || $user->isAdmin();
    }
}
