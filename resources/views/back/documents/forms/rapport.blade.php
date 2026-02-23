{{-- SECTION PARENT (ANCIEN DOCUMENT) --}}
@if(isset($parent))
    {{-- Liaison avec la facture --}}
    <input type="hidden" name="parent_id" value="{{ $parent->id }}">

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">
                <i class="fa fa-file-pdf me-2"></i>
                Rapport - Données issues de la facture
            </h5>
            <small class="text-white-50">Ces informations sont issues de la facture et servent de base</small>
        </div>

        <div class="card-body row">
            {{-- Référence facture --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Référence</label>
                <input type="text" class="form-control bg-light" readonly
                       value="{{ $parent->reference_facture ?? $parent->reference_devis ?? $parent->reference }}">
            </div>

            {{-- Nom de la résidence --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nom de la résidence</label>
                <input type="text" class="form-control bg-light" value="{{ $parent->nom_residence }}" readonly>
            </div>

            {{-- Adresse des travaux (READONLY) --}}

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adresse des travaux</label>
                <input type="text" class="form-control bg-light" 
                       value="{{ $parent->adresse_travaux }}" readonly>
            </div>

            {{-- Date de la facture (READONLY) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Date de la facture</label>
                <input type="date" class="form-control bg-light" value="{{ $parent->date_facture ?? '' }}" readonly>
            </div>

            {{-- Volume circuit (READONLY) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Volume circuit (litres)</label>
                <input type="text" class="form-control bg-light" value="{{ $parent->volume_circuit ?? '' }}" readonly>
            </div>

            {{-- Puissance chaudière (READONLY) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Puissance chaudière (kW)</label>
                <input type="text" class="form-control bg-light" value="{{ $parent->puissance_chaudiere ?? '' }}" readonly>
            </div>

            {{-- Nombre d'émetteurs (READONLY) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombre d'émetteurs</label>
                <input type="number" class="form-control bg-light" value="{{ $parent->nombre_emetteurs ?? '' }}" readonly>
            </div>

            {{-- Numéro de facture (READONLY) --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Numéro de facture</label>
                <input type="text" class="form-control bg-light" value="ENR-2025-29-F{{ $parent->reference_facture ?? $parent->id }}" readonly>
            </div>

            {{-- Montant TTC pour info --}}
            

            {{-- Informations complémentaires (readonly mais visibles) --}}
            <div class="col-12 mt-3">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle me-2"></i>
                    Les informations ci-dessus sont reprises de la facture. 
                    Veuillez compléter les informations spécifiques au rapport ci-dessous.
                </div>
            </div>
        </div>
    </div>
@endif

{{-- =========================================== --}}
{{-- SECTION PRODUITS UTILISÉS (À SAISIR) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-check-square me-2"></i>
            Produits utilisés
        </h5>
    </div>
    
    <div class="card-body">
        {{-- Pompe à désembouer - Version avec marques multiples --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Pompe à désembouer</label>
                
                {{-- Modèles spécifiques --}}
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="pompe_type" value="Pompe Jet Flush" 
                                   class="form-check-input" id="pompe1"
                                   {{ old('pompe_type', $document->pompe_type ?? '') == 'Pompe Jet Flush' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pompe1">Pompe Jet Flush</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="pompe_type" value="JetFlush Filter" 
                                   class="form-check-input" id="pompe2"
                                   {{ old('pompe_type', $document->pompe_type ?? '') == 'JetFlush Filter' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pompe2">JetFlush Filter</label>
                        </div>
                    </div>
                </div>
                
                {{-- MARQUES SUPPLÉMENTAIRES (Kiloutou, Vixax) --}}
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="pompe_type" value="Kiloutou" 
                                   class="form-check-input" id="pompe_kiloutou"
                                   {{ old('pompe_type', $document->pompe_type ?? '') == 'Kiloutou' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pompe_kiloutou">Kiloutou</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="pompe_type" value="Vixax" 
                                   class="form-check-input" id="pompe_vixax"
                                   {{ old('pompe_type', $document->pompe_type ?? '') == 'Vixax' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pompe_vixax">Vixax</label>
                        </div>
                    </div>
                </div>
                
                {{-- Autre avec champ texte --}}
                <div class="row">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-2">
                                <input type="radio" name="pompe_type" value="autre" 
                                       class="form-check-input" id="pompe_autre"
                                       {{ old('pompe_type', $document->pompe_type ?? '') == 'autre' ? 'checked' : '' }}>
                                <label class="form-check-label" for="pompe_autre">Autre :</label>
                            </div>
                            <input type="text" name="pompe_autre_texte" 
                                   class="form-control form-control-sm" 
                                   placeholder="Précisez le modèle et la marque..."
                                   value="{{ old('pompe_autre_texte', $document->pompe_autre_texte ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Réactif désembouant --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Réactif désembouant</label>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="radio" name="reactif_desembouant" value="Sentinel X400" 
                                   class="form-check-input" id="reactif1"
                                   {{ old('reactif_desembouant', $document->reactif_desembouant ?? '') == 'Sentinel X400' ? 'checked' : '' }}>
                            <label class="form-check-label" for="reactif1">Sentinel X400</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="radio" name="reactif_desembouant" value="Sentinel X800" 
                                   class="form-check-input" id="reactif2"
                                   {{ old('reactif_desembouant', $document->reactif_desembouant ?? '') == 'Sentinel X800' ? 'checked' : '' }}>
                            <label class="form-check-label" for="reactif2">Sentinel X800</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-2">
                                <input type="radio" name="reactif_desembouant" value="autre" 
                                       class="form-check-input" id="reactif_autre"
                                       {{ old('reactif_desembouant', $document->reactif_desembouant ?? '') == 'autre' ? 'checked' : '' }}>
                                <label class="form-check-label" for="reactif_autre">Autre :</label>
                            </div>
                            <input type="text" name="autre_produit_desembouant" 
                                   class="form-control form-control-sm" 
                                   placeholder="Nom du produit..."
                                   value="{{ old('autre_produit_desembouant', $document->autre_produit_desembouant ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Réactif inhibiteur --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Réactif inhibiteur</label>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="radio" name="reactif_inhibiteur" value="Sentinel X100" 
                                   class="form-check-input" id="inhibiteur1"
                                   {{ old('reactif_inhibiteur', $document->reactif_inhibiteur ?? '') == 'Sentinel X100' ? 'checked' : '' }}>
                            <label class="form-check-label" for="inhibiteur1">Sentinel X100</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-check">
                            <input type="radio" name="reactif_inhibiteur" value="Sentinel X700" 
                                   class="form-check-input" id="inhibiteur2"
                                   {{ old('reactif_inhibiteur', $document->reactif_inhibiteur ?? '') == 'Sentinel X700' ? 'checked' : '' }}>
                            <label class="form-check-label" for="inhibiteur2">Sentinel X700</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-2">
                                <input type="radio" name="reactif_inhibiteur" value="autre" 
                                       class="form-check-input" id="inhibiteur_autre"
                                       {{ old('reactif_inhibiteur', $document->reactif_inhibiteur ?? '') == 'autre' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inhibiteur_autre">Autre :</label>
                            </div>
                            <input type="text" name="autre_produit_inhibiteur" 
                                   class="form-control form-control-sm" 
                                   placeholder="Nom du produit..."
                                   value="{{ old('autre_produit_inhibiteur', $document->autre_produit_inhibiteur ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Installation filtre --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Filtre installé</label>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="filtre_type" value="Sentinel Vortex300" 
                                   class="form-check-input" id="filtre1"
                                   {{ old('filtre_type', $document->filtre_type ?? '') == 'Sentinel Vortex300' ? 'checked' : '' }}>
                            <label class="form-check-label" for="filtre1">Sentinel Vortex300</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input type="radio" name="filtre_type" value="Sentinel Vortex500" 
                                   class="form-check-input" id="filtre2"
                                   {{ old('filtre_type', $document->filtre_type ?? '') == 'Sentinel Vortex500' ? 'checked' : '' }}>
                            <label class="form-check-label" for="filtre2">Sentinel Vortex500</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="form-check me-2">
                                <input type="radio" name="filtre_type" value="autre" 
                                       class="form-check-input" id="filtre_autre"
                                       {{ old('filtre_type', $document->filtre_type ?? '') == 'autre' ? 'checked' : '' }}>
                                <label class="form-check-label" for="filtre_autre">Autre :</label>
                            </div>
                            <input type="text" name="filtre_autre_texte" 
                                   class="form-control form-control-sm" 
                                   placeholder="Précisez le modèle..."
                                   value="{{ old('filtre_autre_texte', $document->filtre_autre_texte ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION CRITÈRES DE L'INSTALLATION (À SAISIR) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="fa fa-check-circle me-2"></i>
            Critères de l'installation
        </h5>
    </div>
    
    <div class="card-body">
        <div class="row">
            {{-- Bâtiment existant --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Bâtiment existant depuis plus de 2 ans</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="batiment_existant" value="oui" 
                               class="form-check-input" id="batiment_oui"
                               {{ old('batiment_existant', $document->batiment_existant ?? '') == 'oui' ? 'checked' : '' }}>
                        <label class="form-check-label" for="batiment_oui">Oui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="batiment_existant" value="non" 
                               class="form-check-input" id="batiment_non"
                               {{ old('batiment_existant', $document->batiment_existant ?? '') == 'non' ? 'checked' : '' }}>
                        <label class="form-check-label" for="batiment_non">Non</label>
                    </div>
                </div>
            </div>

            {{-- Type de logement --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Type de logement</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="type_logement" value="maison" 
                               class="form-check-input" id="logement_maison"
                               {{ old('type_logement', $document->type_logement ?? '') == 'maison' ? 'checked' : '' }}>
                        <label class="form-check-label" for="logement_maison">Maison</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="type_logement" value="appartement" 
                               class="form-check-input" id="logement_appartement"
                               {{ old('type_logement', $document->type_logement ?? '') == 'appartement' ? 'checked' : '' }}>
                        <label class="form-check-label" for="logement_appartement">Appartement</label>
                    </div>
                </div>
            </div>

            {{-- Installation collective --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Installation collective de chauffage</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="installation_collective" value="oui" 
                               class="form-check-input" id="collective_oui"
                               {{ old('installation_collective', $document->installation_collective ?? '') == 'oui' ? 'checked' : '' }}>
                        <label class="form-check-label" for="collective_oui">Oui</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" name="installation_collective" value="non" 
                               class="form-check-input" id="collective_non"
                               {{ old('installation_collective', $document->installation_collective ?? '') == 'non' ? 'checked' : '' }}>
                        <label class="form-check-label" for="collective_non">Non</label>
                    </div>
                </div>
            </div>

            {{-- Type de générateur --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Type de générateur</label>
                <div>
                    <div class="form-check">
                        <input type="radio" name="type_generateur" value="chaudiere_hors_condensation" 
                               class="form-check-input" id="gene1"
                               {{ old('type_generateur', $document->type_generateur ?? '') == 'chaudiere_hors_condensation' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gene1">Chaudière hors condensation</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="type_generateur" value="chaudiere_condensation" 
                               class="form-check-input" id="gene2"
                               {{ old('type_generateur', $document->type_generateur ?? '') == 'chaudiere_condensation' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gene2">Chaudière à condensation</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="type_generateur" value="reseau_chaleur" 
                               class="form-check-input" id="gene3"
                               {{ old('type_generateur', $document->type_generateur ?? '') == 'reseau_chaleur' ? 'checked' : '' }}>
                        <label class="form-check-label" for="gene3">Réseau de chaleur</label>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <div class="form-check me-2">
                            <input type="radio" name="type_generateur" value="autre" 
                                   class="form-check-input" id="gene_autre"
                                   {{ old('type_generateur', $document->type_generateur ?? '') == 'autre' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gene_autre">Autre :</label>
                        </div>
                        <input type="text" name="autre_type_generateur" 
                               class="form-control form-control-sm" 
                               placeholder="Précisez..."
                               value="{{ old('autre_type_generateur', $document->autre_type_generateur ?? '') }}">
                    </div>
                </div>
            </div>

            {{-- Nature du réseau --}}
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nature du réseau</label>
                <div>
                    <div class="form-check">
                        <input type="radio" name="nature_reseau" value="cuivre" 
                               class="form-check-input" id="reseau1"
                               {{ old('nature_reseau', $document->nature_reseau ?? '') == 'cuivre' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reseau1">Cuivre</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="nature_reseau" value="acier" 
                               class="form-check-input" id="reseau2"
                               {{ old('nature_reseau', $document->nature_reseau ?? '') == 'acier' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reseau2">Acier</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="nature_reseau" value="multicouche" 
                               class="form-check-input" id="reseau3"
                               {{ old('nature_reseau', $document->nature_reseau ?? '') == 'multicouche' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reseau3">Multicouche</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="nature_reseau" value="synthese" 
                               class="form-check-input" id="reseau4"
                               {{ old('nature_reseau', $document->nature_reseau ?? '') == 'synthese' ? 'checked' : '' }}>
                        <label class="form-check-label" for="reseau4">Matériaux de synthèse</label>
                    </div>
                    <div class="d-flex align-items-center mt-2">
                        <div class="form-check me-2">
                            <input type="radio" name="nature_reseau" value="autre" 
                                   class="form-check-input" id="reseau_autre"
                                   {{ old('nature_reseau', $document->nature_reseau ?? '') == 'autre' ? 'checked' : '' }}>
                            <label class="form-check-label" for="reseau_autre">Autre :</label>
                        </div>
                        <input type="text" name="autre_nature_reseau" 
                               class="form-control form-control-sm" 
                               placeholder="Précisez..."
                               value="{{ old('autre_nature_reseau', $document->autre_nature_reseau ?? '') }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION ÉTAPES RÉALISÉES (À SAISIR) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">
            <i class="fa fa-list-ol me-2"></i>
            Étapes réalisées
        </h5>
    </div>
    
    <div class="card-body">
        @php
            $etapes = [
                'Rinçage à l’eau du système de distribution par boucle d’eau',
                'Injection d’un réactif désembouant et circulation',
                'Rinçage des circuits à l’eau claire',
                'Vérification du filtre et injection d’un réactif inhibiteur'
            ];
            $etapesRealisees = old('etapes_realisees', $document->etapes_realisees ?? [1,2,3,4]);
        @endphp
        
        @foreach($etapes as $index => $etape)
            <div class="form-check mb-2">
                <input type="checkbox" name="etapes_realisees[]" value="{{ $index + 1 }}" 
                       class="form-check-input" id="etape_{{ $index + 1 }}"
                       {{ in_array($index + 1, (array)$etapesRealisees) ? 'checked' : '' }}>
                <label class="form-check-label" for="etape_{{ $index + 1 }}">
                    {{ $etape }}
                </label>
            </div>
        @endforeach
    </div>
</div>

{{-- =========================================== --}}
{{-- SECTION IMAGES (À SAISIR) --}}
{{-- =========================================== --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">
            <i class="fa fa-image me-2"></i>
            Images et signatures
        </h5>
    </div>
    
    <div class="card-body">
        <div class="row">
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
            
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Signature</label>
                <input type="file" name="signature_image" class="form-control" accept="image/*">
                @if($document->signature_image ?? false)
                    <div class="mt-2">
                        <img src="{{ Storage::url($document->signature_image) }}" height="50">
                        <small class="text-muted ms-2">Image actuelle</small>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Logo Sentinel</label>
                <input type="file" name="sentinel_logo" class="form-control" accept="image/*">
                @if($document->sentinel_logo ?? false)
                    <div class="mt-2">
                        <img src="{{ Storage::url($document->sentinel_logo) }}" height="40">
                        <small class="text-muted ms-2">Image actuelle</small>
                    </div>
                @endif
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Icône 1</label>
                <input type="file" name="icone_1" class="form-control" accept="image/*">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Icône 2</label>
                <input type="file" name="icone_2" class="form-control" accept="image/*">
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-12">
                <label class="form-label fw-bold">Notes complémentaires</label>
                <textarea name="notes_complementaires" class="form-control" rows="3"
                          placeholder="Informations supplémentaires...">{{ old('notes_complementaires', $document->notes_complementaires ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>
