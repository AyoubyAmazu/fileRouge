<?php

namespace Modules\PkgEntretienIndividuel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'formulaire_id' => 'required|exists:formulaires,id',
            'enonce' => 'required|string',
            'type' => 'required|in:texte_libre,choix_unique,choix_multiple',
            'ordre' => 'required|integer',
            'obligatoire' => 'boolean',
        
        ];
    }
}
