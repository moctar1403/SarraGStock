<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'orderClients.*.cli_nom' => ['required','string','min:3'],
            'orderClients.*.cli_societe' => ['required','string'],
            'orderClients.*.cli_civilite' => ['required','string'],
            'orderClients.*.cli_tel' => ['required','numeric','digits:8'],
            'orderClients.*.cli_adresse' => ['required','string'],
            'orderClients.*.cli_email' => ['required','email'],
            'orderClients.*.cli_observations' => ['required','string'],
        ];
    }
    public function messages(): array
    {
        return[
            'orderClients.*.cli_nom.required' => 'Le champs est requis',
            'orderClients.*.cli_nom.string' => ' doit etre une chaine',
            'orderClients.*.cli_nom.min' => 'minimum 3 caractères',
            'orderClients.*.cli_societe.required' => 'Le champs est requis',
            'orderClients.*.cli_societe.string' => 'doit etre une chaine',
            'orderClients.*.cli_civilite.required' => 'Le champs est requis',
            'orderClients.*.cli_civilite.string' => 'doit etre une chaine',
            'orderClients.*.cli_tel.required' => 'Le champs est requis',
            'orderClients.*.cli_tel.numeric' => 'doit etre numeric',
            'orderClients.*.cli_tel.digits' => 'minimum 8',
            'orderClients.*.cli_adresse.required' => 'Le champs est requis',
            'orderClients.*.cli_adresse.string' => ' doit etre une chaine',
            'orderClients.*.cli_email.required' => 'Le champs est requis',
            'orderClients.*.cli_email.email' => ' doit etre un email',
            'orderClients.*.cli_observations.required' => 'Le champs est requis',
            'orderClients.*.cli_observations.string' => ' doit etre une chaine',
        ];

    }
}
