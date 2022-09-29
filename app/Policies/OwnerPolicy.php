<?php

declare(strict_types=1);

namespace App\Policies;

use App\Contracts\HasOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, HasOwner $model): bool
    {
        return $user->id == $model->getOwnerId();
    }
}
