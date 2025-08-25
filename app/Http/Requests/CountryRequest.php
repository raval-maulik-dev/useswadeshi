<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $countryId = $this->route('record')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('countries', 'name')->ignore($countryId),
            ],
            'code' => [
                'required',
                'string',
                'min:2',
                'max:2',
                'regex:/^[A-Z]{2}$/',
                Rule::unique('countries', 'code')->ignore($countryId),
            ],
            'phone_code' => [
                'nullable',
                'string',
                'max:10',
            ],
            'currency' => [
                'nullable',
                'string',
                'max:10',
            ],
            'currency_symbol' => [
                'nullable',
                'string',
                'max:5',
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Country name is required.',
            'name.unique' => 'This country name already exists.',
            'name.min' => 'Country name must be at least 2 characters.',
            'name.max' => 'Country name cannot exceed 255 characters.',
            'code.required' => 'ISO code is required.',
            'code.unique' => 'This ISO code already exists.',
            'code.min' => 'ISO code must be at least 2 characters.',
            'code.max' => 'ISO code cannot exceed 3 characters.',
            'code.regex' => 'ISO code must contain only uppercase letters.',
        ];
    }
}
