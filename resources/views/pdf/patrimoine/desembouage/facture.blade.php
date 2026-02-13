<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Facture {{ $document->reference_facture ?? '' }}</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, Arial, sans-serif;
        }
        
        body {
            font-size: 9px;
            padding: 10px;
        }
        
        .page-break {
            page-break-before: always;
            padding-top: 20px;
        }
        
        .page-number {
            text-align: center;
            margin-top: 20px;
            font-size: 8px;
            color: #666;
        }
        
        .titre-facture {
            background-color: #003366;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
            margin: 5px 0;
        }
        
        .date-facture {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .bloc-parties {
            background-color: #f5f5f5;
            padding: 15px;
            margin: 15px 0;
            overflow: hidden;
        }
        
        .parties-container {
            width: 100%;
            display: table;
        }
        
        .partie-gauche, .partie-droite {
            display: table-cell;
            vertical-align: top;
            width: 48%;
        }
        
        .separateur {
            display: table-cell;
            width: 4%;
            text-align: center;
        }
        
        .titre-section {
            font-weight: bold;
            font-size: 9px;
            margin: 8px 0 3px 0;
            color: #036;
        }
        
        .texte-normal {
            font-size: 9px;
            margin: 2px 0;
            line-height: 1.1;
        }
        
        .texte-petit {
            font-size: 8px;
            margin: 2px 0;
            line-height: 1.1;
        }
        
        .texte-gras {
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        
        th {
            background-color: #003366;
            color: white;
            padding: 8px 5px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #003366;
            font-size: 10px;
        }
        
        td {
            padding: 5px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .col-detail {
            width: 65%;
        }
        
        .col-quantite {
            width: 8%;
            text-align: center;
        }
        
        .col-pu {
            width: 9%;
            text-align: right;
        }
        
        .col-total {
            width: 9%;
            text-align: center;
        }
        
        .col-tva {
            width: 9%;
            text-align: center;
        }
        
        .liste-diamant {
            list-style-type: none;
            padding-left: 0;
            margin: 3px 0;
        }
        
        .liste-diamant li {
            margin: 2px 0;
            padding-left: 12px;
            position: relative;
        }
        
        .liste-diamant li:before {
            content: "•";
            position: absolute;
            left: 0;
            font-size: 8px;
        }
        
        .conditions-paiement {
            margin: 10px 0;
            border: 1px solid #ddd;
            padding: 8px;
            background-color: #f9f9f9;
        }
        
        .bloc-totaux {
            width: 100%;
            background-color: #f5f5f5;
            border: 2px solid #003366;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        .bloc-totaux td {
            padding: 10px;
            border: 1px solid #ccc;
        }
        
        .signature-box {
            border: 1px dashed #000;
            height: 120px;
            margin-top: 20px;
            width: 100%;
        }
        
        .align-left {
            text-align: left;
        }
        
        .align-center {
            text-align: center;
        }
        
        .align-right {
            text-align: right;
        }
        
        .espacement {
            height: 10px;
        }
        
        .image-logo {
            max-width: 200px;
            max-height: 40px;
            margin: 5px 0;
        }
    </style>
</head>
<body>

<!-- Page 1 -->
<div>
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}" alt="Logo">
    </div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>
    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Bloc gris pour bénéficiaire et société -->
    <div class="bloc-parties">
        <div class="parties-container">
            <div class="partie-gauche">
                <p class="titre-section">BENEFICIAIRE</p>
                <p class="texte-gras">{{ $document->society ?? 'RABATHERM HECS' }}</p>
                <p class="texte-normal">21 RUE D'ANJOU</p>
                <p class="texte-normal">92600 ASNIERES-SUR-SEINE</p>
                <p class="texte-normal">SIRET {{ $document->numero_immatriculation ?? '44261333700033' }}</p>
                <p class="texte-normal">contact@rabatherm-hecs.fr 01 84 80 90 08</p>
                <p class="texte-normal">Représenté par M. Offel De Villaucourt Charles</p>
                <p class="texte-normal">Gérant</p>
            </div>
            
            <div class="separateur">
                <!-- Espace vide sans bordure -->
            </div>
            
            <div class="partie-droite">
                <p class="titre-section">PATRIMOINE</p>
                <p class="texte-gras" style="color: #0A0;">PATRIMOINE</p>
                <p class="texte-normal">60 Rue FRANCOIS 1 ER</p>
                <p class="texte-normal">75008 PARIS</p>
                <p class="texte-normal">SIRET 933 487 795 00017</p>
                <p class="texte-normal">Représenté par M. TAMOYAN Hamlet, en qualité de Président 0767847049</p>
                <p class="texte-normal">direction@patrimoine.fr</p>
                <p class="texte-normal">RC Décennale ERGO contrat n° 25076156863</p>
                <p class="texte-normal">Qualification Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</p>
            </div>
        </div>
    </div>

    <!-- Descriptif -->
    <p class="titre-section">DESCRIPTIF</p>
    <p class="texte-normal">Désembouage de l'ensemble du système de distribution par boucle d'eau d'une installation de chauffage collectif alimentée par une chaudière utilisant un combustible fossile ou alimenté par un réseau de chaleur</p>
    
    <!-- Site des travaux -->
    <p class="titre-section">SITE DES TRAVAUX</p>
    <p class="texte-normal">{{ $document->adresse_travaux ?? '6, 8 All. des Tilleuls, 93110 Rosny-sous-Bois' }}</p>
    
    <!-- Informations site -->
    <p class="titre-section">Numéro immatriculation de copropriété</p>
    <p class="texte-normal">{{ $document->numero_immatriculation ?? 'AA0588830' }} - RES SONATE</p>
    
    <p class="titre-section">Zone climatique</p>
    <p class="texte-normal">{{ $document->zone_climatique ?? 'H1' }}</p>
    
    <p class="titre-section">Parcelle cadastrale</p>
    <p class="texte-normal">{{ $document->parcelle_1 ?? '1' }} {{ $document->parcelle_2 ?? 'Parcelle 2' }} {{ $document->parcelle_3 ?? '0290 Feuille 000 0T 001' }} {{ $document->parcelle_4 ?? '' }}</p>
    
    <p class="titre-section">Date prévisionnelle des travaux</p>
    <p class="texte-normal">{{ $document->dates_previsionnelles ?? 'Du 07/10/2025 au 08/10/2025' }}</p>
    
    <p class="titre-section">Contact sur site</p>
    <p class="texte-normal">Gérant M. Offel De Villaucourt Charles 01 84 80 90 08 - contact@rabatherm-hecs.fr</p>
    
    <p class="titre-section">Secteur</p>
    <p class="texte-normal">{{ $document->secteur ?? 'Résidentiel' }}</p>
    
    <p class="titre-section">Nombre de bâtiments</p>
    <p class="texte-normal">{{ $document->nombre_batiments ?? '3 Batiments' }}</p>
    
    <p class="titre-section">Détails</p>
    <p class="texte-normal">{{ $document->details_batiments ?? 'Bat A ( 47 Logs ), Bat B ( 46 Logs ), Bat C ( 46 Logs )' }}</p>

    <div class="espacement"></div>

    <!-- Objet -->
    <p class="titre-section">OBJET</p>
    <p class="texte-normal">Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie d'Energie), conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère de la Transition énergétique.</p>

    <!-- Premier tableau - Premier détail -->
    <table>
        <thead>
            <tr>
                <th class="col-detail">DETAIL</th>
                <th class="col-quantite">QUANTITE</th>
                <th class="col-pu">PU HT</th>
                <th class="col-total">TOTAL HT</th>
                <th class="col-tva">TVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-detail">
                    <p class="texte-gras">Désembouage de l'ensemble du système de distribution par boucle d'eau d'une installation de chauffage collectif alimentée par une chaudière utilisant un combustible fossile.</p>
                    <p class="texte-petit">Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie d'Energie), conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère de la Transition énergétique.</p>
                </td>
                <td class="col-quantite align-center">
                    <p class="texte-normal">1</p>
                </td>
                <td class="col-pu align-right">
                    <p class="texte-normal">{{ $document->prime_cee ?? '12 259,80' }} €</p>
                </td>
                <td class="col-total align-center">
                    <p class="texte-normal">{{ $document->prime_cee ?? '12 259,80' }} €</p>
                </td>
                <td class="col-tva align-center">
                    <p class="texte-normal">20%</p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-number">Page 1</div>
</div>

<!-- Page 2 -->
<div class="page-break">
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}" alt="Logo">
    </div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>
    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Deuxième tableau - Caractéristiques -->
    <table>
        <thead>
            <tr>
                <th class="col-detail">DETAIL</th>
                <th class="col-quantite">QUANTITE</th>
                <th class="col-pu">PU HT</th>
                <th class="col-total">TOTAL HT</th>
                <th class="col-tva">TVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-detail">
                    <p class="titre-section">CARACTÉRISTIQUES DE L'INSTALLATION</p>
                    <p class="texte-petit">INSTALLATION COLLECTIVE DE CHAUFFAGE ALIMENTÉE PAR UNE CHAUDIÈRE HORS CONDENSATION</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Puissance nominale de la chaudière : {{ $document->puissance_chaudiere ?? '670' }} kW</li>
                        <li class="texte-petit">Nombre de logements concernés : {{ $document->nombre_logements ?? '139' }}</li>
                        <li class="texte-petit">Nombre d'émetteurs désemboués : {{ $document->nombre_emetteurs ?? '487' }}</li>
                        <li class="texte-petit">Nature du réseau : Acier</li>
                        <li class="texte-petit">Volume total du circuit d'eau : {{ $document->volume_circuit ?? '5 396' }} L</li>
                        <li class="texte-petit">Zone climatique : {{ $document->zone_climatique ?? 'H1' }}</li>
                        <li class="texte-petit">Filtres : {{ $document->nombre_filtres ?? '14' }}</li>
                        <li class="texte-petit"><strong>KWH CUMAC : {{ $document->wh_cumac ?? '1 751 400' }}</strong></li>
                        <li class="texte-petit"><strong>PRIME CEE : {{ $document->prime_cee ?? '12 259,80' }} €</strong></li>
                        <li class="texte-petit">NET DE TAXE</li>
                    </ul>
                    
                    <div class="espacement"></div>
                    
                    <p class="titre-section">DÉTAIL DE LA PRESTATION</p>
                    <p class="texte-petit">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES</p>
                    
                    <p class="texte-gras">A. INJECTION D'UN RÉACTIF DÉSEMBOUANT ET CIRCULATION</p>
                    <p class="texte-petit">PREPARATION ET DIAGNOSTIC INITIAL</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Vérification de l'état général de l'installation de chauffage</li>
                        <li class="texte-petit">Contrôle de la pression et de l'étanchéité du circuit</li>
                        <li class="texte-petit">Test de fonctionnement des vannes et organes de régulation</li>
                        <li class="texte-petit">Relevé des températures et pressions de fonctionnement</li>
                        <li class="texte-petit">Injection du produit désembouant SENTINEL X800</li>
                        <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation</li>
                        <li class="texte-petit">Méthode d'injection : Via un point d'injection dédié ou par le vase d'expansion</li>
                        <li class="texte-petit">Dilution : Mélange homogène du produit dans l'ensemble du circuit</li>
                    </ul>
                    
                    <p class="texte-petit">CIRCULATION AVEC POMPE DE DESEMBOUAGE</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Équipement utilisé : Pompe de désembouage haute performance (débit minimum 30 L/min)</li>
                        <li class="texte-petit">Circulation générale :</li>
                        <ul class="liste-diamant" style="padding-left: 15px;">
                            <li class="texte-petit">Mise en circulation sur l'ensemble du réseau pendant 4 heures minimum</li>
                            <li class="texte-petit">Température de circulation : 50-60°C pour optimiser l'action du produit</li>
                        </ul>
                        <li class="texte-petit">Circulation réseau par réseau :</li>
                        <ul class="liste-diamant" style="padding-left: 15px;">
                            <li class="texte-petit">Isolation et traitement de chaque réseau de distribution individuellement</li>
                            <li class="texte-petit">Circulation dans les deux sens pour décoller tous les dépôts</li>
                            <li class="texte-petit">Durée par réseau : 2 heures minimum dans chaque sens</li>
                        </ul>
                        <li class="texte-petit">Surveillance : Contrôle visuel de la couleur de l'eau (passage du trouble au clair)</li>
                    </ul>
                </td>
                <td class="col-quantite align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-pu align-right">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-total align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-tva align-center">
                    <p class="texte-normal"></p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-number">Page 2</div>
</div>

<!-- Page 3 -->
<div class="page-break">
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}" alt="Logo">
    </div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>
    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Troisième tableau - Suite détails -->
    <table>
        <thead>
            <tr>
                <th class="col-detail">DETAIL</th>
                <th class="col-quantite">QUANTITE</th>
                <th class="col-pu">PU HT</th>
                <th class="col-total">TOTAL HT</th>
                <th class="col-tva">TVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-detail">
                    <p class="texte-gras">B. RINÇAGE DES CIRCUITS À L'EAU CLAIRE</p>
                    <p class="texte-petit">RINÇAGE GENERAL</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Évacuation complète du produit désembouant par les points de purge</li>
                        <li class="texte-petit">Remplissage progressif à l'eau claire du réseau public</li>
                        <li class="texte-petit">Circulation intensive pendant 2 heures minimum</li>
                        <li class="texte-petit">Contrôle qualité : Vérification de la limpidité de l'eau en sortie</li>
                    </ul>
                    
                    <p class="texte-petit">RINÇAGE RESEAU PAR RESEAU</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Isolation de chaque réseau de distribution</li>
                        <li class="texte-petit">Rinçage individuel :</li>
                        <ul class="liste-diamant" style="padding-left: 15px;">
                            <li class="texte-petit">Ouverture des vannes de purge des émetteurs</li>
                            <li class="texte-petit">Circulation d'eau claire jusqu'à obtention d'une eau limpide</li>
                            <li class="texte-petit">Fermeture progressive des purges en commençant par les plus éloignées</li>
                        </ul>
                        <li class="texte-petit">Volume de rinçage : Minimum 3 fois le volume de chaque réseau</li>
                        <li class="texte-petit">Contrôle final : Test d'absence de résidus et de mousse</li>
                        <li class="texte-petit">REMISE EN PRESSION</li>
                        <li class="texte-petit">Remplissage complet du circuit à la pression nominale</li>
                        <li class="texte-petit">Purge de l'air résiduel sur tous les émetteurs</li>
                        <li class="texte-petit">Vérification de l'absence de fuites</li>
                    </ul>
                    
                    <p class="texte-gras">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
                    <p class="texte-petit">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Localisation des filtres à boues existants sur les circuits de retour</li>
                        <li class="texte-petit">Démontage et nettoyage des filtres en place</li>
                        <li class="texte-petit">Contrôle d'efficacité : Vérification du maillage et de l'état général</li>
                        <li class="texte-petit">INSTALLATION DE FILTRES COMPLEMENTAIRES (SI NECESSAIRE)</li>
                        <li class="texte-petit">Positionnement : Sur chaque circuit de retour au générateur</li>
                        <li class="texte-petit">Type de filtre : Filtre magnétique séparateur de boues haute performance</li>
                        <li class="texte-petit">Raccordement : Avec vannes d'isolement pour maintenance future</li>
                        <li class="texte-petit">Accessibilité : Installation permettant un entretien facile</li>
                        <li class="texte-petit">INJECTION DU REACTIF INHIBITEUR SENTINEL X100</li>
                        <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation</li>
                        <li class="texte-petit">Méthode d'injection : Via point d'injection dédié</li>
                        <li class="texte-petit">Circulation : Mise en route de la circulation pendant 30 minutes minimum</li>
                        <li class="texte-petit">Homogénéisation : Vérification de la répartition uniforme du produit</li>
                        <li class="texte-petit">CONTROLES FINAUX ET MISE EN SERVICE</li>
                        <li class="texte-petit">Test de fonctionnement complet de l'installation</li>
                        <li class="texte-petit">Relevé des paramètres : Température, pression, débit</li>
                        <li class="texte-petit">Réglages : Ajustement des organes de régulation</li>
                        <li class="texte-petit">Formation : Explication du fonctionnement au personnel technique</li>
                        <li class="texte-petit">Documentation : Remise du certificat de désembouage et planning de maintenance</li>
                    </ul>
                </td>
                <td class="col-quantite align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-pu align-right">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-total align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-tva align-center">
                    <p class="texte-normal"></p>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="page-number">Page 3</div>
</div>

<!-- Page 4 -->
<div class="page-break">
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}" alt="Logo">
    </div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>
    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Quatrième tableau - Produits et entreprise -->
    <table>
        <thead>
            <tr>
                <th class="col-detail">DETAIL</th>
                <th class="col-quantite">QUANTITE</th>
                <th class="col-pu">PU HT</th>
                <th class="col-total">TOTAL HT</th>
                <th class="col-tva">TVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-detail">
                    <p class="titre-section">PRODUITS UTILISÉS</p>
                    
                    <p class="texte-gras">SENTINEL X800 DÉSEMBOUANT</p>
                    <p class="texte-petit">Sentinel X800 Désembouant pour nettoyage d'un réseau de chauffage, Sentinel X800 élimine tous débris, particules de corrosion et dépôts de calcaire des installations de chauffage central.</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau</li>
                        <li class="texte-petit">Aspect : Liquide clair, incolore à jaune pâle</li>
                        <li class="texte-petit">Odeur : Légère</li>
                        <li class="texte-petit">Densité (25°C) : 1,06 g/ml</li>
                        <li class="texte-petit">pH (concentré) : Environ 6,3</li>
                        <li class="texte-petit">Point de congélation : -8°C</li>
                        <li class="texte-petit">Agréé par le ministère de la Santé</li>
                    </ul>
                    
                    <p class="texte-gras">SENTINEL X100 INHIBITEUR</p>
                    <p class="texte-petit">Sentinel X100 Inhibiteur pour protection du réseau de chauffage avec solution aqueuse d'agents inhibiteurs de corrosion et anti-tartre.</p>
                    
                    <ul class="liste-diamant">
                        <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau</li>
                        <li class="texte-petit">Aspect : Liquide clair, incolore à jaune pâle</li>
                        <li class="texte-petit">Densité (20°C) : 1,10 g/ml</li>
                        <li class="texte-petit">pH (concentré) : Environ 6,4</li>
                        <li class="texte-petit">Point de congélation : -2,5°C</li>
                        <li class="texte-petit">Agréé par le ministère de la Santé</li>
                    </ul>
                    
                    <p class="titre-section">MATÉRIEL ET ENTREPRISE</p>
                    <p class="texte-petit">Matériel(s) fourni(s) et mis en place par ENERGIE NOVA, 60 RUE FRANCOIS IER, 75008 PARIS, SIRET 93348779500017, Code APE 7112B.</p>
                    <p class="texte-petit">Représentée par M. Tamoyan Hamlet, 0767847049 direction@energie-nova.com</p>
                    <p class="texte-petit">Qualification Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</p>
                    <p class="texte-petit">RC Décennale W4737408 contrat n° 25076156863</p>
                    
                    <p class="texte-gras">Durée totale de l'intervention</p>
                    <p class="texte-petit">1 à 2 jours selon la complexité</p>
                    
                    <p class="texte-gras">Garantie</p>
                    <p class="texte-petit">2 ans sur l'intervention de désembouage</p>
                    
                    <p class="texte-gras">Suivi</p>
                    <p class="texte-petit">Contrôle recommandé à 6 mois puis annuellement</p>
                </td>
                <td class="col-quantite align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-pu align-right">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-total align-center">
                    <p class="texte-normal"></p>
                </td>
                <td class="col-tva align-center">
                    <p class="texte-normal"></p>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Conditions de paiement -->
    <p class="titre-section">CONDITIONS DE PAIEMENT</p>
    <div class="conditions-paiement">
        <p class="texte-petit">Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous forme de prime, directement ou via son (ses) mandataire(s), sous réserve de l'engagement de fournir exclusivement à EBS Energie les documents nécessaires à la valorisation des opérations au titre du dispositif des Certificats d'Économies d'Energie et sous réserve de la validation de l'éligibilité du dossier par EBS ENERGIE puis par l'autorité administrative compétente.</p>
        <p class="texte-petit">Le montant de cette contribution financière, hors champ d'application de la TVA, est susceptible de varier en fonction des travaux effectivement réalisés et du volume des CEE attribués à l'opération et est estimé à {{ $document->prime_cee ?? '12 259,80' }} euros.</p>
    </div>

    <!-- Gestion des déchets -->
    <p class="titre-section">Gestion des déchets</p>
    <p class="texte-normal">Gestion, évacuation et traitements des déchets de chantier comprenant la main d'œuvre liée à la dépose et au tri, le transport des déchets de chantiers vers un ou plusieurs points de collecte et coûts de traitement.</p>

    <div class="page-number">Page 4</div>
</div>

<!-- Page 5 - Page des totaux et signature -->
<div class="page-break">
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}" alt="Logo">
    </div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>
    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Bloc des totaux bien cadré horizontalement -->
    <table class="bloc-totaux">
        <tr>
            <td><strong>TOTAL HT</strong></td>
            <td class="align-right">{{ $document->montant_ht ?? '12 259,80' }} €</td>
            <td><strong>TVA 20%</strong></td>
            <td class="align-right">{{ $document->montant_tva ?? '2 451,96' }} €</td>
        </tr>
        <tr>
            <td><strong>TOTAL TTC</strong></td>
            <td class="align-right">{{ $document->montant_ttc ?? '14 711,76' }} €</td>
            <td><strong>PRIME CEE</strong></td>
            <td class="align-right">- {{ $document->prime_cee ?? '12 259,80' }} €</td>
        </tr>
        <tr>
            <td colspan="3"><strong>RESTE À CHARGE</strong></td>
            <td class="align-right"><strong>{{ $document->reste_a_charge ?? '2 451,96' }} €</strong></td>
        </tr>
    </table>

    <div class="espacement"></div>

    <!-- Mode de paiement -->
    <p class="texte-normal"><strong>Mode de paiement :</strong> Chèques, virement ou espèce</p>

    <!-- Signature et cachet -->
    <p class="titre-section">Signature, date, cachet commercial & mention « Bon pour accord » :</p>
    <div class="signature-box"></div>
    <p class="texte-petit">Nom, prénom et fonction du signataire</p>

    <div class="page-number">Page 5</div>
</div>

</body>
</html>