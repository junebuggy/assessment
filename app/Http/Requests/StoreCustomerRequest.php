<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        return [
            'full_name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            //'email_address' => 'required|unique:customers|email:rfc|max:255',
            'email_address' => 'required|email:rfc|max:255',
            'phone_number' => 'required|regex:/^[0-9\s\-\(\)\+]+$/|max:18',
            'home_address' => 'required|max:255',
        ];
    }
}
