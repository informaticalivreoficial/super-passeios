<?php

namespace App\Policies;

use App\Models\TourDate;
use App\Models\User;

class TourDatePolicy
{
    public function create(User $user, TourDate $date): bool
    {
        return app(TourPolicy::class)->update($user, $date->tour);
    }

    public function update(User $user, TourDate $date): bool
    {
        return app(TourPolicy::class)->update($user, $date->tour);
    }

    public function delete(User $user, TourDate $date): bool
    {
        return app(TourPolicy::class)->delete($user, $date->tour);
    }
}