<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CityRequest extends FormRequest
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
        $cityId = $this->route('record')?->id;
        $stateId = $this->input('state_id') ?? $this->route('record')?->state_id;

        return [
            'state_id' => [
                'required',
                'exists:states,id',
            ],
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('cities', 'name')->where(function ($query) use ($stateId) {
                    return $query->where('state_id', $stateId);
                })->ignore($cityId),
            ],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'state_id.required' => 'State is required.',
            'state_id.exists' => 'Selected state does not exist.',
            'name.required' => 'City name is required.',
            'name.unique' => 'This city name already exists in the selected state.',
            'name.min' => 'City name must be at least 2 characters.',
            'name.max' => 'City name cannot exceed 255 characters.',
        ];
    }
}
