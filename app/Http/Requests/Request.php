<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
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
            //
        ];
    }

    public function prepareForValidation(): void
    {
        $this->mergeIfMissing([
            "date_start" => "2000-01-01",
            "date_end" => "now",
            "use_time_start" => false,
            "use_time_end" => false,
            "date_field" => "created_at",
            "sortby_keyword" => "created_at",
            "sortby_order" => "ASC",
            "limit" => 1000,
            "columns" => "*",
            "trashed" => false
        ]);
    }
}
