<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class ReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_date' => 'required|date_format:"Y-m-d"',
            'to_date' => 'required|date_format:"Y-m-d"|after_or_equal:from_date',
            'download' => 'boolean',
        ];
    }

    public function getPreparedPayload()
    {
        return [
            'download' => boolval($this->download ?? false),
            'from_date' => Carbon::createFromFormat('Y-m-d', $this->from_date)->startOfDay(),
            'to_date' => Carbon::createFromFormat('Y-m-d', $this->to_date)->endOfDay(),
        ];
    }
}
