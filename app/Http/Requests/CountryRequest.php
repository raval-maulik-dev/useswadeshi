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
                'min:2',
                'max:255',
                Rule::unique('countries', 'name')->ignore($countryId),
            ],
            'iso_code' => [
                'required',
                'string',
                'min:2',
                'max:3',
                'regex:/^[A-Z]{2,3}$/',
                Rule::unique('countries', 'iso_code')->ignore($countryId),
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
            'iso_code.required' => 'ISO code is required.',
            'iso_code.unique' => 'This ISO code already exists.',
            'iso_code.min' => 'ISO code must be at least 2 characters.',
            'iso_code.max' => 'ISO code cannot exceed 3 characters.',
            'iso_code.regex' => 'ISO code must contain only uppercase letters.',
        ];
    }
}
