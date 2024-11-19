<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCountryRequest extends FormRequest
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
            'nome_pais' => ['required', 'string', 'max:255'],
            'sigla' => ['required', 'string', 'max:255'],
            'ddi' => ['nullable', 'numeric'],
            'siscomex' => ['nullable', 'string', 'max:50'],
            'cod_sped' => ['nullable', 'string', 'max:50'],
            'img_bandeira' => ['nullable', 'string'],
            'file'=> ['nullable', 'file']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nome_pais.required' => 'O campo nome é obrigatório.',
            'sigla.required' => 'O campo sigla é obrigatório.',
            'sigla.max' => 'O campo sigla deve ter no mínimo 255 caracteres.',
            //'ddi.max' => 'O campo ddi deve ter no máximo 4 caracteres.',
            'siscomex.max' => 'O campo siscomex deve ter noções 50 caracteres.',
            'cod_sped.max' => 'O campo cod_sped deve ter no mínimo 50 caracteres.'
        ];
    }
}
