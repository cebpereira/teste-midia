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
            "user_name" => "required|string|max:255",
            "user_role" => "required|string|max:255",
            "user_document" => "required|string|max:255",
            "product_brand" => "required|string|max:255",
            "product_model" => "required|string|max:255",
            "product_serial_number" => "required|string|max:255",
            "product_processor" => "required|string|max:255",
            "product_memory" => "required|string|max:255",
            "product_disk" => "required|string|max:255",
            "product_price" => "required|numeric",
            "product_price_string" => "required|string|max:255",
            "local" => "required|string|max:255",
            "date" => "required|date",
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
            "user_name.required" => "O campo nome de usuário é obrigatório",
            "user_role.required" => "O campo cargo do usuário é obrigatório",
            "user_document.required" => "O campo documento do usuário é obrigatório",
            "product_brand.required" => "O campo marca do produto é obrigatório",
            "product_model.required" => "O campo modelo do produto é obrigatório",
            "product_serial_number.required" => "O campo número de série é obrigatório",
            "product_processor.required" => "O campo processador do produto é obrigatório",
            "product_memory.required" => "O campo memória do produto é obrigatório",
            "product_disk.required" => "O campo armazenamento do produto é obrigatório",
            "product_price.required" => "O campo preço do produto é obrigatório",
            "product_price_string.required" => "O campo preço do produto por extenso é obrigatório",
            "local.required" => "O campo local é obrigatório",
            "date.required" => "O campo data é obrigatório",
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
            "user_name" => $this->input("user_name"),
            "user_role" => $this->input("user_role"),
            "user_document" => $this->input("user_document"),
            "product_brand" => $this->input("product_brand"),
            "product_model" => $this->input("product_model"),
            "product_serial_number" => $this->input("product_serial_number"),
            "product_processor" => $this->input("product_processor"),
            "product_memory" => $this->input("product_memory"),
            "product_disk" => $this->input("product_disk"),
            "product_price" => $this->input("product_price"),
            "product_price_string" => $this->input("product_price_string"),
            "local" => $this->input("local"),
            "date" => $this->input("date"),
            "user_id" => Auth::id(),
        ];

        return array_filter($data, fn($v) => isset($v));
    }
}
