<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de réalisation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            margin: 20px;
        }
        h1, h2 {
            text-align: center;
            margin: 8px 0;
        }
        h1 {
            color: #6C6;
            font-size: 16pt;
        }
        h2 {
            color: #00007F;
            font-size: 12pt;
        }
        h3 {
            color: #036;
            font-size: 10pt;
            text-align: left;
            margin-top: 15px;
        }
        p { margin: 4px 0; }
        table {
            border-collapse: collapse;
            width: 100%;
            margin: 10px 0;
        }
        td {
            border: 1px solid #000;
            padding: 4px;
            vertical-align: top;
        }
        ul { margin: 0; padding-left: 15pt; }
        li { margin-bottom: 4pt; }

        /* Bandeau logos */
        .header-logos {
            width: 100%;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            margin-bottom: 15px;
        }
        .header-logos img {
            height: 50px; /* taille réduite */
            width: auto;
        }
        .header-logos img:last-child {
            margin-left: auto;
        }

        /* Encadré titre */
        .title-box {
            border: 1px solid #ccc; /* bordure légère */
            padding: 10px;
            margin: 10px auto;
            display: inline-block;
        }

        /* Signature */
        .signature {
            width: 100px;
            height: auto;
            margin-top: 10px;
        }

        /* Saut de page */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

<!-- Logos - Page 1 -->
<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:15px;">
    <tr>
        <td width="50%" align="left" style="border:none; padding:0;">
            <img src="file://{{ public_path('assets/img/nova/attestation_realisation_files/logo1.png') }}" height="50">
        </td>
        <td width="50%" align="right" style="border:none; padding:0;">
            <img src="file://{{ public_path('assets/img/nova/attestation_realisation_files/logo2.png') }}" height="50">
        </td>
    </tr>
</table>

<!-- Titre principal -->
<h1>ATTESTATION DE RÉALISATION D'OPÉRATION CEE</h1>
<h2>Fiche BAR-SE-109</h2>
<h2>Désembouage de système de chauffage collectif</h2>

<!-- Société - STATIQUE -->
<h3>Entreprise</h3>
<p><b>ENERGIE NOVA</b></p>
<p>60 Rue François 1er, 75008 PARIS</p>
<p>SIRET : 933 487 795 00017</p>
<p>Représenté par M. TAMOYAN Hamlet, Président</p>
<p>Tél : 0767847049 – Email : direction@energie-nova.com</p>
<p>RC Décennale ERGO contrat n° 25076156863</p>
<p>Qualification Qualisav Spécialité Désembouage N° 31376 – ID N° S01810</p>

<!-- Bénéficiaire - STATIQUE -->
<h3>Bénéficiaire</h3>
<p><b>RABATHERM HECS</b></p>
<p>21 Rue d'Anjou, 92600 Asnières-sur-Seine</p>
<p>SIRET : 44261333700033</p>
<p>Email : contact@rabatherm-hecs.fr – Tél : 01 84 80 90 08</p>
<p>Représenté par M. Offel De Villaucourt Charles, Gérant</p>

<!-- Informations techniques - DYNAMIQUE -->
<h3>1. Informations techniques de l'opération</h3>
<table>
    <tr>
        <td>Adresse du bâtiment</td>
        <td>
            {{ $document->adresse_travaux ?? '' }}

        <</td>
    </tr>
    <tr>
        <td>Nom de la residence</td>
        <td> {{ $document->nom_residence ?? '' }}</td>
    </tr>
    <tr>
        <td>Numero immatriculation</td>
        <td>{{ $document->numero_immatriculation ?? '' }}</td>
    </tr>
    <tr>
        <td>Parcelles cadastrales</td>
        <td>
            @php
                $parcelles = [];
                if(!empty($document->parcelle_1)) $parcelles[] = $document->parcelle_1;
                if(!empty($document->parcelle_2)) $parcelles[] = $document->parcelle_2;
                if(!empty($document->parcelle_3)) $parcelles[] = $document->parcelle_3;
                if(!empty($document->parcelle_4)) $parcelles[] = $document->parcelle_4;
            @endphp
            
            @if(count($parcelles) > 0)
                {{ implode(', ', $parcelles) }}
            @else
                Non spécifié
            @endif
        </td>
    </tr>
    <tr>
        <td>Nature de l'opération</td>
        <td>{{ $document->activity ?? 'Désembouage de système de chauffage collectif' }}</td>
    </tr>
    <tr>
        <td>Nombre de logements concernés</td>
        <td>{{ $document->nombre_logements ?? '' }} logements</td>
    </tr>
    <tr><td>Zone hydrolique</td><td>{{ $document->zone_hydrolique ?? 'null' }}</td></tr>
    <tr>
        <td>Puissance chaudière</td>
        <td>
            {{ $document->puissance_chaudiere ?? 'Chaudière hors condensation' }} kW
        </td>
    </tr>
    <tr>
        <td>Nombre d'émetteurs désemboués</td>
        <td>{{ $document->nombre_emetteurs ?? '' }} émetteurs</td>
    </tr>
    <tr>
        <td>Volume d'eau total</td>
        <td>
            {{ $document->volume_circuit ?? '' }} L
            @if(!empty($document->zone_climatique))
                {{ $document->zone_climatique }}
            @endif
        </td>
    </tr>
    <tr>
        <td>Période d'exécution</td>
        <td>{{ $document->dates_previsionnelles ?? '' }}</td>
    </tr>
    <tr>
        <td>Nombre de bâtiments</td>
        <td> {{$document->nombre_batiments ?? '' }} bâtiments </td>
    </tr>
    <tr><td>Details batiments</td><td>{{ $document->details_batiments ?? '' }}</td></tr>
    <tr>
        <td>Nombre de filtres</td>
        <td>{{ $document->nombre_filtres ?? '' }}</td>
    </tr>
</table>

<!-- Saut de page -->
<div class="page-break"></div>

<!-- Logos - Page 2 -->
<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:15px;">
    <tr>
        <td width="50%" align="left" style="border:none; padding:0;">
            <img src="file://{{ public_path('assets/img/nova/attestation_realisation_files/logo1.png') }}" height="50">
        </td>
        <td width="50%" align="right" style="border:none; padding:0;">
            <img src="file://{{ public_path('assets/img/nova/attestation_realisation_files/logo2.png') }}" height="50">
        </td>
    </tr>
</table>

<!-- Étapes - Semi-statique avec données dynamiques -->
<h3>2. Étapes de l'opération réalisée</h3>
<ul>
    <li><b>Préparation et Injection :</b> Diagnostic technique, injection de SENTINEL X800 (1% du volume d'eau), circulation générale.</li>
    <li><b>Rinçage et Contrôle :</b> Évacuation complète, rinçage intensif (3x volume/réseau), remise en pression et purge d'air.</li>
    <li><b>Protection et Finalisation :</b> 
        @if(!empty($document->nombre_filtres))
            Nettoyage de {{ $document->nombre_filtres }} filtres,
        @else
            Nettoyage filtres,
        @endif
        injection de SENTINEL X100 (1% du volume d'eau), contrôles finaux et mise en service.</li>
</ul>

<!-- Certification - DYNAMIQUE -->
<h3 style="color:#6C6;">3. Certification</h3>
<p>Je soussigné, M. TAMOYAN Hamlet, Président de ENERGIE NOVA, atteste que :</p>
<ul>
    <li>Les travaux de désembouage ont été réalisés conformément aux techniques professionnelles et aux bonnes pratiques du secteur.</li>
    <li>L'opération est conforme à la fiche CEE BAR-SE-109, au devis 
        <strong>
            @if(!empty($document->reference_devis))
                {{ $document->reference_devis }} 
            @endif
            @if(!empty($document->date_devis))
                du {{ $document->date_devis }}
            @endif
        </strong>, 
        et aux normes techniques du ministère de la Transition énergétique.
    </li>
    <li>Les produits utilisés (SENTINEL X800/X100) sont agréés par le ministère de la Santé.</li>
    @if(!empty($document->montant_ht) || !empty($document->montant_ttc))
        <li>Montants financiers : 
            @if(!empty($document->montant_ht))
                HT: {{ $document->montant_ht }} €
            @endif
            @if(!empty($document->montant_ttc))
                - TTC: {{ $document->montant_ttc }} €
            @endif
        </li>
    @endif
    @if(!empty($document->wh_cumac))
        <li>Wh cumac : {{ $document->wh_cumac }}</li>
    @endif
    @if(!empty($document->prime_cee))
        <li>Prime CEE : {{ $document->prime_cee }} €</li>
    @endif
    @if(!empty($document->reste_a_charge))
        <li>Reste à charge : {{ $document->reste_a_charge }} €</li>
    @endif
    @if(!empty($document->somme))
        <li>Somme totale : {{ $document->somme }} €</li>
    @endif
</ul>

<!-- Signature - DYNAMIQUE -->
<div style="text-align:right; margin-top:30px;">
    <p>Fait à Paris, le {{ $document->date_signature ?? date('d/m/Y') }}</p>
    <p><b>M. TAMOYAN Hamlet</b><br/>Président de ENERGIE NOVA</p>
    
    <!-- Signature dynamique -->
    @if(!empty($document->file_path))
        <img src="{{ $document->file_path }}" height="100" alt="Signature">
    @else
        <!-- Signature par défaut -->
        <img src="{{ public_path('assets/img/nova/attestation_realisation_files/Image_012.png') }}" height="100">
    @endif
</div>

</body>
</html>