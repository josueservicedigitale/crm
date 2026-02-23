@if(isset($parent))
    {{-- Liaison avec le devis --}}
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">

    {{-- Copier TOUTES les données du devis (silencieux) --}}
    @foreach($parent->getAttributes() as $key => $value)
        @if(!in_array($key, [
            'id',
            'reference',
            'type',
            'parent_id',
            'created_at',
            'updated_at',
            'file_path'
        ]))
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endif
    @endforeach

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fa fa-book me-2"></i>
                Données du devis
            </h5>
            <small class="text-dark-50">Ces informations sont issues du devis et servent de base</small>
        </div>

        <div class="card-body row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Référence devis</label>
                <input type="text" class="form-control bg-light" value="{{ $parent->reference_devis }}" readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Date du devis</label>
                <input type="date" class="form-control bg-light" value="{{ $parent->date_devis }}" readonly>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold">Adresse des travaux</label>
                <input type="text" class="form-control bg-light" value="{{ $parent->adresse_travaux }}" readonly>
            </div>
        </div>
    </div>
@endif

{{-- =========================================== --}}
{{-- SECTION OFFRES ET PRIMES (AVEC CHECKBOXES) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-gift me-2"></i>
            Offres et primes
        </h5>
        <small class="text-white-50">Cochez les options et saisissez les montants correspondants</small>
    </div>
    
    <div class="card-body">
        {{-- PRIME CEE --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="checkbox" name="prime_cee_check" value="1" 
                           class="form-check-input" id="prime_cee_check"
                           {{ old('prime_cee_check', ($document->prime_cee ?? false) ? 'checked' : '') }}
                           onclick="toggleField('prime_cee', this)">
                    <label class="form-check-label fw-bold" for="prime_cee_check">
                        Prime CEE
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" name="prime_cee" 
                       class="form-control @error('prime_cee') is-invalid @enderror"
                       id="prime_cee_field"
                       value="{{ old('prime_cee', $document->prime_cee ?? '') }}"
                       placeholder="Montant de la prime (€)">
                @error('prime_cee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- BON D'ACHAT --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="checkbox" name="bon_achat_check" value="1" 
                           class="form-check-input" id="bon_achat_check"
                           {{ old('bon_achat_check', ($document->bon_achat ?? false) ? 'checked' : '') }}
                           onclick="toggleField('bon_achat', this)">
                    <label class="form-check-label fw-bold" for="bon_achat_check">
                        Bon d'achat
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" name="bon_achat" 
                       class="form-control @error('bon_achat') is-invalid @enderror"
                       id="bon_achat_field"
                       value="{{ old('bon_achat', $document->bon_achat ?? '') }}"
                       placeholder="Montant du bon d'achat (€)">
                @error('bon_achat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- PRÊT BONIFIÉ --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="checkbox" name="pret_check" value="1" 
                           class="form-check-input" id="pret_check"
                           {{ old('pret_check', ($document->pret_bonifie ?? false) ? 'checked' : '') }}
                           onclick="togglePretFields(this)">
                    <label class="form-check-label fw-bold" for="pret_check">
                        Prêt bonifié
                    </label>
                </div>
            </div>
            <div class="col-md-4 pret-field">
                <label class="form-label fw-bold">Montant du prêt (€)</label>
                <input type="number" step="0.01" name="pret_bonifie" 
                       class="form-control @error('pret_bonifie') is-invalid @enderror"
                       id="pret_bonifie_field"
                       value="{{ old('pret_bonifie', $document->pret_bonifie ?? '') }}"
                       placeholder="Ex: 5000.00">
                @error('pret_bonifie')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 pret-field">
                <label class="form-label fw-bold">Organisme prêteur</label>
                <input type="text" name="pret_organisme" 
                       class="form-control @error('pret_organisme') is-invalid @enderror"
                       id="pret_organisme_field"
                       value="{{ old('pret_organisme', $document->pret_organisme ?? '') }}"
                       placeholder="Ex: Crédit Agricole">
                @error('pret_organisme')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 pret-field">
                <label class="form-label fw-bold">TEG (%)</label>
                <input type="number" step="0.01" name="pret_teg" 
                       class="form-control @error('pret_teg') is-invalid @enderror"
                       id="pret_teg_field"
                       value="{{ old('pret_teg', $document->pret_teg ?? '') }}"
                       placeholder="Ex: 1.5">
                @error('pret_teg')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- AUDIT --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="checkbox" name="audit_check" value="1" 
                           class="form-check-input" id="audit_check"
                           {{ old('audit_check', $document->audit ?? false) ? 'checked' : '' }}
                           onclick="toggleField('audit_valeur', this)">
                    <label class="form-check-label fw-bold" for="audit_check">
                        Audit ou conseil personnalisé
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <input type="number" step="0.01" name="audit_valeur" 
                       class="form-control @error('audit_valeur') is-invalid @enderror"
                       id="audit_valeur_field"
                       value="{{ old('audit_valeur', $document->audit_valeur ?? '') }}"
                       placeholder="Valeur de l'audit (€)">
                @error('audit_valeur')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- PRODUIT OFFERT --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="form-check mb-2">
                    <input type="checkbox" name="produit_offert_check" value="1" 
                           class="form-check-input" id="produit_offert_check"
                           {{ old('produit_offert_check', $document->produit_offert ?? false) ? 'checked' : '' }}
                           onclick="toggleProduitOffert(this)">
                    <label class="form-check-label fw-bold" for="produit_offert_check">
                        Produit ou service offert
                    </label>
                </div>
            </div>
            <div class="col-md-6">
                <input type="text" name="produit_offert_nature" 
                       class="form-control mb-2 @error('produit_offert_nature') is-invalid @enderror"
                       id="produit_offert_nature_field"
                       value="{{ old('produit_offert_nature', $document->produit_offert_nature ?? '') }}"
                       placeholder="Nature du produit/service">
                <input type="number" step="0.01" name="produit_offert_valeur" 
                       class="form-control @error('produit_offert_valeur') is-invalid @enderror"
                       id="produit_offert_valeur_field"
                       value="{{ old('produit_offert_valeur', $document->produit_offert_valeur ?? '') }}"
                       placeholder="Valeur (€)">
                @error('produit_offert_nature')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @error('produit_offert_valeur')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION TRAVAUX (TOUS ÉDITABLES) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fa fa-tools me-2"></i>
            Travaux
        </h5>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label fw-bold">Nature des travaux</label>
                <textarea name="nature_travaux" rows="3" 
                          class="form-control @error('nature_travaux') is-invalid @enderror"
                          placeholder="Description des travaux...">{{ old('nature_travaux', $document->nature_travaux ?? '') }}</textarea>
                @error('nature_travaux')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Fiche CEE</label>
                <input type="text" name="fiche_cee" 
                       class="form-control @error('fiche_cee') is-invalid @enderror"
                       value="{{ old('fiche_cee', $document->fiche_cee ?? 'BAR-SE-109') }}"
                       placeholder="Ex: BAR-SE-109">
                @error('fiche_cee')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION BÉNÉFICIAIRE (TOUS ÉDITABLES) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fa fa-user me-2"></i>
            Bénéficiaire
        </h5>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nom</label>
                <input type="text" name="beneficiaire_nom" 
                       class="form-control @error('beneficiaire_nom') is-invalid @enderror"
                       value="{{ old('beneficiaire_nom', $document->beneficiaire_nom ?? '') }}"
                       placeholder="Ex: RABATHERM HECS">
                @error('beneficiaire_nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Prénom</label>
                <input type="text" name="beneficiaire_prenom" 
                       class="form-control @error('beneficiaire_prenom') is-invalid @enderror"
                       value="{{ old('beneficiaire_prenom', $document->beneficiaire_prenom ?? '') }}"
                       placeholder="Prénom">
                @error('beneficiaire_prenom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input type="tel" name="beneficiaire_telephone" 
                       class="form-control @error('beneficiaire_telephone') is-invalid @enderror"
                       value="{{ old('beneficiaire_telephone', $document->beneficiaire_telephone ?? '') }}"
                       placeholder="01 23 45 67 89">
                @error('beneficiaire_telephone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input type="email" name="beneficiaire_email" 
                       class="form-control @error('beneficiaire_email') is-invalid @enderror"
                       value="{{ old('beneficiaire_email', $document->beneficiaire_email ?? '') }}"
                       placeholder="contact@exemple.fr">
                @error('beneficiaire_email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION SIGNATURE --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">
            <i class="fa fa-pen me-2"></i>
            Signature
        </h5>
    </div>
    
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nom du signataire</label>
                <input type="text" name="signataire_nom" 
                       class="form-control @error('signataire_nom') is-invalid @enderror"
                       value="{{ old('signataire_nom', $document->signataire_nom ?? '') }}"
                       placeholder="Ex: HAMLET TAMOYAN">
                @error('signataire_nom')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Fonction</label>
                <input type="text" name="signataire_fonction" 
                       class="form-control @error('signataire_fonction') is-invalid @enderror"
                       value="{{ old('signataire_fonction', $document->signataire_fonction ?? '') }}"
                       placeholder="Ex: Président">
                @error('signataire_fonction')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Date de signature</label>
                <input type="date" name="date_signature" 
                       class="form-control @error('date_signature') is-invalid @enderror"
                       value="{{ old('date_signature', $document->date_signature ?? now()->format('Y-m-d')) }}">
                @error('date_signature')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Cachet / Tampon</label>
                <input type="file" name="cachet_image" class="form-control" accept="image/*">
                @if($document->cachet_image ?? false)
                    <div class="mt-2">
                        <img src="{{ Storage::url($document->cachet_image) }}" height="50">
                        <small class="text-muted ms-2">Image actuelle</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SCRIPT POUR GÉRER LES CHECKBOXES --}}
{{-- =========================================== --}}
@push('scripts')
<script>
function toggleField(fieldId, checkbox) {
    const field = document.getElementById(fieldId + '_field');
    if (field) {
        // Le champ est désactivé seulement si la checkbox n'est PAS cochée
        field.disabled = !checkbox.checked;
    }
}

function togglePretFields(checkbox) {
    const fields = ['pret_bonifie', 'pret_organisme', 'pret_teg'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId + '_field');
        if (field) {
            field.disabled = !checkbox.checked;
        }
    });
}

function toggleProduitOffert(checkbox) {
    const natureField = document.getElementById('produit_offert_nature_field');
    const valeurField = document.getElementById('produit_offert_valeur_field');
    
    [natureField, valeurField].forEach(field => {
        if (field) {
            field.disabled = !checkbox.checked;
        }
    });
}

// Initialisation au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Prime CEE
    const primeCheck = document.getElementById('prime_cee_check');
    if (primeCheck) {
        toggleField('prime_cee', primeCheck);
    }
    
    // Bon d'achat
    const bonAchatCheck = document.getElementById('bon_achat_check');
    if (bonAchatCheck) {
        toggleField('bon_achat', bonAchatCheck);
    }
    
    // Prêt
    const pretCheck = document.getElementById('pret_check');
    if (pretCheck) {
        togglePretFields(pretCheck);
    }
    
    // Audit
    const auditCheck = document.getElementById('audit_check');
    if (auditCheck) {
        toggleField('audit_valeur', auditCheck);
    }
    
    // Produit offert
    const produitCheck = document.getElementById('produit_offert_check');
    if (produitCheck) {
        toggleProduitOffert(produitCheck);
    }
});
</script>
@endpush

{{-- =========================================== --}}
{{-- BOUTONS D'ACTION --}}
{{-- =========================================== --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <button type="button" class="btn btn-secondary" onclick="history.back()">
        <i class="fa fa-times me-2"></i>Annuler
    </button>
    <button type="submit" class="btn btn-primary">
        <i class="fa fa-save me-2"></i>Générer le document
    </button>
</div>