<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreLocationRequest extends FormRequest
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
            'location_name' => 'required|string|max:255',
            'store_code' => 'required|max:5',
            'address_line1' => 'required|max:255',
            'city' => 'required|max:255',
            'country' => 'required|max:255',
        ];    
    }

    public function prepareForValidation(): void
    {
        $uuid = Str::uuid();

        // Automatically set the created_by_user_id as the authenticated user's ID
        $this->merge([
            'uuid' => $uuid           
        ]);
    }
}
