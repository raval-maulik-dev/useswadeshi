<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StateRequest extends FormRequest
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
        $stateId = $this->route('record')?->id;
        $countryId = $this->input('country_id') ?? $this->route('record')?->country_id;

        return [
            'country_id' => [
                'required',
                'exists:countries,id',
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('states', 'name')->where(function ($query) use ($countryId) {
                    return $query->where('country_id', $countryId);
                })->ignore($stateId),
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required.',
            'country_id.exists' => 'Selected country does not exist.',
            'name.required' => 'State name is required.',
            'name.unique' => 'This state name already exists in the selected country.',
            'name.min' => 'State name must be at least 2 characters.',
            'name.max' => 'State name cannot exceed 255 characters.',
        ];
    }
}
