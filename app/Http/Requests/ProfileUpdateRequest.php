<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $rules['email'] = ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()];
        }

        return $rules;
    }
}
