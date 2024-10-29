<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'delivery_area_id' => ['required', 'exists:delivery_areas,id'],
            'first_name' => ['required', 'max:60'],
            'last_name' => ['nullable', 'max:60'],
            'address' => ['required'],
            'phone' => ['required', 'max:20'],
            'email' => ['required', 'max:60' ,'email'],
            'type' => ['required' ,'in:home,office'],
        ];
    }

    public function messages(): array
    {
        return [
            'delivery_area_id.required' => 'Delivery Area is required',
        ];
    }
}
