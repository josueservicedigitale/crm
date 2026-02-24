{{-- ================================================= --}}
{{-- PARENT (DEVIS) : readonly + valeurs envoyées --}}
{{-- ================================================= --}}
@if(isset($parent))
  <input type="hidden" name="parent_id" value="{{ $parent->id }}">

  {{-- On stocke dans l’enfant : --}}
  <input type="hidden" name="reference_devis" value="{{ old('reference_devis', $parent->reference_devis) }}">
  <input type="hidden" name="date_devis" value="{{ old('date_devis', $parent->date_devis) }}">
  <input type="hidden" name="adresse_travaux" value="{{ old('adresse_travaux', $parent->adresse_travaux) }}">
  <input type="hidden" name="numero_immatriculation" value="{{ old('numero_immatriculation', $parent->numero_immatriculation) }}">
  <input type="hidden" name="nom_residence" value="{{ old('nom_residence', $parent->nom_residence) }}">
  <input type="hidden" name="prime_cee" value="{{ old('prime_cee', $parent->prime_cee) }}">

  <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-warning text-dark">
      <h5 class="mb-0"><i class="fa fa-book me-2"></i>Données du devis (Parent)</h5>
      <small class="text-dark-50">Récupérées automatiquement</small>
    </div>

    <div class="card-body row">
      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Référence devis</label>
        <input type="text" class="form-control bg-light" value="{{ $parent->reference_devis }}" readonly>
      </div>

      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Date devis</label>
        <input type="date" class="form-control bg-light" value="{{ $parent->date_devis }}" readonly>
      </div>

      <div class="col-md-4 mb-3">
        <label class="form-label fw-bold">Immatriculation</label>
        <input type="text" class="form-control bg-light" value="{{ $parent->numero_immatriculation }}" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Nom résidence</label>
        <input type="text" class="form-control bg-light" value="{{ $parent->nom_residence }}" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Adresse des travaux</label>
        <input type="text" class="form-control bg-light" value="{{ $parent->adresse_travaux }}" readonly>
      </div>

      <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Prime CEE (du devis)</label>
        <input type="text" class="form-control bg-light" value="{{ number_format($parent->prime_cee ?? 0,2,',',' ') }}" readonly>
      </div>
    </div>
  </div>
@endif


{{-- ================================================= --}}
{{-- OFFRES & PRIMES : ici, la “case noire” du PDF dépend des montants > 0 --}}
{{-- ================================================= --}}
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-primary text-white">
    <h5 class="mb-0"><i class="fa fa-gift me-2"></i>Offres et primes</h5>
    <small class="text-white-50">Saisis les montants : le PDF cochera automatiquement</small>
  </div>

  <div class="card-body row g-3">

    <div class="col-md-4">
      <label class="form-label fw-bold">Prime CEE (€)</label>
      <input type="number" step="0.01" name="prime_cee"
             class="form-control @error('prime_cee') is-invalid @enderror"
             value="{{ old('prime_cee', $document->prime_cee ?? '') }}"
             @if(isset($parent)) readonly @endif>
      @error('prime_cee') <div class="invalid-feedback">{{ $message }}</div> @enderror
      @if(isset($parent)) <small class="text-muted">Vient du devis (readonly)</small> @endif
    </div>

    <div class="col-md-4">
      <label class="form-label fw-bold">Bon d’achat (€)</label>
      <input type="number" step="0.01" name="bon_achat"
             class="form-control @error('bon_achat') is-invalid @enderror"
             value="{{ old('bon_achat', $document->bon_achat ?? '') }}"
             placeholder="Ex: 200.00">
      @error('bon_achat') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4">
      <label class="form-label fw-bold">Prêt bonifié (€)</label>
      <input type="number" step="0.01" name="pret_bonifie"
             class="form-control @error('pret_bonifie') is-invalid @enderror"
             value="{{ old('pret_bonifie', $document->pret_bonifie ?? '') }}"
             placeholder="Ex: 5000.00">
      @error('pret_bonifie') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label class="form-label fw-bold">Organisme prêteur</label>
      <input type="text" name="pret_organisme"
             class="form-control @error('pret_organisme') is-invalid @enderror"
             value="{{ old('pret_organisme', $document->pret_organisme ?? '') }}"
             placeholder="Ex: Crédit Agricole">
      @error('pret_organisme') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label class="form-label fw-bold">TEG (%)</label>
      <input type="number" step="0.01" name="pret_teg"
             class="form-control @error('pret_teg') is-invalid @enderror"
             value="{{ old('pret_teg', $document->pret_teg ?? '') }}"
             placeholder="Ex: 1.5">
      @error('pret_teg') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- AUDIT : vrai champ bool en DB --}}
    <div class="col-md-12">
      <div class="form-check mt-2">
        <input type="hidden" name="audit" value="0">
        <input type="checkbox" class="form-check-input" id="audit" name="audit" value="1"
               {{ old('audit', $document->audit ?? false) ? 'checked' : '' }}>
        <label class="form-check-label fw-bold" for="audit">Audit / conseil personnalisé</label>
      </div>
    </div>

    <div class="col-md-4">
      <label class="form-label fw-bold">Valeur audit (€)</label>
      <input type="number" step="0.01" name="audit_valeur"
             class="form-control @error('audit_valeur') is-invalid @enderror"
             value="{{ old('audit_valeur', $document->audit_valeur ?? '') }}"
             placeholder="Ex: 120.00">
      @error('audit_valeur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- PRODUIT OFFERT : vrai champ bool en DB --}}
    <div class="col-md-12">
      <div class="form-check mt-2">
        <input type="hidden" name="produit_offert" value="0">
        <input type="checkbox" class="form-check-input" id="produit_offert" name="produit_offert" value="1"
               {{ old('produit_offert', $document->produit_offert ?? false) ? 'checked' : '' }}>
        <label class="form-check-label fw-bold" for="produit_offert">Produit / service offert</label>
      </div>
    </div>

    <div class="col-md-6">
      <label class="form-label fw-bold">Nature du produit</label>
      <input type="text" name="produit_offert_nature"
             class="form-control @error('produit_offert_nature') is-invalid @enderror"
             value="{{ old('produit_offert_nature', $document->produit_offert_nature ?? '') }}"
             placeholder="Ex: Filtre offert">
      @error('produit_offert_nature') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6">
      <label class="form-label fw-bold">Valeur (€)</label>
      <input type="number" step="0.01" name="produit_offert_valeur"
             class="form-control @error('produit_offert_valeur') is-invalid @enderror"
             value="{{ old('produit_offert_valeur', $document->produit_offert_valeur ?? '') }}"
             placeholder="Ex: 80.00">
      @error('produit_offert_valeur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

  </div>
</div>


{{-- ================================================= --}}
{{-- TRAVAUX (template utilise nature_travaux + fiche_cee) --}}
{{-- ================================================= --}}
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0"><i class="fa fa-tools me-2"></i>Travaux</h5>
  </div>

  <div class="card-body row">
    <div class="col-md-8 mb-3">
      <label class="form-label fw-bold">Nature des travaux</label>
      <textarea name="nature_travaux" rows="3"
                class="form-control @error('nature_travaux') is-invalid @enderror">{{ old('nature_travaux', $document->nature_travaux ?? '') }}</textarea>
      @error('nature_travaux') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
      <label class="form-label fw-bold">Fiche CEE</label>
      <input type="text" name="fiche_cee"
             class="form-control @error('fiche_cee') is-invalid @enderror"
             value="{{ old('fiche_cee', $document->fiche_cee ?? 'BAR-SE-109') }}">
      @error('fiche_cee') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>
</div>


{{-- ================================================= --}}
{{-- BÉNÉFICIAIRE --}}
{{-- ================================================= --}}
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-success text-white">
    <h5 class="mb-0"><i class="fa fa-user me-2"></i>Bénéficiaire</h5>
  </div>

  <div class="card-body row">
    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Nom</label>
      <input type="text" name="beneficiaire_nom"
             class="form-control @error('beneficiaire_nom') is-invalid @enderror"
             value="{{ old('beneficiaire_nom', $document->beneficiaire_nom ?? '') }}">
      @error('beneficiaire_nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Prénom</label>
      <input type="text" name="beneficiaire_prenom"
             class="form-control @error('beneficiaire_prenom') is-invalid @enderror"
             value="{{ old('beneficiaire_prenom', $document->beneficiaire_prenom ?? '') }}">
      @error('beneficiaire_prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Téléphone</label>
      <input type="text" name="beneficiaire_telephone"
             class="form-control @error('beneficiaire_telephone') is-invalid @enderror"
             value="{{ old('beneficiaire_telephone', $document->beneficiaire_telephone ?? '') }}">
      @error('beneficiaire_telephone') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Email</label>
      <input type="email" name="beneficiaire_email"
             class="form-control @error('beneficiaire_email') is-invalid @enderror"
             value="{{ old('beneficiaire_email', $document->beneficiaire_email ?? '') }}">
      @error('beneficiaire_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
  </div>
</div>


{{-- ================================================= --}}
{{-- SIGNATURE --}}
{{-- ================================================= --}}
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-secondary text-white">
    <h5 class="mb-0"><i class="fa fa-pen me-2"></i>Signature</h5>
  </div>

  <div class="card-body row">
    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Nom du signataire</label>
      <input type="text" name="signataire_nom"
             class="form-control @error('signataire_nom') is-invalid @enderror"
             value="{{ old('signataire_nom', $document->signataire_nom ?? '') }}">
      @error('signataire_nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Fonction</label>
      <input type="text" name="signataire_fonction"
             class="form-control @error('signataire_fonction') is-invalid @enderror"
             value="{{ old('signataire_fonction', $document->signataire_fonction ?? '') }}">
      @error('signataire_fonction') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Date de signature</label>
      <input type="date" name="date_signature"
             class="form-control @error('date_signature') is-invalid @enderror"
             value="{{ old('date_signature', $document->date_signature ?? now()->format('Y-m-d')) }}">
      @error('date_signature') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-6 mb-3">
      <label class="form-label fw-bold">Cachet / Tampon</label>
      <input type="file" name="cachet_image" class="form-control" accept="image/*">
    </div>
  </div>
</div>