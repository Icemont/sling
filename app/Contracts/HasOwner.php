<?php

namespace App\Contracts;

interface HasOwner
{
    public function getOwnerId(): ?int;
}
