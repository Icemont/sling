<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('clients')
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id());
                    })
                    ->ignore($this->client->id)
            ],
            'company' => 'nullable|string|max:150',
            'invoice_prefix' => [
                'required',
                'alpha_dash',
                'max:10',
                Rule::unique('clients')
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id());
                    })
                    ->ignore($this->client->id)
            ],
            'invoice_index' => 'required|integer',
            'phone' => 'nullable|digits_between:9,15',
            'country' => 'required|string|max:100',
            'state' => 'nullable|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'nullable|string|max:50',
            'street1' => 'required|string|max:150',
            'street2' => 'nullable|string|max:150',
            'note' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'street1' => 'address line 1',
            'street2' => 'address line 2',
        ];
    }
}
