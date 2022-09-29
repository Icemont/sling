<?php

declare(strict_types=1);

namespace App\Contracts;

interface HasOwner
{
    public function getOwnerId(): ?int;
}
