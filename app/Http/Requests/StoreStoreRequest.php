<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The store name is required.',
            'name.string' => 'The store name must be a valid string.',
            'name.max' => 'The store name cannot exceed 255 characters.',
            'description.string' => 'The description must be a valid string.',
        ];
    }

    public function prepareForValidation()
    {
        // Automatically set the created_by_user_id as the authenticated user's ID
        $this->merge([
            'created_by_user_id' => Auth::id(),
        ]);
    }
}
