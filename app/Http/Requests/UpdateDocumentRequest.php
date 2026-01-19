<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

 public function rules()
{
    return [
        // 🔴 OBLIGATOIRES (BASE)
        'reference' => 'required|string|max:255|unique:documents,reference',
        'society'   => 'required|string|max:255',
        'activity'  => 'required|string|max:255',
        'type'      => 'required|string|max:255',

        // 🔴 user_id JAMAIS envoyé depuis le formulaire
        // il vient de Auth::id()

        // 🟢 Champs optionnels
        'reference_devis'        => 'nullable|string',
        'date_devis'             => 'nullable|date',
        'adresse_travaux'        => 'nullable|string',
        'numero_immatriculation' => 'nullable|string',
        'nom_residence'          => 'nullable|string',
        'parcelle_1'             => 'nullable|string',
        'parcelle_2'             => 'nullable|string',
        'parcelle_3'             => 'nullable|string',
        'parcelle_4'             => 'nullable|string',
        'dates_previsionnelles'  => 'nullable|string',
        'nombre_batiments'       => 'nullable|integer',
        'details_batiments'      => 'nullable|string',
        'montant_ht'             => 'nullable|numeric',
        'montant_tva'            => 'nullable|numeric',
        'montant_ttc'            => 'nullable|numeric',
        'prime_cee'              => 'nullable|numeric',
        'reste_a_charge'         => 'nullable|numeric',
        'volume_total'           => 'nullable|string',
        'date_travaux'           => 'nullable|date',
        'date_signature'         => 'nullable|date',
        'date_facture'           => 'nullable|date',
        'reference_facture'      => 'nullable|string',
        'linked_devis'           => 'nullable|string',
        'linked_facture'         => 'nullable|string',
        'file_path'              => 'nullable|string',
    ];
}

}