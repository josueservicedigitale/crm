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
                Cahier des charges
            </h5>
        </div>

        <div class="card-body row">

            {{-- Champs affichés en lecture seule --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Référence devis</label>
                <input type="text"
                    class="form-control"
                    value="{{ $parent->reference_devis }}"
                    readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Nom de la résidence</label>
                <input type="text"
                    class="form-control"
                    value="{{ $parent->nom_residence }}"
                    readonly>
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Adresse des travaux</label>
                <input type="text"
                    class="form-control"
                    value="{{ $parent->adresse_travaux }}"
                    readonly>
            </div>

            {{-- SEUL champ éditable --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Date de signature</label>
                <input type="date"
                    name="date_signature"
                    class="form-control"
                    value="{{ old('date_signature', $document->date_signature ?? '') }}"
                    required>
            </div>

        </div>
    </div>
@endif