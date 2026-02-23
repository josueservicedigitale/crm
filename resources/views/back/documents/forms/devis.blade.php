<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-alt me-2"></i> Informations du document
        </h5>
    </div>

    <div class="card-body row">

        {{-- IDENTIFICATION --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Référence devis</label>
            <input type="text" name="reference_devis" class="form-control"
                   value="{{ old('reference_devis', $document->reference_devis ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Date du devis</label>
            <input type="date" name="date_devis" class="form-control"
                   value="{{ old('date_devis', $document->date_devis ?? '') }}">
        </div>

        {{-- LOCALISATION --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Adresse des travaux</label>
            <input type="text" name="adresse_travaux" class="form-control"
                   value="{{ old('adresse_travaux', $document->adresse_travaux ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Numéro d'immatriculation</label>
            <input type="text" name="numero_immatriculation" class="form-control"
                   value="{{ old('numero_immatriculation', $document->numero_immatriculation ?? '') }}">
        </div>

        {{-- BÂTIMENT --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Nom de la résidence</label>
            <input type="text" name="nom_residence" class="form-control"
                   value="{{ old('nom_residence', $document->nom_residence ?? '') }}">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre de bâtiments</label>
            <input type="number" name="nombre_batiments" class="form-control"
                   value="{{ old('nombre_batiments', $document->nombre_batiments ?? '') }}">
        </div>

        <div class="col-md-12 mb-2">
            <label class="form-label">Description du bâtiments</label>
            <textarea name="details_batiments" rows="3" class="form-control">{{ old('details_batiments', $document->details_batiments ?? '') }}</textarea>
        </div>

        {{-- PARCELLES --}}
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 1</label>
            <input type="text" name="parcelle_1" class="form-control"
                   value="{{ old('parcelle_1', $document->parcelle_1 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 2</label>
            <input type="text" name="parcelle_2" class="form-control"
                   value="{{ old('parcelle_2', $document->parcelle_2 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 3</label>
            <input type="text" name="parcelle_3" class="form-control"
                   value="{{ old('parcelle_3', $document->parcelle_3 ?? '') }}">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Parcelle 4</label>
            <input type="text" name="parcelle_4" class="form-control"
                   value="{{ old('parcelle_4', $document->parcelle_4 ?? '') }}">
        </div>

        {{-- DATES --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Dates prévisionnelles</label>
            <input type="text" name="dates_previsionnelles" class="form-control"
                   value="{{ old('dates_previsionnelles', $document->dates_previsionnelles ?? '') }}">
        </div>

        {{-- MONTANTS --}}
        <div class="col-md-4 mb-3">
            <label class="form-label">Montant HT</label>
            <input type="number" step="0.01" name="montant_ht" class="form-control"
                   value="{{ old('montant_ht', $document->montant_ht ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">TVA</label>
            <input type="number" step="0.01" name="montant_tva" class="form-control"
                   value="{{ old('montant_tva', $document->montant_tva ?? '') }}">
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Montant TTC</label>
            <input type="number" step="0.01" name="montant_ttc" class="form-control"
                   value="{{ old('montant_ttc', $document->montant_ttc ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Prime CEE</label>
            <input type="number" step="0.01" name="prime_cee" class="form-control"
                   value="{{ old('prime_cee', $document->prime_cee ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Reste à charge</label>
            <input type="number" step="0.01" name="reste_a_charge" class="form-control"
                   value="{{ old('reste_a_charge', $document->reste_a_charge ?? '') }}">
        </div>

        {{-- INFORMATIONS TECHNIQUES --}}
        <div class="col-md-6 mb-3">
            <label class="form-label">Puissance chaudière</label>
            <input type="text" name="puissance_chaudiere" class="form-control"
                   value="{{ old('puissance_chaudiere', $document->puissance_chaudiere ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre de logements</label>
            <input type="number" name="nombre_logements" class="form-control"
                   value="{{ old('nombre_logements', $document->nombre_logements ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre d'émetteurs</label>
            <input type="number" name="nombre_emetteurs" class="form-control"
                   value="{{ old('nombre_emetteurs', $document->nombre_emetteurs ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Zone climatique</label>
            <input type="text" name="zone_climatique" class="form-control"
                   value="{{ old('zone_climatique', $document->zone_climatique ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Volume circuit</label>
            <input type="text" name="volume_circuit" class="form-control"
                   value="{{ old('volume_circuit', $document->volume_circuit ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre filtres</label>
            <input type="number" name="nombre_filtres" class="form-control"
                   value="{{ old('nombre_filtres', $document->nombre_filtres ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">WH Cumac</label>
            <input type="text" name="wh_cumac" class="form-control"
                   value="{{ old('wh_cumac', $document->wh_cumac ?? '') }}">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Somme</label>
            <input type="number" step="0.01" name="somme" class="form-control"
                   value="{{ old('somme', $document->somme ?? '') }}">
        </div>

    </div>
</div>