<?php

declare(strict_types=1);

namespace App\DTO;

use Carbon\CarbonImmutable;

readonly class ReportParametersDTO
{
    public function __construct(
        public bool $download,
        public CarbonImmutable $dateFrom,
        public CarbonImmutable $dateTo
    ) {
    }
}
