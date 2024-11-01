<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DocumentRequest extends FormRequest
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
            "title" => "required",
            "content" => "required",
        ];
    }

    /**
     * Personaliza as mensagens de erro de validação.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            "title.required" => "O campo título é obrigatório",
            "content.required" => "O campo conteúdo é obrigatório",
        ];
    }

    /**
     * Retorna um array com os dados do documento em formato para
     * ser persistido no banco de dados.
     *
     * @return array<string, mixed>
     */
    public function data(): array
    {
        $data = [
            "title" => $this->title,
            "content" => $this->content,
            "user_id" => Auth::id(),
        ];

        return array_filter($data, fn($v) => isset ($v));
    }
}
