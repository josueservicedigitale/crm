@if(isset($parent))
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">
    @include('back.documents.forms.parent_hidden_fields', ['parent' => $parent])

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0"><i class="fa fa-file-invoice me-2"></i> Informations Facture</h5>
        </div>
        <div class="card-body row">
            <x-form.input type="date" name="date_facture" label="Date de la facture" :value="$document->date_facture ?? ''" required/>
            <x-form.input name="reference_facture" label="Référence facture" :value="$document->reference_facture ?? ''"/>
        </div>
    </div>
@endif
