<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation de réalisation d'opération CEE</title>
    <style>
        /* Styles optimisés pour DomPDF - Même design que l'original */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 0;
            color: black;
        }

        /* Titres principaux */
        .titre-principal {
            color: #80A150;
            font-family: Verdana, sans-serif;
            font-size: 16px;
            text-align: center;
            margin: 15px 0 5px 0;
            font-weight: normal;
        }

        .sous-titre-principal {
            color: #000080;
            font-family: Verdana, sans-serif;
            font-size: 14px;
            text-align: center;
            margin: 3px 0;
            font-weight: normal;
        }

        /* Informations société */
        .info-societe {
            color: #80A150;
            font-family: Calibri, sans-serif;
            font-size: 8px;
            font-weight: bold;
            margin: 5px 0 3px 8px;
        }

        .info-adresse {
            font-family: Calibri, sans-serif;
            font-size: 8px;
            margin: 2px 0 2px 8px;
            line-height: 1.2;
        }

        /* Titre section technique */
        .titre-section-technique {
            color: #00007F;
            font-family: Verdana, sans-serif;
            font-size: 14px;
            margin: 10px 0 8px 19px;
            font-weight: normal;
        }

        /* Tableau informations */
        .tableau-infos {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            border: 1px solid #99CC99;
        }

        .cellule-label {
            width: 28%;
            padding: 4px 8px;
            border: 1px solid #99CC99;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            font-size: 8px;
            vertical-align: middle;
        }

        .cellule-valeur {
            width: 72%;
            padding: 4px 8px;
            border: 1px solid #99CC99;
            font-family: Calibri, sans-serif;
            font-size: 8px;
            vertical-align: top;
        }

        /* Note conformité */
        .note-conformite {
            font-family: Calibri, sans-serif;
            font-size: 8px;
            font-style: italic;
            margin: 3px 0 15px 5px;
            color: #555;
        }

        /* Listes numérotées */
        .liste-numerotee {
            margin: 10px 0 15px 16px;
            padding-left: 0;
            list-style-type: none;
        }

        .liste-numerotee li {
            margin: 8px 0;
            position: relative;
            padding-left: 20px;
        }

        .liste-numerotee li .numero {
            color: #099;
            font-family: Verdana, sans-serif;
            font-size: 12px;
            font-weight: normal;
            position: absolute;
            left: 0;
            top: 0;
        }

        .titre-etape {
            color: #099;
            font-family: Verdana, sans-serif;
            font-size: 12px;
            font-weight: normal;
            margin-bottom: 5px;
        }

        /* Listes à puces */
        .liste-puces {
            list-style-type: none;
            padding-left: 0;
            margin: 8px 0;
        }

        .liste-puces li {
            margin: 6px 0;
            padding-left: 18px;
            position: relative;
            font-family: Calibri, sans-serif;
            font-size: 8px;
            line-height: 1.2;
        }

        .liste-puces li:before {
            content: "•";
            position: absolute;
            left: 0;
            font-size: 10px;
        }

        /* Images */
        .image-logo {
            max-width: 68px;
            max-height: 85px;
            margin: 5px 0;
        }

        .image-logo-grand {
            max-width: 246px;
            max-height: 48px;
            margin: 5px 0;
        }

        .image-signature {
            max-width: 279px;
            max-height: 123px;
            margin: 10px 0;
        }

        /* Section certification */
        .section-certification {
            margin: 20px 0;
        }

        .titre-certification {
            color: #80A150;
            font-family: Verdana, sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 15px 0 10px 23px;
        }

        .texte-certification {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 8px 0 15px 6px;
            line-height: 1.3;
        }

        .texte-gras {
            font-weight: bold;
        }

        .texte-vert {
            color: #80A150;
            font-family: Calibri, sans-serif;
            font-weight: bold;
            font-size: 9px;
        }

        .texte-vert-fonce {
            color: #369C3B;
            font-family: Calibri, sans-serif;
            font-weight: bold;
            font-size: 9px;
        }

        /* Signature */
        .section-signature {
            margin-top: 25px;
            text-align: right;
            padding-right: 20px;
        }

        .date-signature {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin-bottom: 10px;
        }

        .nom-societe {
            font-family: Arial, sans-serif;
            font-size: 8px;
            font-weight: bold;
            margin: 5px 0;
        }

        .poste-signataire {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 3px 0;
        }

        /* Alignements */
        .align-left {
            text-align: left;
        }

        .align-center {
            text-align: center;
        }

        .align-right {
            text-align: right;
        }

        /* Espacements */
        .espacement-petit {
            height: 5px;
        }

        .espacement-moyen {
            height: 10px;
        }

        .espacement-grand {
            height: 15px;
        }

        /* Fallback pour images manquantes */
        .image-fallback {
            border: 1px solid #ddd;
            background-color: #f5f5f5;
            text-align: center;
            padding: 10px;
            color: #666;
            font-size: 8px;
        }
    </style>
</head>

<body>
    <!-- Espacement initial -->
    <div class="espacement-petit"></div>

    <!-- Titres principaux -->
    <h1 class="titre-principal">ATTESTATION DE RÉALISATION D'OPÉRATION CEE</h1>
    <p class="sous-titre-principal">FICHE BAR-SE-109</p>
    <p class="sous-titre-principal">DÉSEMBOUAGE DE SYSTÈME DE CHAUFFAGE COLLECTIF</p>

    <!-- Logos et informations -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/house/Attestation_realisation_files/Image_001.jpg') }}"
            alt="Logo 1" onerror="this.style.display='none'">
        <img class="image-logo-grand" src="{{ asset('assets/img/house/Attestation_realisation_files/Image_002.jpg') }}"
            alt="Logo 2" onerror="this.style.display='none'">
    </div>

    <!-- Informations société -->
    <p class="info-societe">{{ $document->society ?? '' }}</p>
    <p class="info-adresse">{{ $document->adresse_travaux ?? '' }}</p>
    <p class="info-adresse">{{ $document->parcelle_1 ?? '' }} {{ $document->parcelle_2 ?? '' }}
        {{ $document->parcelle_3 ?? '' }} {{ $document->parcelle_4 ?? '' }}</p>
    <p class="info-adresse">SIRET {{ $document->numero_immatriculation ?? '' }}</p>
    <p class="info-adresse">{{ $document->nom_residence ?? '' }}</p>
    <p class="info-adresse">{{ $document->details_batiments ?? '' }}</p>
    <p class="info-adresse">Chaudière hors condensation {{ $document->puissance_chaudiere ?? '' }} kW</p>
    <p class="info-adresse">{{ $document->nombre_emetteurs ?? '' }} émetteurs {{ $document->zone_climatique ?? '' }}</p>
    <p class="info-adresse">{{ $document->volume_circuit ?? '' }} L</p>
    <p class="info-adresse">{{ $document->dates_previsionnelles ?? '' }}</p>

    <!-- Titre section technique -->
    <p class="titre-section-technique">INFORMATIONS TECHNIQUES DE L'OPÉRATION</p>

    <div class="espacement-petit"></div>

    <!-- Tableau des informations techniques -->
    <table class="tableau-infos">
        <tr>
            <td class="cellule-label">Adresse du bâtiment</td>
            <td class="cellule-valeur">{{ $document->adresse_travaux ?? '' }}</td>
        </tr>
        <tr>
            <td class="cellule-label">Nature de l'opération</td>
            <td class="cellule-valeur">
                Désembouage du système de distribution par boucle d'eau d'une installation collective de chauffage
                {{ $document->nombre_logements ?? '' }} logements
            </td>
        </tr>
        <tr>
            <td class="cellule-label">Nombre de logements concernés</td>
            <td class="cellule-valeur">{{ $document->nombre_logements ?? '' }}</td>
        </tr>
        <tr>
            <td class="cellule-label">Type d'installation de chauffage</td>
            <td class="cellule-valeur">Chaudière hors condensation {{ $document->puissance_chaudiere ?? '' }} kW</td>
        </tr>
        <tr>
            <td class="cellule-label">Puissance nominale de la chaudière</td>
            <td class="cellule-valeur">{{ $document->puissance_chaudiere ?? '' }} kW</td>
        </tr>
        <tr>
            <td class="cellule-label">Nombre d'émetteurs désemboués</td>
            <td class="cellule-valeur">{{ $document->nombre_emetteurs ?? '' }} émetteurs Acier</td>
        </tr>
        <tr>
            <td class="cellule-label">Nature du réseau</td>
            <td class="cellule-valeur">Acier</td>
        </tr>
        <tr>
            <td class="cellule-label">Volume d'eau total du circuit</td>
            <td class="cellule-valeur">{{ $document->volume_circuit ?? '' }} L H1</td>
        </tr>
        <tr>
            <td class="cellule-label">Zone climatique</td>
            <td class="cellule-valeur">H1</td>
        </tr>
        <tr>
            <td class="cellule-label">Période d'exécution</td>
            <td class="cellule-valeur">{{ $document->dates_previsionnelles ?? '' }} SENTINEL X800</td>
        </tr>
        <tr>
            <td class="cellule-label">Réactif désembouant utilisé</td>
            <td class="cellule-valeur">SENTINEL X800</td>
        </tr>
        <tr>
            <td class="cellule-label">Réactif inhibiteur utilisé</td>
            <td class="cellule-valeur">SENTINEL X100 8</td>
        </tr>
        <tr>
            <td class="cellule-label">Nombre de bâtiments</td>
            <td class="cellule-valeur">{{ $document->nombre_batiments ?? '' }}</td>
        </tr>
        <tr>
            <td class="cellule-label">Nombre de logements par Bâtiments</td>
            <td class="cellule-valeur">{{ $document->details_batiments ?? '' }}</td>
        </tr>
    </table>

    <!-- Note de conformité -->
    <p class="note-conformite">(Conformément à la procédure standard BAR-SE-109 et au descriptif facture)</p>

    <div class="espacement-moyen"></div>

    <!-- Étapes de réalisation -->
    <ol class="liste-numerotee">
        <li>
            <span class="numero">1.</span>
            <div>
                <p class="titre-etape">PRÉPARATION ET INJECTION</p>
                <ul class="liste-puces">
                    <li>Diagnostic technique initial (pression, étanchéité, températures)</li>
                    <li>Injection de SENTINEL X800 (dosage : 1% du volume d'eau)</li>
                    <li>Circulation générale (4h min. à 50-60°C) et par réseau (2h/sens)</li>
                </ul>
            </div>
        </li>

        <li>
            <span class="numero">2.</span>
            <div>
                <p class="titre-etape">RINÇAGE ET CONTRÔLE</p>
                <ul class="liste-puces">
                    <li>Évacuation complète du désembouant et rinçage intensif (3x volume/réseau)</li>
                    <li>Remise en pression et purge d'air</li>
                </ul>

                <div class="espacement-petit"></div>

                <!-- Images étape 2 -->
                <div class="align-left">
                    <img class="image-logo"
                        src="{{ asset('assets/img/house/Attestation_realisation_files/Image_003.jpg') }}"
                        alt="Image étape 2-1" onerror="this.style.display='none'">
                    <img class="image-logo-grand"
                        src="{{ asset('assets/img/house/Attestation_realisation_files/Image_004.jpg') }}"
                        alt="Image étape 2-2" onerror="this.style.display='none'">
                </div>
            </div>
        </li>

        <li>
            <span class="numero">3.</span>
            <div>
                <p class="titre-etape">PROTECTION ET FINALISATION</p>
                <ul class="liste-puces">
                    <li>Vérification/nettoyage des filtres existants</li>
                    <li>Injection de SENTINEL X100 (dosage : 1% du volume d'eau)</li>
                    <li>Contrôles finaux et mise en service</li>
                </ul>
            </div>
        </li>
    </ol>

    <div class="espacement-moyen"></div>

    <!-- Section certification -->
    <div class="section-certification">
        <p class="titre-certification">CERTIFICATION</p>

        <p class="texte-certification">
            Je soussigné, <span class="texte-gras">M. Amblar Jean-Christophe</span> président de <span
                class="texte-vert">M'YHOUSE</span>, atteste que :
        </p>

        <ul class="liste-puces">
            <li>Les travaux de désembouage ont été réalisés conformément aux techniques professionnelles et aux bonnes
                pratiques du secteur.</li>
            <li>
                L'opération est conforme :
                <ul class="liste-puces" style="margin-left: 20px;">
                    <li>À la fiche CEE BAR-SE-109</li>
                    <li>Au devis référencé <span
                            class="texte-gras">M'YHOUSE-2025-{{ $document->reference_devis ?? '' }}</span> du <span
                            class="texte-gras">{{ $document->date_devis ?? '' }}</span></li>
                    <li>Aux normes techniques du ministère de la Transition énergétique.</li>
                </ul>
            </li>
            <li>Les produits utilisés (SENTINEL X800/X100) sont agréés par le ministère de la Santé.</li>
        </ul>
    </div>

    <!-- Signature -->
    <div class="section-signature">
        <p class="date-signature">
            Fait à Paris, le <span class="texte-gras">{{ $document->date_signature ?? '' }}</span>
        </p>

        <p class="nom-societe">{{ $document->society ?? '' }}</p>
        <p class="poste-signataire">Président de <span class="texte-vert-fonce">{{ $document->society ?? '' }}</span>
        </p>

        <div class="espacement-petit"></div>

        <!-- Image signature -->
        <div class="align-left" style="margin-left: 200px;">
            <img class="image-signature"
                src="{{ asset('assets/img/house/Attestation_realisation_files/Image_005.png') }}" alt="Signature"
                onerror="this.style.display='none'">
        </div>
    </div>
</body>

</html>