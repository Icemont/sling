<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'business' => 'required|array:name,code',
            'business.name' => 'required|string|max:150',
            'business.code' => 'nullable|string|max:50',
            'phone' => 'required|digits_between:9,15',
            'country' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'nullable|string|max:50',
            'street1' => 'required|string|max:150',
            'street2' => 'nullable|string|max:150',
        ];
    }
}
