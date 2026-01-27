@if(isset($parent))
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-invoice me-2"></i> Informations Facture
        </h5>
    </div>

    <div class="card-body row">

        {{-- Liaison avec le devis --}}
        <input type="hidden" name="parent_id" value="{{ $parent->id }}">

        {{-- Copier TOUTES les données du devis --}}
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

        {{-- Champ visible à remplir --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Date de la facture</label>
            <input type="date"
                   name="date_facture"
                   class="form-control"
                   value="{{ old('date_facture', $document->date_facture ?? '') }}"
                   required>
        </div>

        {{-- Champ pour la référence de la facture --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Référence facture</label>
            <input type="text"
                   name="reference_facture"
                   class="form-control"
                   value="{{ old('reference_facture', $document->reference_facture ?? '') }}">
        </div>

    </div>
</div>
@endif