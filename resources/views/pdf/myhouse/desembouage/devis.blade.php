<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Devis {{ $document->reference_devis }}</title>
    <style type="text/css">
        @page {
            margin: 20mm;
        }

        body {
            margin: 0;
            font-family: Calibri, sans-serif;
            font-size: 9pt;
            line-height: 1.3;
        }

        /* Pied de page fixe sur toutes les pages */
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #333;
            text-align: center;
            border-top: 1px solid #80A150;
            padding-top: 3mm;
            width: 100%;
        }

        /* Numérotation des pages en bas à droite */
        .page-number {
            position: fixed;
            bottom: 8mm;
            right: 15mm;
            font-size: 8pt;
            color: #828200;
        }

        .page-number:after {
            content: "Page " counter(page) " / " counter(pages);
        }

        /* Réinitialisation */
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            box-sizing: border-box;
        }

        .content-container {
            padding: 6mm;
            padding-bottom: 25mm;
            /* Espace pour le pied de page */
        }

        /* Classes de texte */
        .h1 {
            color: #FFF;
            font-weight: bold;
            font-size: 14pt;
            background-color: #80A150;
            padding: 4px 10px;
            display: inline-block;
        }

        .s1 {
            color: black;
            font-size: 10pt;
        }

        .s2 {
            color: black;
            font-size: 9pt;
        }

        .s3 {
            color: black;
            font-weight: bold;
            font-size: 11pt;
        }

        .s4 {
            color: #FFF;
            font-weight: bold;
            font-size: 11pt;
        }

        .s5 {
            color: #FFF;
            font-weight: bold;
            font-size: 10pt;
        }

        .s6 {
            color: black;
            font-size: 8pt;
            line-height: 1.3;
        }

        .s7 {
            color: black;
            font-weight: bold;
            font-size: 8pt;
        }

        .s8 {
            color: black;
            font-weight: bold;
            font-size: 10pt;
        }

        .s9 {
            color: black;
            font-size: 9pt;
        }

        .s12 {
            color: black;
            font-weight: bold;
            font-size: 8pt;
        }

        .s13 {
            color: #828200;
            font-weight: bold;
            font-size: 10pt;
        }

        .s14 {
            color: #828200;
            font-weight: bold;
            font-size: 9pt;
        }

        h3 {
            color: black;
            font-weight: bold;
            font-size: 10pt;
            margin: 8px 0 4px 0;
        }

        p {
            color: black;
            font-size: 8pt;
            margin: 2px 0;
            line-height: 1.3;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 12px 0;
            table-layout: fixed;
        }

        th,
        td {
            border: 2px solid #80A150;
            padding: 5px;
            vertical-align: top;
            word-wrap: break-word;
        }

        th {
            background-color: #80A150;
            color: white;
            font-weight: bold;
        }

        /* Listes */
        .dash-list,
        .bullet-list,
        .square-list {
            list-style-type: none;
            margin: 5px 0 5px 0;
            padding-left: 10px;
        }

        .dash-list li,
        .bullet-list li,
        .square-list li {
            position: relative;
            margin-bottom: 4px;
            padding-left: 10px;
        }

        .dash-list li:before {
            content: "- ";
            position: absolute;
            left: 0;
        }

        .bullet-list li:before {
            content: "• ";
            position: absolute;
            left: 0;
        }

        .square-list li:before {
            content: "▪ ";
            position: absolute;
            left: 0;
        }

        /* Alignements */
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        /* Images */
        .logo {
            max-width: 180px;
            height: auto;
            margin-bottom: 15px;
            display: block;
        }

        /* Utilitaires */
        .mb-10 {
            margin-bottom: 10px;
        }

        .mb-15 {
            margin-bottom: 15px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-15 {
            margin-top: 15px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .bold {
            font-weight: bold;
        }

        /* Sauts de page */
        .page-start {
            page-break-before: always;
        }

        /* Section signature */
        .signature-area {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #000;
        }
    </style>
</head>

<body>
    <!-- Page 1 -->
    <div class="content-container">
        <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="Logo" class="logo">

        <div class="mb-15">
            <span class="h1">DEVIS {{ $document->reference_devis }}</span>
            <p class="s1 mt-10">Date : {{ $document->date_devis }}</p>
        </div>

        <table width="100%" style="margin-top:10px;">
            <tr>
                <td width="60%" style="vertical-align: top; padding-right:10px;">
                    <p class="s1"><b>Date :</b> {{ $document->date_devis }}</p>
                    <h4>ADRESSE DES TRAVAUX :</h4>
                    <p class="s2">{{ $document->adresse_travaux }}</p>
                    <p class="s2"><b>Parcelle cadastrale :</b>
                        {{ $document->parcelle_1 }} {{ $document->parcelle_2 }}
                        {{ $document->parcelle_3 }} {{ $document->parcelle_4 }}
                    </p>
                    <p class="s2"><b>N° immatriculation :</b> {{ $document->numero_immatriculation }}</p>
                    <p class="s2"><b>Nombre bâtiments :</b> {{ $document->nombre_batiments }}</p>
                    <p class="s2"><b>Détails bâtiments :</b> {{ $document->details_batiments }}</p>
                    <p class="s2"><b>Nom résidence :</b> {{ $document->nom_residence }}</p>
                    <p class="s2"><b>Date travaux :</b> {{ $document->dates_previsionnelles }}</p>
                </td>
                <td width="40%" style="vertical-align: top; text-align:right; border:1px solid #80A150; padding:8px;">
                    <p class="s3">BBR MAINTENANCE</p>
                    <p class="s2">Siret : 93146162800030</p>
                    <p class="s2">78 AVENUE DES CHAMPS ELYSEES</p>
                    <p class="s2">75008 PARIS</p>
                    <p class="s2">Tél : 01 85 09 74 35</p>
                    <p class="s2">Mail : tech@bbrmaintenance.fr</p>
                    <p class="s2">Représenté par : M. Poulin Thomas</p>
                    <p class="s2">Directeur des Services Techniques</p>
                </td>
            </tr>
        </table>

        <!-- Tableau principal -->
        <table style="margin-top:15px;">
            <thead>
                <tr>
                    <th style="width: 55%">
                        <p class="s4">Détail</p>
                    </th>
                    <th style="width: 8%">
                        <p class="s5">Quantité</p>
                    </th>
                    <th style="width: 12%">
                        <p class="s5 text-right">P.U HT</p>
                    </th>
                    <th style="width: 12%">
                        <p class="s5 text-center">Total HT</p>
                    </th>
                    <th style="width: 8%">
                        <p class="s5 text-center">TVA</p>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 4px;">
                        <ul class="dash-list">
                            <li>
                                <p class="s6">Désembouage de l'ensemble du système de distribution par boucle d'eau
                                    d'une installation de chauffage collectif alimentée par une chaudière utilisant un
                                    combustible fossile ou alimentée par un réseau de chaleur</p>
                                <p class="s6 mt-10">Opération entrant dans le dispositif de prime C.E.E. (Certificat
                                    d'Economie d'Energie), conforme aux recommandations de la fiche technique
                                    N°BAR-SE-109 de C.E.E décrites par le ministère de la Transition énergétique.</p>
                                <p class="s6 mt-10"><span class="bold">Kwh Cumac :</span> {{ $document->wh_cumac }}</p>
                                <p class="s6"><span class="bold">Prime CEE :</span>
                                    {{ number_format($document->prime_cee, 2, ',', ' ') }} €</p>
                            </li>
                            <li>
                                <p class="s6 mt-10"><span class="bold">Matériel(s) fourni(s) et mis en place par notre
                                        société M'Y HOUSE</span>, représentée par Amblar Jean-Christophe, SIRET <span
                                        class="bold">89155600300046</span></p>
                                <p class="s6 mt-10"><span class="bold">Installation collective de chauffage alimentée
                                        par une chaudière hors condensation</span></p>
                                <p class="s6"><span class="bold">Puissance nominale de la chaudière :</span>
                                    {{ $document->puissance_chaudiere }} Kw</p>
                                <p class="s6"><span class="bold">Nombre de logements concernés :</span>
                                    {{ $document->nombre_logements }}</p>
                                <p class="s6"><span class="bold">Nombre d'émetteurs désemboués :</span>
                                    {{ $document->nombre_emetteurs }}</p>
                                <p class="s6"><span class="bold">Nature du réseau :</span> Acier</p>
                                <p class="s6"><span class="bold">Volume total du circuit :</span>
                                    {{ $document->volume_circuit }} L</p>
                                <p class="s8 mt-15">DETAIL DE LA PRESTATION</p>
                                <p class="s7">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES :</p>
                                <p class="s7 mt-10">A. INJECTION D'UN RÉACTIF DÉSEMBOUANT ET CIRCULATION</p>
                                <p class="s6">PREPARATION ET DIAGNOSTIC INITIAL</p>
                            </li>
                        </ul>
                    </td>
                    <td class="text-center">
                        <p class="s9">{{ $document->nombre_logements }}</p>
                    </td>
                    <td class="text-right">
                        <p class="s9">{{ number_format($document->prime_cee, 2, ',', ' ') }} €</p>
                    </td>
                    <td class="text-center">
                        <p class="s9">{{ number_format($document->prime_cee, 2, ',', ' ') }} €</p>
                    </td>
                    <td class="text-center">
                        <p class="s9">20 %</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Page 2 -->
    <div class="page-start">
        <div class="content-container">
            <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="Logo" class="logo"
                style="margin: 0 auto;">

            <div class="mt-15">
                <span class="h1">DEVIS M'YHOUSE-2025-{{ $document->reference_devis }}</span>

                <p class="s7 mt-10">B. RINÇAGE DES CIRCUITS À L'EAU CLAIRE</p>
                <p class="s6">RINÇAGE GENERAL</p>

                <ul class="bullet-list">
                    <li>
                        <p class="s6">Évacuation complète du produit désembouant par les points de purge</p>
                    </li>
                    <li>
                        <p class="s6">Remplissage progressif à l'eau claire du réseau public</p>
                    </li>
                    <li>
                        <p class="s6">Circulation intensive pendant 2 heures minimum</p>
                    </li>
                    <li>
                        <p class="s6">Contrôle qualité : Vérification de la limpidité de l'eau en sortie</p>
                    </li>
                </ul>

                <p class="s7 mt-10">SENTINEL X100 INHIBITEUR</p>
                <p class="s6">Sentinel X100 Inhibiteur pour protection du réseau de chauffage avec solution aqueuse
                    d'agents inhibiteurs de corrosion et anti-tartre.</p>

                <ul class="bullet-list">
                    <li>
                        <p class="s6">Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau
                        </p>
                    </li>
                    <li>
                        <p class="s6">Aspect : Liquide clair, incolore à jaune pâle</p>
                    </li>
                    <li>
                        <p class="s6">Densité (20°C) : 1,10 g/ml</p>
                    </li>
                    <li>
                        <p class="s6">pH (concentré) : Environ 6,4</p>
                    </li>
                    <li>
                        <p class="s6">Point de congélation : -2,5°C</p>
                    </li>
                    <li>
                        <p class="s6">Agréé par le ministère de la Santé</p>
                    </li>
                </ul>

                <!-- C. VÉRIFICATION/INSTALLATION ajouté ici (déplacé depuis page 3) -->
                <div class="keep-together mt-15">
                    <span class="h1">DEVIS M'YHOUSE-2025-{{ $document->reference_devis }}</span>

                    <p class="s7 mt-10">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
                    <p class="s6">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>

                    <ul class="square-list">
                        <li>
                            <p class="s6">Localisation des filtres à boues existants sur les circuits de retour</p>
                        </li>
                        <li>
                            <p class="s6">Démontage et nettoyage des filtres en place</p>
                        </li>
                        <li>
                            <p class="s6">Contrôle d'efficacité : Vérification du maillage et de l'état général</p>
                        </li>
                    </ul>

                    <p class="s6 mt-10">INJECTION DU REACTIF INHIBITEUR SENTINEL X100</p>
                    <ul class="square-list">
                        <li>
                            <p class="s6">Dosage : 1% du volume d'eau de l'installation</p>
                        </li>
                        <li>
                            <p class="s6">Méthode d'injection : Via point d'injection dédié</p>
                        </li>
                        <li>
                            <p class="s6">Circulation : Mise en route de la circulation pendant 30 minutes minimum</p>
                        </li>
                        <li>
                            <p class="s6">Homogénéisation : Vérification de la répartition uniforme du produit</p>
                        </li>
                    </ul>

                    <p class="s6 mt-10">CONTROLES FINAUX ET MISE EN SERVICE</p>
                    <ul class="square-list">
                        <li>
                            <p class="s6">Test de fonctionnement complet de l'installation</p>
                        </li>
                        <li>
                            <p class="s6">Relevé des paramètres : Température, pression, débit</p>
                        </li>
                        <li>
                            <p class="s6">Réglages : Ajustement des organes de régulation</p>
                        </li>
                        <li>
                            <p class="s6">Formation : Explication du fonctionnement au personnel technique</p>
                        </li>
                        <li>
                            <p class="s6">Documentation : Remise du certificat de désembouage et planning de maintenance
                            </p>
                        </li>
                    </ul>

                    <p class="s8 mt-15">MATÉRIEL ET ENTREPRISE</p>
                    <p class="s6">Matériel(s) fourni(s) et mis en place par <span class="bold">M'Y HOUSE</span>, 5051
                        rue du Pont Long, 64160 Buros, SIRET <span class="bold">89155600300046</span>, Code APE 4322B.
                    </p>
                    <p class="s6">Représentée par <span class="bold">M. Amblar Jean-Christophe</span>, 05 59 60 21 51
                        contact@myhouse64.fr</p>

                    <div class="mt-10">
                        <p class="s7">Durée totale de l'intervention <span class="s6">: 1 à 2 jours selon la
                                complexité</span></p>
                        <p class="s7">Garantie <span class="s6">: 2 ans sur l'intervention de désembouage</span></p>
                        <p class="s7">Suivi <span class="s6">: Contrôle recommandé à 6 mois puis annuellement</span></p>
                    </div>

                    <p class="s6 mt-10">Qualification <span class="bold">Qualisav Spécialité Désembouage N° 32056 - ID
                            N° S01946</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Page 3 -->
    <div class="page-start">
        <div class="content-container">
            <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="Logo" class="logo"
                style="margin: 0 auto;">

            <div class="mt-15">
                <span class="h1">DEVIS M'YHOUSE-2025-{{ $document->reference_devis }}</span>

                <!-- Section C déplacée vers la page 2 -->









                <!-- Conditions de paiement -->
                <div class="mt-20">
                    <h3>CONDITIONS DE PAIEMENT</h3>
                    <p class="s2">
                        « Les travaux ou prestations objet du présent document donneront lieu à une contribution
                        financière de EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle
                        incitatif sous forme de prime, directement ou via son (ses) mandataire(s), sous réserve de
                        l'engagement de fournir exclusivement à EBS Energie les documents nécessaires à la valorisation
                        des opérations au titre du dispositif des Certificats d'Économies d'Énergie et sous réserve de
                        la validation de l'éligibilité du dossier par EBS ENERGIE puis par l'autorité administrative
                        compétente.
                    </p>
                    <p class="s2 mt-10">
                        Le montant de cette contribution financière, hors champ d'application de la TVA, est susceptible
                        de varier en fonction des travaux effectivement réalisés et du volume des CEE attribués à
                        l'opération et est estimé à {{ number_format($document->prime_cee, 2, ',', ' ') }} euros ».
                    </p>
                </div>

                <!-- Gestion des déchets avec totaux -->
                <div class="mt-20">
                    <h3>Gestion des déchets</h3>
                    <!-- Texte sur la gestion des déchets -->
                        <p class="s2" style="margin-top:15px;">
                            Gestion, évacuation et traitements des déchets de chantier comprenant la main d'œuvre liée à
                            la dépose et au tri, le transport des déchets de chantiers vers un ou plusieurs points de
                            collecte et coûts de traitement.
                        </p>
                    <div style="background:#f2f2f2; border:2px solid #80A150; padding:18px; margin-top:10px;">
                        <!-- TOTAUX -->
                        
    
                    <p class="s12">Signature, date, cachet commercial & mention « Bon pour accord » :</p>
                    <p class="s2">Nom, prénom et fonction du signataire</p>
         
                        <table style="width:260px; margin-left:auto; border-collapse:collapse;">
                            <tr>
                                <td align="right" style="padding:3px 0;">Total H.T</td>
                                <td align="right" style="padding:3px 0;">
                                    {{ number_format($document->montant_ht, 2, ',', ' ') }} €
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="padding:3px 0;">TVA 20%</td>
                                <td align="right" style="padding:3px 0;">
                                    {{ number_format($document->montant_tva, 2, ',', ' ') }} €
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="padding:6px 0 3px 0;"><b>Total TTC</b></td>
                                <td align="right" style="padding:6px 0 3px 0;">
                                    <b>{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</b>
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="padding:3px 0;">Prime CEE</td>
                                <td align="right" style="padding:3px 0;">-
                                    {{ number_format($document->prime_cee, 2, ',', ' ') }} €
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style="padding-top:6px; color:#828200;"><b>Reste à payer</b></td>
                                <td align="right" style="padding-top:6px; color:#828200;">
                                    <b>{{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</b>
                                </td>
                            </tr>
                        </table>

                        
                    </div>
                </div>

               
            </div>
        </div>
    </div>

    <!-- Pied de page commun sur toutes les pages -->
    <div class="footer">
        M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom :
        FR12891556003<br>
        Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
        <div class="page-number"></div>
    </div>
</body>

</html>