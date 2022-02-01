<?php

namespace App\Policies;

use App\Contracts\HasOwner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnerPolicy
{
    use HandlesAuthorization;

    public function owner(User $user, HasOwner $model)
    {
        return $user->id == $model->getOwnerId();
    }
}
