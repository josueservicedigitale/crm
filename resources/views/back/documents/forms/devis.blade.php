<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-alt me-2"></i> Informations du document
        </h5>
    </div>
    <div class="card-body row">
        {{-- IDENTIFICATION --}}
        <x-form.input name="reference_devis" label="Référence devis" :value="$document->reference_devis ?? ''"/>
        <x-form.input type="date" name="date_devis" label="Date du devis" :value="$document->date_devis ?? ''"/>

        {{-- LOCALISATION --}}
        <x-form.input name="adresse_travaux" label="Adresse des travaux" :value="$document->adresse_travaux ?? ''"/>
        <x-form.input name="numero_immatriculation" label="Numéro d’immatriculation" :value="$document->numero_immatriculation ?? ''"/>

        {{-- BÂTIMENT --}}
        <x-form.input name="nom_residence" label="Nom de la résidence" :value="$document->nom_residence ?? ''"/>
        <x-form.input type="number" name="nombre_batiments" label="Nombre de bâtiments" :value="$document->nombre_batiments ?? ''"/>
        <x-form.textarea name="details_batiments" label="Description du projet / bâtiments">{{ $document->details_batiments ?? '' }}</x-form.textarea>

        {{-- PARCELLES --}}
        @for($i=1; $i<=4; $i++)
            <x-form.input name="parcelle_{{ $i }}" label="Parcelle {{ $i }}" :value="$document->{'parcelle_'.$i} ?? ''"/>
        @endfor

        {{-- DATES --}}
        <x-form.input name="dates_previsionnelles" label="Dates prévisionnelles" :value="$document->dates_previsionnelles ?? ''"/>

        {{-- MONTANTS --}}
        <x-form.input type="number" step="0.01" name="montant_ht" label="Montant HT" :value="$document->montant_ht ?? ''"/>
        <x-form.input type="number" step="0.01" name="montant_tva" label="TVA" :value="$document->montant_tva ?? ''"/>
        <x-form.input type="number" step="0.01" name="montant_ttc" label="Montant TTC" :value="$document->montant_ttc ?? ''"/>
        <x-form.input type="number" step="0.01" name="prime_cee" label="Prime CEE" :value="$document->prime_cee ?? ''"/>
        <x-form.input type="number" step="0.01" name="reste_a_charge" label="Reste à charge" :value="$document->reste_a_charge ?? ''"/>

        {{-- INFORMATIONS TECHNIQUES --}}
        <x-form.input name="puissance_chaudiere" label="Puissance chaudière" :value="$document->puissance_chaudiere ?? ''"/>
        <x-form.input type="number" name="nombre_logements" label="Nombre de logements" :value="$document->nombre_logements ?? ''"/>
        <x-form.input type="number" name="nombre_emetteurs" label="Nombre d’émetteurs" :value="$document->nombre_emetteurs ?? ''"/>
        <x-form.input name="zone_climatique" label="Zone climatique" :value="$document->zone_climatique ?? ''"/>
        <x-form.input name="volume_circuit" label="Volume circuit" :value="$document->volume_circuit ?? ''"/>
        <x-form.input type="number" name="nombre_filtres" label="Nombre filtres" :value="$document->nombre_filtres ?? ''"/>
        <x-form.input name="wh_cumac" label="WH Cumac" :value="$document->wh_cumac ?? ''"/>
        <x-form.input type="number" step="0.01" name="somme" label="Somme" :value="$document->somme ?? ''"/>
    </div>
</div>
