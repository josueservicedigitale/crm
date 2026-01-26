@if(isset($parent))
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="fa fa-file-pdf me-2"></i> Rapport</h5>
        </div>
        <div class="card-body row">
            {{-- Référence facture ou devis --}}
            <x-form.input name="reference" label="Référence" :value="$parent->reference_facture ?? $parent->reference_devis ?? $parent->reference" readonly/>

            {{-- Nom résidence et adresse travaux --}}
            <x-form.input name="nom_residence" label="Nom de la résidence" :value="$parent->nom_residence" readonly/>
            <x-form.input name="adresse_travaux" label="Adresse des travaux" :value="$parent->adresse_travaux" readonly/>

            {{-- Date facture --}}
            <x-form.input type="date" name="date_facture" label="Date de la facture" :value="$parent->date_facture ?? ''" readonly/>

            {{-- Infos techniques --}}
            <x-form.input name="volume_circuit" label="Volume circuit" :value="$parent->volume_circuit ?? ''" readonly/>
            <x-form.input name="puissance_chaudiere" label="Puissance chaudière" :value="$parent->puissance_chaudiere ?? ''" readonly/>
            <x-form.input type="number" name="nombre_emetteurs" label="Nombre d’émetteurs" :value="$parent->nombre_emetteurs ?? ''" readonly/>
        </div>
    </div>
@endif
