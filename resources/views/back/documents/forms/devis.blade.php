<div id="docForm" class="card shadow-sm border-0 mb-4" data-activity="{{ $activity }}">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-file-alt me-2"></i> Informations du document
        </h5>
    </div>

    <div class="card-body row g-3">

        {{-- ✅ STEP 1 : Zone climatique --}}
        <div class="col-md-6">
            <label class="form-label">Zone climatique <span class="text-danger">*</span></label>
            <select name="zone_climatique" id="zone_climatique" class="form-select">
                <option value="">-- Sélectionner une zone --</option>
                <option value="H1" {{ old('zone_climatique', $document->zone_climatique ?? '') == 'H1' ? 'selected' : '' }}>H1</option>
                <option value="H2" {{ old('zone_climatique', $document->zone_climatique ?? '') == 'H2' ? 'selected' : '' }}>H2</option>
                <option value="H3" {{ old('zone_climatique', $document->zone_climatique ?? '') == 'H3' ? 'selected' : '' }}>H3</option>
            </select>
            <small class="text-muted">Choisis d’abord la zone pour débloquer la suite.</small>
        </div>

        {{-- ✅ STEP 2 : Nombre logements --}}
        <div class="col-md-6" id="step_logements" style="display:none;">
            <label class="form-label">Nombre de logements <span class="text-danger">*</span></label>
            <input type="number" min="1" name="nombre_logements" id="nombre_logements" class="form-control"
                value="{{ old('nombre_logements', $document->nombre_logements ?? '') }}">
            <small class="text-muted">Après ça, les montants se calculent automatiquement.</small>
        </div>

        {{-- ✅ STEP 3 : Champs calculés (readonly) --}}
        <div id="step_calculs" class="row g-3" style="display:none;">
            <div class="col-md-6">
                <label class="form-label">WH Cumac (auto)</label>
                <input type="number" name="wh_cumac" id="wh_cumac" class="form-control bg-light" readonly
                    value="{{ old('wh_cumac', $document->wh_cumac ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Prime CEE (auto)</label>
                <input type="number" step="0.01" name="prime_cee" id="prime_cee" class="form-control bg-light" readonly
                    value="{{ old('prime_cee', $document->prime_cee ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Montant HT (auto)</label>
                <input type="number" step="0.01" name="montant_ht" id="montant_ht" class="form-control bg-light"
                    readonly value="{{ old('montant_ht', $document->montant_ht ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">TVA (auto)</label>
                <input type="number" step="0.01" name="montant_tva" id="montant_tva" class="form-control bg-light"
                    readonly value="{{ old('montant_tva', $document->montant_tva ?? '') }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">Montant TTC (auto)</label>
                <input type="number" step="0.01" name="montant_ttc" id="montant_ttc" class="form-control bg-light"
                    readonly value="{{ old('montant_ttc', $document->montant_ttc ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Reste à charge (auto)</label>
                <input type="number" step="0.01" name="reste_a_charge" id="reste_a_charge" class="form-control bg-light"
                    readonly value="{{ old('reste_a_charge', $document->reste_a_charge ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Somme (auto)</label>
                <input type="number" step="0.01" name="somme" id="somme" class="form-control bg-light" readonly
                    value="{{ old('somme', $document->somme ?? '') }}">
            </div>
        </div>

        {{-- ✅ RESTE DU FORMULAIRE : affiché après calculs --}}
        <div id="step_reste" class="row g-3" style="display:none;">
            <hr class="my-3">

            <div class="col-md-6">
                <label class="form-label">Référence devis</label>
                <input type="text" name="reference_devis" class="form-control"
                    value="{{ old('reference_devis', $document->reference_devis ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Date du devis</label>
                <input type="date" name="date_devis" class="form-control"
                    value="{{ old('date_devis', $document->date_devis ?? '') }}">
            </div>

            <div class="col-md-6">
                <label class="form-label">Adresse des travaux</label>
                <input type="text" name="adresse_travaux" class="form-control"
                    value="{{ old('adresse_travaux', $document->adresse_travaux ?? '') }}">
            </div>

            <div class="col-md-6">
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
                <input type="number" name="nombre_batiments" id="nombre_batiments" class="form-control"
                    value="{{ old('nombre_batiments', $document->nombre_batiments ?? '') }}">

            </div>

            <div class="col-md-12 mb-2">
                <label class="form-label">Detail du bâtiment</label>
                <textarea name="details_batiments" id="details_batiments" rows="3"
                    class="form-control">{{ old('details_batiments', $document->details_batiments ?? '') }}</textarea>
                <small class="text-muted">Auto-généré selon bâtiments & logements (modifiable).</small>
                <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="regen_details">
                    Regénérer automatiquement
                </button>
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
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre d'émetteurs</label>
                <input type="number" name="nombre_emetteurs" class="form-control"
                    value="{{ old('nombre_emetteurs', $document->nombre_emetteurs ?? '') }}">
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
            {{-- ... garde ici tous tes autres champs (bâtiment, parcelles, etc.) --}}
        </div>

    </div>
</div>

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const root = document.getElementById('docForm');
            if (!root) return;

            const activity = (root.dataset.activity || '').toLowerCase(); // desembouage | reequilibrage
            const zoneEl = document.getElementById('zone_climatique');
            const logEl = document.getElementById('nombre_logements');

            const stepLogements = document.getElementById('step_logements');
            const stepCalculs = document.getElementById('step_calculs');
            const stepReste = document.getElementById('step_reste');

            const whCumacEl = document.getElementById('wh_cumac');
            const primeEl = document.getElementById('prime_cee');
            const htEl = document.getElementById('montant_ht');
            const tvaEl = document.getElementById('montant_tva');
            const ttcEl = document.getElementById('montant_ttc');
            const racEl = document.getElementById('reste_a_charge');
            const sommeEl = document.getElementById('somme');

            function getCumac(act, zone) {
                // desembouage
                const desembouage = { H1: 12600, H2: 12100, H3: 8900 };
                // reequilibrage
                const reequilibrage = { H1: 9800, H2: 8000, H3: 5300 };

                if (act === 'reequilibrage') return reequilibrage[zone] ?? null;
                return desembouage[zone] ?? null;
            }

            function getTvaRate(act) {
                // 20% pour desembouage, 5.5% pour reequilibrage
                return act === 'reequilibrage' ? 0.055 : 0.20;
            }

            function round2(n) {
                return Math.round((n + Number.EPSILON) * 100) / 100;
            }

            function show(el, ok) {
                el.style.display = ok ? '' : 'none';
            }

            function compute() {
                const zone = zoneEl.value;
                const logements = parseInt(logEl.value || '0', 10);

                // step reveal
                show(stepLogements, !!zone);

                if (!zone || !logements || logements < 1) {
                    show(stepCalculs, false);
                    show(stepReste, false);
                    return;
                }

                const cumac = getCumac(activity, zone);
                if (!cumac) return;

                const prime = logements * cumac * 0.007;
                const tvaRate = getTvaRate(activity);
                const tva = prime * tvaRate;
                const ttc = prime + tva;

                whCumacEl.value = cumac;
                primeEl.value = round2(prime);
                htEl.value = round2(prime);
                sommeEl.value = round2(prime);
                racEl.value = round2(prime);
                tvaEl.value = round2(tva);
                ttcEl.value = round2(ttc);

                show(stepCalculs, true);
                show(stepReste, true);
            }

            zoneEl.addEventListener('change', compute);
            logEl.addEventListener('input', compute);

            // ✅ Si on est en edit et que des valeurs existent déjà, on affiche tout
            // (utile pour modifier un document existant)
            if (zoneEl.value) show(stepLogements, true);
            compute();

            // ✅ champs bâtiment
            const batEl = document.getElementById('nombre_batiments');
            const detailsEl = document.getElementById('details_batiments');

            let detailsTouched = false;

            function letters(i) {
                // 0 -> A, 1 -> B...
                return String.fromCharCode(65 + i);
            }

            function buildBatimentsDetails(nbBat, nbLogs) {
                nbBat = parseInt(nbBat || '0', 10);
                nbLogs = parseInt(nbLogs || '0', 10);
                if (!nbBat || nbBat < 1 || !nbLogs || nbLogs < 1) return '';

                if (nbBat === 1) {
                    return `Bat (${nbLogs} Logs)`;
                }

                const base = Math.floor(nbLogs / nbBat);
                const rest = nbLogs % nbBat;

                const parts = [];
                for (let i = 0; i < nbBat; i++) {
                    const logsForThis = base + (i < rest ? 1 : 0); // on donne le reste aux premiers (A, B, C...)
                    parts.push(`Bat ${letters(i)} (${logsForThis} Logs)`);
                }
                return parts.join(', ');
            }

            function computeBatimentsDetails() {
                if (!batEl || !detailsEl) return;

                // si l'utilisateur a touché manuellement, on n'écrase pas
                if (detailsTouched) return;

                const txt = buildBatimentsDetails(batEl.value, logEl?.value);
                if (txt) detailsEl.value = txt;
            }

            // ✅ si l'utilisateur tape lui-même dans details, on stop l'auto
            if (detailsEl) {
                detailsEl.addEventListener('input', () => {
                    detailsTouched = true;
                });
            }

            // ✅ si nb batiments ou nb logements change => auto update
            if (batEl) batEl.addEventListener('input', computeBatimentsDetails);
            if (logEl) logEl.addEventListener('input', computeBatimentsDetails);

            // ✅ au chargement (edit)
            // si details existe déjà en DB, on considère que c’est “manuel”
            if (detailsEl && (detailsEl.value || '').trim().length > 0) {
                detailsTouched = true;
            } else {
                computeBatimentsDetails();
            }

            // ⚠️ IMPORTANT :
            // quand tu calcules tes steps (compute()), appelle aussi computeBatimentsDetails()
            const oldCompute = compute;
            compute = function () {
                oldCompute();
                computeBatimentsDetails();
            };
            const regenBtn = document.getElementById('regen_details');
            if (regenBtn && detailsEl) {
                regenBtn.addEventListener('click', () => {
                    detailsTouched = false;
                    computeBatimentsDetails();
                });
            }

        });
    </script>
@endpush