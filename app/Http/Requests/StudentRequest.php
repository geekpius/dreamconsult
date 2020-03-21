<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|string|email',
            'phone' => 'required|string|unique:users',
            'services' => 'array|required',
            'dob' => 'nullable|date',
            'pob' => 'nullable|string',
            'passport_number' => 'nullable|string',
            'passport_expiry' => 'nullable|date',
            'profession' => 'nullable|string',
            'language' => 'nullable|string',
            'country' => 'nullable|string',
            'street_address' => 'nullable|string',
            'city' => 'nullable|string',
            'registration' => 'required|date',
            'discount_service' => 'nullable|string',
            'discount' => 'nullable|numeric',
            'emergency' => 'nullable|string',
            'emergency_phone' => 'nullable|string',
            'emergency_address' => 'nullable|string',
        ];
    }
}
