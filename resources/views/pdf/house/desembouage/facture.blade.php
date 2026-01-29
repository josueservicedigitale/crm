<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Facture {{ $document->reference_facture ?? '' }}</title>
    <style>
        /* Styles optimisés pour DomPDF - exactement le même design */
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 0;
            color: black;
        }

        /* Titre avec fond vert */
        .titre-facture {
            background-color: #80A150;
            color: white;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
            margin: 5px 0;
        }

        /* Date */
        .date-facture {
            font-size: 10px;
            margin: 2px 0;
        }

        /* Titres sections */
        .titre-section {
            font-weight: bold;
            font-size: 9px;
            margin: 8px 0 3px 0;
        }

        /* Texte normal */
        .texte-normal {
            font-size: 9px;
            margin: 2px 0;
            line-height: 1.1;
        }

        /* Texte petit */
        .texte-petit {
            font-size: 8px;
            margin: 2px 0;
            line-height: 1.1;
        }

        /* Texte gras */
        .texte-gras {
            font-weight: bold;
        }

        /* Texte gras petit */
        .texte-gras-petit {
            font-weight: bold;
            font-size: 8px;
        }

        /* Tableau principal */
        .tableau-principal {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .tableau-principal th {
            background-color: #80A150;
            color: white;
            padding: 6px 4px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #80A150;
            font-size: 10px;
        }

        .tableau-principal td {
            padding: 4px;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        /* En-têtes tableau */
        .th-detail {
            font-size: 11px;
        }

        .th-quantite,
        .th-pu,
        .th-total,
        .th-tva {
            font-size: 10px;
        }

        /* Colonnes tableau */
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

        /* Listes optimisées */
        .liste-tiret {
            list-style-type: none;
            padding-left: 0;
            margin: 3px 0;
        }

        .liste-tiret li {
            margin: 2px 0;
            padding-left: 10px;
            position: relative;
        }

        .liste-tiret li:before {
            content: "- ";
            position: absolute;
            left: 0;
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
            content: "♦";
            position: absolute;
            left: 0;
            font-size: 8px;
        }

        .liste-carre {
            list-style-type: none;
            padding-left: 0;
            margin: 3px 0;
        }

        .liste-carre li {
            margin: 2px 0;
            padding-left: 12px;
            position: relative;
        }

        .liste-carre li:before {
            content: "▪";
            position: absolute;
            left: 0;
            font-size: 8px;
        }

        /* Sections */
        .section {
            margin: 8px 0;
        }

        /* Information entreprise */
        .info-entreprise {
            margin: 10px 0;
        }

        .nom-entreprise {
            font-weight: bold;
            font-size: 11px;
            margin: 5px 0;
        }

        /* Totaux */
        .section-totaux {
            text-align: right;
            margin-top: 15px;
            padding-right: 20px;
        }

        .ligne-total {
            margin: 3px 0;
        }

        .montant-total {
            display: inline-block;
            width: 100px;
            text-align: right;
        }

        .label-total {
            display: inline-block;
            width: 120px;
            text-align: left;
        }

        .reste-a-payer {
            color: #828200;
            font-weight: bold;
            font-size: 10px;
        }

        .montant-total-ttc {
            font-weight: bold;
            font-size: 11px;
        }

        /* Images optimisées */
        .image-logo {
            max-width: 246px;
            max-height: 48px;
            margin: 5px 0;
        }

        .image-grande {
            max-width: 100%;
            height: auto;
            margin: 5px 0;
        }

        /* Conditions */
        .conditions-paiement {
            margin: 10px 0;
            border: 1px solid #ddd;
            padding: 8px;
            background-color: #f9f9f9;
        }

        /* Gestion des sauts de page */
        .keep-together {
            page-break-inside: avoid;
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

        /* Espacement */
        .espacement {
            height: 10px;
        }

        /* Liens */
        .lien-mail {
            color: black;
            text-decoration: none;
        }

        /* Bloc déchets */
        .bloc-dechets {
            margin: 10px 0;
            padding: 5px;
        }
    </style>
</head>

<body>
    <!-- Logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/house/Facture_files/Image_001.jpg') }}" alt="Logo"
            onerror="this.style.display='none'">
    </div>

    <div class="espacement"></div>

    <!-- Titre Facture -->
    <div class="align-left">
        <span class="titre-facture">FACTURE {{ $document->reference_facture ?? '' }}</span>
    </div>

    <p class="date-facture">Date : {{ $document->date_facture ?? date('d/m/Y') }}</p>

    <!-- Adresse travaux -->
    <p class="titre-section">ADRESSE DES TRAVAUX :</p>
    <p class="texte-normal">{{ $document->adresse_travaux ?? 'Non spécifié' }}</p>

    <!-- Informations cadastrales -->
    <p class="titre-section">Parcelle cadastrale :
        <span class="texte-normal">{{ $document->parcelle_1 ?? '' }} {{ $document->parcelle_2 ?? '' }}
            {{ $document->parcelle_3 ?? '' }} {{ $document->parcelle_4 ?? '' }}</span>
    </p>

    <p class="titre-section">N° immatriculation :
        <span class="texte-normal">{{ $document->numero_immatriculation ?? '' }}</span>
    </p>

    <p class="titre-section">Nombre bâtiments :
        <span class="texte-normal">{{ $document->nombre_batiments ?? '' }}</span>
    </p>

    <p class="titre-section">Détails bâtiments :
        <span class="texte-normal">{{ $document->details_batiments ?? '' }}</span>
    </p>

    <p class="titre-section">Nom de résidence :
        <span class="texte-normal">{{ $document->nom_residence ?? '' }}</span>
    </p>

    <p class="titre-section">Date travaux :
        <span class="texte-normal">{{ $document->dates_previsionnelles ?? '' }}</span>
    </p>

    <div class="espacement"></div>

    <!-- Information entreprise -->
    <div class="info-entreprise">
        <p class="nom-entreprise">BBR MAINTENANCE</p>
        <p class="texte-normal">Siret : 93146162800030</p>
        <p class="texte-normal">78 AVENUE DES CHAMPS ELYSEES</p>
        <p class="texte-normal">75008 PARIS</p>
        <p class="texte-normal">Tél : 01 85 09 74 35</p>
        <p class="texte-normal">Mail : <a href="mailto:tech@bbrmaintenance.fr"
                class="lien-mail">tech@bbrmaintenance.fr</a></p>
        <p class="texte-normal">Représenté par : M.Poulin Thomas Directeur des Services Techniques</p>
    </div>

    <div class="espacement"></div>

    <!-- Tableau principal -->
    <table class="tableau-principal keep-together">
        <thead>
            <tr>
                <th class="th-detail col-detail">Détail</th>
                <th class="th-quantite col-quantite">Quantité</th>
                <th class="th-pu col-pu">P.U HT</th>
                <th class="th-total col-total">Total HT</th>
                <th class="th-tva col-tva">TVA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="col-detail">
                    <!-- Description principale -->
                    <p class="texte-petit"><strong>Désembouage de l'ensemble du système de distribution par boucle d'eau
                            d'une installation de chauffage collectif alimentée par une chaudière utilisant un
                            combustible fossile ou alimentée par un réseau de chaleur</strong></p>

                    <p class="texte-petit">Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie
                        d'Energie), conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites
                        par le ministère de la Transition énergétique.</p>

                    <p class="texte-petit">Kwh Cumac : {{ $document->wh_cumac ?? '' }}</p>
                    <p class="texte-petit">Prime CEE : {{ $document->prime_cee ?? '0.00' }} €</p>

                    <div class="espacement"></div>

                    <!-- Matériel fourni -->
                    <p class="texte-petit"><strong>Matériel(s) fourni(s) et mis en place par notre société M'Y HOUSE,
                            représentée par Amblar Jean-Christophe, SIRET 89155600300046</strong></p>

                    <p class="texte-petit">Installation collective de chauffage alimentée par <strong>une chaudière hors
                            condensation</strong></p>

                    <p class="texte-petit">Puissance nominale de la chaudière :
                        {{ $document->puissance_chaudiere ?? '' }} Kw</p>
                    <p class="texte-petit">Nombre de logements concernés : {{ $document->nombre_logements ?? '' }}</p>
                    <p class="texte-petit">Nombre d'émetteurs désemboués : {{ $document->nombre_emetteurs ?? '' }}</p>
                    <p class="texte-petit">Nature du réseau : Acier</p>
                    <p class="texte-petit">Volume total du circuit : {{ $document->volume_circuit ?? '' }} L</p>

                    <div class="espacement"></div>

                    <!-- Détail prestation -->
                    <p class="texte-gras-petit">DETAIL DE LA PRESTATION</p>
                    <p class="texte-gras-petit">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES :</p>

                    <p class="texte-gras-petit">A. INJECTION D'UN RÉACTIF DÉSEMBOUANT ET CIRCULATION</p>
                    <p class="texte-gras-petit">PREPARATION ET DIAGNOSTIC INITIAL</p>

                    <ul class="liste-diamant">
                        <li class="texte-petit">Vérification de l'état général de l'installation de chauffage</li>
                        <li class="texte-petit">Contrôle de la pression et de l'étanchéité du circuit</li>
                        <li class="texte-petit">Test de fonctionnement des vannes et organes de régulation</li>
                        <li class="texte-petit">Relevé des températures et pressions de fonctionnement</li>
                        <li class="texte-petit">Injection du produit désembouant SENTINEL X800</li>
                        <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation</li>
                        <li class="texte-petit">Méthode d'injection : Via un point d'injection dédié ou par le vase
                            d'expansion</li>
                        <li class="texte-petit">Dilution : Mélange homogène du produit dans l'ensemble du circuit</li>
                    </ul>

                    <p class="texte-gras-petit">CIRCULATION AVEC POMPE DE DESEMBOUAGE</p>

                    <ul class="liste-diamant">
                        <li class="texte-petit">Équipement utilisé : Pompe de désembouage haute performance (débit
                            minimum 30 L/min)</li>
                        <li class="texte-petit">Circulation générale :</li>
                        <ul class="liste-diamant" style="padding-left: 15px;">
                            <li class="texte-petit">Mise en circulation sur l'ensemble du réseau pendant 4 heures
                                minimum</li>
                            <li class="texte-petit">Température de circulation : 50-60°C pour optimiser l'action du
                                produit</li>
                        </ul>
                        <li class="texte-petit">Circulation réseau par réseau :</li>
                        <ul class="liste-diamant" style="padding-left: 15px;">
                            <li class="texte-petit">Isolation et traitement de chaque réseau de distribution
                                individuellement</li>
                            <li class="texte-petit">Circulation dans les deux sens pour décoller tous les dépôts</li>
                            <li class="texte-petit">Durée par réseau : 2 heures minimum dans chaque sens</li>
                        </ul>
                        <li class="texte-petit">Surveillance : Contrôle visuel de la couleur de l'eau (passage du
                            trouble au clair)</li>
                    </ul>
                </td>

                <td class="col-quantite align-center">
                    <p class="texte-normal">{{ $document->nombre_logements ?? '' }}</p>
                </td>

                <td class="col-pu align-right">
                    <p class="texte-normal">{{ $document->prime_cee ?? '0.00' }} €</p>
                </td>

                <td class="col-total align-center">
                    <p class="texte-normal">{{ $document->prime_cee ?? '0.00' }} €</p>
                </td>

                <td class="col-tva align-center">
                    <p class="texte-normal">20 %</p>
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Deuxième logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/house/Facture_files/Image_002.jpg') }}" alt="Logo"
            onerror="this.style.display='none'">
    </div>

    <div class="espacement"></div>

    <!-- Deuxième titre -->
    <div class="align-left">
        <span class="titre-facture">FACTURE M'YHOUSE-2025-{{ $document->reference_facture ?? '' }}</span>
    </div>

    <div class="espacement"></div>

    <!-- Suite des travaux -->
    <div class="section keep-together">
        <p class="texte-gras-petit">B. RINÇAGE DES CIRCUITS À L'EAU CLAIRE</p>
        <p class="texte-gras-petit">RINÇAGE GENERAL</p>

        <ul class="liste-diamant">
            <li class="texte-petit">Évacuation complète du produit désembouant par les points de purge</li>
            <li class="texte-petit">Remplissage progressif à l'eau claire du réseau public</li>
            <li class="texte-petit">Circulation intensive pendant 2 heures minimum</li>
            <li class="texte-petit">Contrôle qualité : Vérification de la limpidité de l'eau en sortie</li>
        </ul>

        <div class="espacement"></div>

        <p class="texte-gras-petit">SENTINEL X100 INHIBITEUR</p>
        <p class="texte-petit">Sentinel X100 Inhibiteur pour protection du réseau de chauffage avec solution aqueuse
            d'agents inhibiteurs de corrosion et anti-tartre.</p>

        <ul class="liste-diamant">
            <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau
            </li>
            <li class="texte-petit">Aspect : Liquide clair, incolore à jaune pâle</li>
            <li class="texte-petit">Densité (20°C) : 1,10 g/ml</li>
            <li class="texte-petit">pH (concentré) : Environ 6,4</li>
            <li class="texte-petit">Point de congélation : -2,5°C</li>
            <li class="texte-petit">Agréé par le ministère de la Santé</li>
        </ul>

        <div class="espacement"></div>

        <p class="texte-gras-petit">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
        <p class="texte-gras-petit">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>

        <ul class="liste-carre">
            <li class="texte-petit">Localisation des filtres à boues existants sur les circuits de retour</li>
            <li class="texte-petit">Démontage et nettoyage des filtres en place</li>
            <li class="texte-petit">Contrôle d'efficacité : Vérification du maillage et de l'état général</li>
        </ul>

        <p class="texte-gras-petit">INJECTION DU REACTIF INHIBITEUR SENTINEL X100</p>

        <ul class="liste-carre">
            <li class="texte-petit">Dosage : 1% du volume d'eau de l'installation</li>
            <li class="texte-petit">Méthode d'injection : Via point d'injection dédié</li>
            <li class="texte-petit">Circulation : Mise en route de la circulation pendant 30 minutes minimum</li>
            <li class="texte-petit">Homogénéisation : Vérification de la répartition uniforme du produit</li>
        </ul>

        <p class="texte-gras-petit">CONTROLES FINAUX ET MISE EN SERVICE</p>

        <ul class="liste-carre">
            <li class="texte-petit">Test de fonctionnement complet de l'installation</li>
            <li class="texte-petit">Relevé des paramètres : Température, pression, débit</li>
            <li class="texte-petit">Réglages : Ajustement des organes de régulation</li>
            <li class="texte-petit">Formation : Explication du fonctionnement au personnel technique</li>
            <li class="texte-petit">Documentation : Remise du certificat de désembouage et planning de maintenance</li>
        </ul>

        <div class="espacement"></div>

        <p class="texte-gras-petit">MATÉRIEL ET ENTREPRISE</p>
        <p class="texte-petit">Matériel(s) fourni(s) et mis en place par <strong>M'Y HOUSE</strong>, 5051 rue du Pont
            Long, 64160 Buros, SIRET 89155600300046, Code APE 4322B.</p>
        <p class="texte-petit">Représentée par <strong>M. Amblar Jean-Christophe</strong>, 05 59 60 21 51 <a
                href="mailto:contact@myhouse64.fr" class="lien-mail">contact@myhouse64.fr</a></p>

        <div class="espacement"></div>

        <p class="texte-gras-petit">Durée totale de l'intervention : <span class="texte-petit">1 à 2 jours selon la
                complexité</span></p>
        <p class="texte-gras-petit">Garantie : <span class="texte-petit">2 ans sur l'intervention de désembouage</span>
        </p>
        <p class="texte-gras-petit">Suivi : <span class="texte-petit">Contrôle recommandé à 6 mois puis
                annuellement</span></p>

        <div class="espacement"></div>

        <p class="texte-petit">Qualification <strong>Qualisav Spécialité Désembouage N° 32056 - ID N° S01946</strong>
        </p>
    </div>

    <!-- Troisième logo -->
    <div class="align-left">
        <img class="image-logo" src="{{ public_path('assets/img/house/Facture_files/Image_003.jpg') }}" alt="Logo"
            onerror="this.style.display='none'">
    </div>

    <div class="espacement"></div>

    <!-- Troisième titre -->
    <div class="align-left">
        <span class="titre-facture">FACTURE M'YHOUSE-2025-{{ $document->date_facture ?? '' }}</span>
    </div>

    <div class="espacement"></div>

    <!-- Conditions de paiement -->
    <p class="titre-section">CONDITIONS DE PAIEMENT</p>
    <div class="conditions-paiement">
        <p class="texte-petit">« Les travaux ou prestations objet du présent document donneront lieu à une contribution
            financière de EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif
            sous forme de prime, directement ou via son (ses) mandataire(s), sous réserve de l'engagement de fournir
            exclusivement à EBS Energie les documents nécessaires à la valorisation des opérations au titre du
            dispositif des Certificats d'Économies d'Énergie et sous réserve de la validation de l'éligibilité du
            dossier par EBS ENERGIE puis par l'autorité administrative compétente.</p>
        <p class="texte-petit">Le montant de cette contribution financière, hors champ d'application de la TVA, est
            susceptible de varier en fonction des travaux effectivement réalisés et du volume des CEE attribués à
            l'opération et est estimé à {{ $document->prime_cee ?? '0.00' }} euros ».</p>
    </div>

    <!-- Image gestion déchets -->
    <div class="align-left">
        <img class="image-grande" src="{{ public_path('assets/img/house/Facture_files/Image_004.png') }}"
            alt="Gestion déchets" onerror="this.style.display='none'">
    </div>

    <!-- Totaux -->
    <div class="section-totaux">
        <div class="ligne-total">
            <span class="label-total">Total H.T</span>
            <span class="montant-total">{{ $document->montant_ht ?? '0.00' }} €</span>
        </div>

        <div class="ligne-total">
            <span class="label-total">Total TVA 20%</span>
            <span class="montant-total">{{ $document->montant_tva ?? '0.00' }} €</span>
        </div>

        <div class="ligne-total">
            <span class="label-total montant-total-ttc">Total TTC</span>
            <span class="montant-total montant-total-ttc">{{ $document->montant_ttc ?? '0.00' }} €</span>
        </div>

        <div class="ligne-total">
            <span class="label-total">* Prime CEE</span>
            <span class="montant-total">- {{ $document->prime_cee ?? '0.00' }} €</span>
        </div>

        <div class="ligne-total">
            <span class="label-total reste-a-payer">Reste à payer</span>
            <span class="montant-total reste-a-payer">{{ $document->reste_a_charge ?? '0.00' }} €</span>
        </div>
    </div>

    <!-- Mode de paiement -->
    <p class="texte-normal">Mode de paiement : Chèques, virement ou espèce</p>

    <!-- Gestion des déchets -->
    <div class="bloc-dechets">
        <p class="texte-normal">Gestion, évacuation et traitements des déchets de chantier comprenant la main d'œuvre
            liée à la dépose et au tri, le transport des déchets de chantiers vers un ou plusieurs points de collecte et
            coûts de traitement.</p>
    </div>

    <!-- Titre gestion déchets -->
    <p class="titre-section">Gestion des déchets</p>
</body>

</html>