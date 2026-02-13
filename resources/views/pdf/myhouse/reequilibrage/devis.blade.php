<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Devis {{ $document->reference_devis }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #000;
        }

        h1 {
            font-size: 14pt;
            color: #FFF;
            background-color: #81A150;
            padding: 4px;
        }

        h2 {
            font-size: 11pt;
            color: #FFF;
            background-color: #81A150;
            padding: 4px;
        }

        h3 {
            font-size: 10pt;
            margin-top: 10px;
        }

        h4 {
            font-size: 9pt;
            margin-top: 5px;
        }

        p {
            margin: 2px 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background-color: #81A150;
            color: #000;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .card {
            border: 1px solid #ccc;
            background-color: #f5f5f5;
            padding: 10px;
            margin-top: 15px;
        }

        .totaux {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #f0f0f0;
            color: #000;
        }

        .signature-box {
            border: 1px dashed #000;
            height: 150px;
            /* plus grand pour signer */
            margin-top: 20px;
            padding: 10px;
        }

        .totaux div {
            flex: 1;
            margin: 5px;
        }

        .signature-box {
            border: 1px dashed #000;
            height: 120px;
            margin-top: 20px;
            padding: 10px;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <!-- Logo -->
    <p><img src="{{ public_path('assets/img/rehouse/Devis_files/Image_001.jpg') }}" width="200" alt="Logo"></p>

    <!-- En-tête -->
    <h1>DEVIS {{ $document->reference_devis }}</h1>
    <p>Date : {{ $document->date_devis }}</p>

    <!-- Adresse travaux -->
    <h4>Adresse des travaux :</h4>
    <p>{{ $document->adresse_travaux }}</p>
    <p>Parcelle cadastrale : {{ $document->parcelle_1 }}</p>
    <p>N° immatriculation : {{ $document->numero_immatriculation }}</p>
    <p>Nombre bâtiments : {{ $document->nombre_batiments }}</p>
    <p>Détails bâtiments : {{ $document->details_batiments }}</p>
    <p>Nom de résidence : {{ $document->nom_residence }}</p>
    <p>Date travaux : {{ $document->dates_previsionnelles }}</p>
    <p>Date de désembouage : Du 16/10/2025 au 17/10/2025</p>

    <!-- Société -->
    <p><strong>BBR MAINTENANCE</strong></p>
    <p>Siret : 93146162800030</p>
    <p>78 Avenue des Champs Élysées, 75008 Paris</p>
    <p>Tél : 01 85 09 74 35</p>
    <p>Mail : tech@bbrmaintenance.fr</p>
    <p>Représenté par : M. Poulin Thomas</p>

    <!-- Tableau prestations -->
    <table>
        <tr>
            <th>Détail</th>
            <th>Quantité</th>
            <th>P.U HT</th>
            <th>Total HT</th>
            <th>TVA</th>
        </tr>
        <tr>
            <td>
                Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude.<br>
                Kwh Cumac : <b>{{ $document->wh_cumac }}</b><br>
                Prime CEE : <b>{{ $document->prime_cee }}</b> €<br>
                Installation : <b>{{ $document->type }}</b><br>
                Puissance chaudière : {{ $document->puissance_chaudiere }} Kw<br>
                Logements concernés : <b>{{ $document->nombre_logements }}</b><br>
                <b>Détail de la prestation :</b>
                <ol>
                    <li>Réglage des organes d’équilibrage</li>
                    <li>Mise en place matériel d’équilibrage</li>
                </ol>
                <b>Compris dans les travaux :</b>
                <ul>
                    <li>Dépose et enlèvement ancien appareil</li>
                    <li>Protection et nettoyage chantier</li>
                    <li>Remplissage et purge installation</li>
                </ul>
            </td>
            <td class="center">1</td>
            <td class="right">{{ $document->montant_ht }} €</td>
            <td class="right">{{ $document->montant_ht }} €</td>
            <td>5,5 %</td>
        </tr>
    </table>


    <!-- Nouvelle page -->
    <div class="page-break"></div>

    <!-- Logo -->
    <p><img src="{{ public_path('assets/img/rehouse/Devis_files/Image_001.jpg') }}" width="200" alt="Logo"></p>

    <!-- En-tête -->
    <h1>DEVIS {{ $document->reference_devis }}</h1>
    <p>Date : {{ $document->date_devis }}</p>

    <!-- Conditions -->
    <h3>Conditions de paiement</h3>
    <p>« Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de EBS
        ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous forme de prime,
        directement ou via son (ses) mandataire(s), sous réserve de l’engagement de fournir exclusivement à EBS Energie
        les documents nécessaires à la valorisation des opérations au titre du dispositif des Certificats d’Économies
        d’Énergie et sous réserve de la validation de l’éligibilité du dossier par EBS ENERGIE puis par l’autorité
        administrative compétente.
        Le montant de cette contribution financière, hors champ d’application de la TVA, est susceptible de varier en
        fonction des travaux effectivement réalisés et du volume des CEE attribués à l’opération et est estimé à
        7 614,60 euros ».</p>

    <!-- Bloc Totaux en tableau -->
    <h3>Totaux</h3>
    <table>
        <tr>
            <th>Total H.T</th>
            <td>{{ $document->montant_ht }} €</td>
        </tr>
        <tr>
            <th>Total TVA 5,5%</th>
            <td>{{ $document->montant_tva }} €</td>
        </tr>
        <tr>
            <th>Total TTC</th>
            <td>{{ $document->montant_ttc }} €</td>
        </tr>
        <tr>
            <th>Prime CEE</th>
            <td>{{ $document->prime_cee }} €</td>
        </tr>
        <tr>
            <th>Reste à payer</th>
            <td><strong>{{ $document->reste_a_charge }} €</strong></td>
        </tr>
    </table>
    <p>Mode de paiement : Chèques, virement ou espèce</p> <!-- Gestion des déchets -->
    <h3>Gestion des déchets</h3>
    <p>Gestion, évacuation et traitements des déchets de chantier comprenant la main d’œuvre liée à la dépose et au tri,
        le transport des déchets vers un ou plusieurs points de collecte et coûts de traitement.</p>
    <p><img src="{{ public_path('assets/img/rehouse/Devis_files/Image_003.png') }}" width="500" alt="Gestion déchets">
    </p> <!-- Signature -->
    <h3>Signature</h3>
    <p><b>Signature, date, cachet commercial & mention « Bon pour accord » :</b></p>
    <div class="signature-box">
        <p>Nom, prénom et fonction du signataire :</p>
    </div>
</body>

</html>