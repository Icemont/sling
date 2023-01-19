<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\DataTransferObjects\ReportParametersData;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;


class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_date' => 'required|date_format:"Y-m-d"',
            'to_date' => 'required|date_format:"Y-m-d"|after_or_equal:from_date',
            'download' => 'boolean',
        ];
    }

    public function getPayload(): ReportParametersData
    {
        return new ReportParametersData(
            boolval($this->download ?? false),
            CarbonImmutable::createFromFormat('Y-m-d', $this->from_date)->startOfDay(),
            CarbonImmutable::createFromFormat('Y-m-d', $this->to_date)->endOfDay()
        );
    }
}
