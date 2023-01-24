<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|string|unique:users,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
            ],
            'role' => 'required|string',
            'image' => 'nullable|string',
            'department'=> 'required|string',
            'course' => 'nullable|string',
            'about' => 'required|string',
            'address' => 'nullable|string',
            'birthday' => 'nullable|string',
            'joining_date' => 'nullable|string',
            'mobile' => 'nullable|string',
            'languages' => 'nullable|string'
        ];
    }
}
