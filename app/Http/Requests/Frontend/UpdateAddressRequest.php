<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'update_delivery_area_id' => ['required', 'exists:delivery_areas,id'],
            'update_first_name' => ['required', 'max:60'],
            'update_last_name' => ['nullable', 'max:60'],
            'update_address' => ['required'],
            'update_phone' => ['required', 'max:20'],
            'update_email' => ['required', 'max:60' ,'email'],
            'update_type' => ['required' ,'in:home,office'],
        ];
    }
}
