<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $documentId = $this->route('document'); // Récupère l'ID du document depuis la route

        return [
            // 🔴 OBLIGATOIRES (BASE) - Sauf reference qui peut être modifiée mais doit rester unique
            'reference' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('documents')->ignore($documentId)
            ],
            'society' => 'sometimes|required|string|max:255',
            'activity' => 'sometimes|required|string|max:255',
            'type' => 'sometimes|required|string|max:255',

            // 🟢 Champs optionnels existants
            'reference_devis' => 'nullable|string',
            'date_devis' => 'nullable|date',
            'adresse_travaux' => 'nullable|string',
            'numero_immatriculation' => 'nullable|string',
            'nom_residence' => 'nullable|string',
            'parcelle_1' => 'nullable|string',
            'parcelle_2' => 'nullable|string',
            'parcelle_3' => 'nullable|string',
            'parcelle_4' => 'nullable|string',
            'dates_previsionnelles' => 'nullable|string',
            'nombre_batiments' => 'nullable|integer',
            'details_batiments' => 'nullable|string',
            'montant_ht' => 'nullable|numeric',
            'montant_tva' => 'nullable|numeric',
            'montant_ttc' => 'nullable|numeric',
            'prime_cee' => 'nullable|numeric',
            'reste_a_charge' => 'nullable|numeric',
            'puissance_chaudiere' => 'nullable|string',
            'nombre_logements' => 'nullable|integer',
            'nombre_emetteurs' => 'nullable|integer',
            'zone_climatique' => 'nullable|string',
            'volume_circuit' => 'nullable|string',
            'nombre_filtres' => 'nullable|integer',
            'wh_cumac' => 'nullable|string',
            'somme' => 'nullable|numeric',
            'volume_total' => 'nullable|string',
            'date_travaux' => 'nullable|date',
            'date_signature' => 'nullable|date',
            'date_facture' => 'nullable|date',
            'reference_facture' => 'nullable|string',
            'linked_devis' => 'nullable|string',
            'linked_facture' => 'nullable|string',
            'file_path' => 'nullable|string',
            'parent_id' => 'nullable|exists:documents,id',

            // ✅ NOUVEAUX CHAMPS PRODUITS
            'pompe_type' => 'nullable|string|in:Pompe Jet Flush,JetFlush Filter,Kiloutou,Vixax,autre',
            'pompe_autre_texte' => 'nullable|string|required_if:pompe_type,autre',
            'reactif_desembouant' => 'nullable|string|in:Sentinel X400,Sentinel X800,autre',
            'autre_produit_desembouant' => 'nullable|string|required_if:reactif_desembouant,autre',
            'reactif_inhibiteur' => 'nullable|string|in:Sentinel X100,Sentinel X700,autre',
            'autre_produit_inhibiteur' => 'nullable|string|required_if:reactif_inhibiteur,autre',
            'filtre_type' => 'nullable|string|in:Sentinel Vortex300,Sentinel Vortex500,autre',
            'filtre_autre_texte' => 'nullable|string|required_if:filtre_type,autre',

            // ✅ CRITÈRES D'INSTALLATION
            'batiment_existant' => 'nullable|string|in:oui,non',
            'type_logement' => 'nullable|string|in:maison,appartement',
            'installation_collective' => 'nullable|string|in:oui,non',
            'type_generateur' => 'nullable|string|in:chaudiere_hors_condensation,chaudiere_condensation,reseau_chaleur,autre',
            'autre_type_generateur' => 'nullable|string|required_if:type_generateur,autre',
            'nature_reseau' => 'nullable|string|in:cuivre,acier,multicouche,synthese,autre',
            'autre_nature_reseau' => 'nullable|string|required_if:nature_reseau,autre',
            'surface_plancher_chauffant' => 'nullable|numeric',
            // ✅ NOUVELLES RÈGLES
            'nature_travaux' => 'nullable|string',
            'fiche_cee' => 'nullable|string|max:50',
            'date_engagement' => 'nullable|date',

            // ✅ ÉTAPES RÉALISÉES
            'etapes_realisees' => 'nullable|array',
            'etapes_realisees.*' => 'integer|in:1,2,3,4',

            // ✅ NOTES
            'notes_complementaires' => 'nullable|string',

            // ✅ IMAGES (upload - en update on peut les remplacer)
            'cachet_image' => 'nullable|image|max:2048',
            'signature_image' => 'nullable|image|max:2048',
            'sentinel_logo' => 'nullable|image|max:2048',
            'icone_1' => 'nullable|image|max:2048',
            'icone_2' => 'nullable|image|max:2048',

            // ✅ Champs JSON (ils passeront directement)
            'produits_utilises' => 'nullable|json',
            'checkboxes' => 'nullable|json',
            'images' => 'nullable|json',
        ];
    }

    /**
     * Messages d'erreur personnalisés
     */
    public function messages()
    {
        return [
            'pompe_autre_texte.required_if' => 'Veuillez préciser le modèle de pompe',
            'autre_produit_desembouant.required_if' => 'Veuillez préciser le réactif désembouant',
            'autre_produit_inhibiteur.required_if' => 'Veuillez préciser le réactif inhibiteur',
            'filtre_autre_texte.required_if' => 'Veuillez préciser le modèle de filtre',
            'autre_type_generateur.required_if' => 'Veuillez préciser le type de générateur',
            'autre_nature_reseau.required_if' => 'Veuillez préciser la nature du réseau',
            'reference.unique' => 'Cette référence est déjà utilisée',
        ];
    }

    /**
     * Préparation des données avant validation
     */
    protected function prepareForValidation()
    {
        // Convertir les tableaux en JSON si nécessaire
        if ($this->has('produits_utilises') && is_array($this->produits_utilises)) {
            $this->merge([
                'produits_utilises' => json_encode($this->produits_utilises)
            ]);
        }

        if ($this->has('checkboxes') && is_array($this->checkboxes)) {
            $this->merge([
                'checkboxes' => json_encode($this->checkboxes)
            ]);
        }

        if ($this->has('images') && is_array($this->images)) {
            $this->merge([
                'images' => json_encode($this->images)
            ]);
        }
    }
}