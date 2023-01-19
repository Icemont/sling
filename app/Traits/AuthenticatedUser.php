<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\User;
use Exception;

trait AuthenticatedUser
{
    /**
     * @throws Exception
     */
    private function getAuthenticatedUser(): User
    {
        $authenticatedUser = auth()->user();

        if (!$authenticatedUser instanceof User) {
            throw new Exception('Can not get authenticated user');
        }

        return $authenticatedUser;
    }
}
