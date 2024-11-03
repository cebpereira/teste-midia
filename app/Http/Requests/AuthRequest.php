<?php

namespace App\Http\Requests;

class AuthRequest extends Request
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
            "email" => "required|email",
            "password" => "required|string",
            "remember" => "boolean"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "Campo e-mail é obrigatório!",
            "email.email" => "Campo e-mail deve estar no formato de e-email.",
            "password.required" => "Campo senha é obrigatório!",
        ];
    }
}
