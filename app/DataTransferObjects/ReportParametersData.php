<?php

declare(strict_types=1);

namespace App\DataTransferObjects;

use Carbon\CarbonImmutable;

class ReportParametersData
{
    public function __construct(
        readonly public bool            $download,
        readonly public CarbonImmutable $dateFrom,
        readonly public CarbonImmutable $dateTo
    )
    {
    }
}
