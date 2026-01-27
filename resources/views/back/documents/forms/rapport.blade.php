@if(isset($parent))
    {{-- Liaison avec la facture --}}
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fa fa-file-pdf me-2"></i>
                Rapport
            </h5>
        </div>

        <div class="card-body row">

            {{-- Référence facture ou référence devis si facture absente --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Référence</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->reference_facture ?? $parent->reference_devis ?? $parent->reference }}">
            </div>

            {{-- Nom de la résidence --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Nom de la résidence</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->nom_residence }}">
            </div>

            {{-- Adresse des travaux --}}
            <div class="col-md-12 mb-3">
                <label class="form-label">Adresse des travaux</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->adresse_travaux }}">
            </div>

            {{-- Date de la facture --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Date de la facture</label>
                <input type="date" class="form-control" readonly
                       value="{{ $parent->date_facture ?? '' }}">
            </div>

            {{-- Volume circuit --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Volume circuit</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->volume_circuit ?? '' }}">
            </div>

            {{-- Puissance chaudière --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Puissance chaudière</label>
                <input type="text" class="form-control" readonly
                       value="{{ $parent->puissance_chaudiere ?? '' }}">
            </div>

            {{-- Nombre d'émetteurs --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre d'émetteurs</label>
                <input type="number" class="form-control" readonly
                       value="{{ $parent->nombre_emetteurs ?? '' }}">
            </div>

        </div>
    </div>
@endif