@if(isset($parent))
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
    @include('back.documents.forms.parent_hidden_fields', ['parent' => $parent])

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0"><i class="fa fa-cahier me-2"></i> Cahier des charges</h5>
        </div>
        <div class="card-body row">
            {{-- Champs en lecture seule --}}
            <x-form.input name="reference_devis" label="Référence devis" :value="$parent->reference_devis" readonly/>
            <x-form.input name="nom_residence" label="Nom de la résidence" :value="$parent->nom_residence" readonly/>
            <x-form.input name="adresse_travaux" label="Adresse des travaux" :value="$parent->adresse_travaux" readonly/>

            {{-- Champ éditable --}}
            <x-form.input type="date" name="date_signature" label="Date de signature" :value="$document->date_signature ?? ''" required/>
        </div>
    </div>
@endif
