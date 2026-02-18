<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Devis - MY HOUSE</title>

    <style>
        /* =========================
       DOMPDF SAFE SETTINGS
    ========================== */
        @page {
            margin: 18mm 14mm;
        }

        /* page = feuille PDF */
        .page {
            page-break-after: always;
        }

        /* ZONE SÛRE (marges internes réelles) */
        .content {
            padding: 6mm 6mm 8mm 6mm;
            /* marge interne en plus du @page */
        }

        /* IMPORTANT: tout ce qui est “plein écran” doit rester dans la zone */
        table,
        img,
        .footer-line {
            width: 100%;
            max-width: 100%;
        }

        /* évite que les bordures/paddings fassent dépasser */
        .main-table,
        .strip,
        .devis-bar,
        .infos {
            box-sizing: border-box;
        }


        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 9pt;
            color: #000;
        }

        /* une page PDF */
        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        /* évite les débordements horizontaux */
        img,
        table {
            max-width: 100%;
        }

        td,
        th,
        p,
        li,
        div {
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        /* =========================
       COLORS (comme capture)
    ========================== */
        :root {
            --green: #7aa84a;
            /* bande verte */
            --green-dark: #6e9b43;
            --border: #2b2b2b;
            /* traits tableau */
            --gray: #e9e9e9;
            /* bloc bas page 2 */
        }

        /* =========================
       HEADER (logo + barre devis)
    ========================== */
        .header {
            margin-bottom: 6mm;
        }

        .header-top {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-top td {
            vertical-align: top;
            border: none;
        }

        .logo-wrap {
            width: 55%;
        }

        .logo-wrap img {
            height: 16mm;
            width: auto;
        }

        .devis-bar {
            margin-top: 2mm;
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .devis-bar td {
            border: none;
            padding: 2mm 3mm;
            background: var(--green);
            background-color: #80A150
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .2px;
        }

        /* =========================
       INFOS (adresse / société)
    ========================== */
        .infos {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 6mm;
        }

        .infos td {
            border: none;
            vertical-align: top;
            padding: 0;
            font-size: 8.5pt;
            line-height: 1.25;
        }

        .infos .left {
            width: 58%;
            padding-right: 6mm;
        }

        .infos .right {
            width: 42%;
        }

        .muted {
            color: #222;
        }

        .b {
            font-weight: bold;
        }

        .mt2 {
            margin-top: 2mm;
        }

        .mt3 {
            margin-top: 3mm;
        }

        .mt4 {
            margin-top: 4mm;
        }

        /* =========================
       MAIN TABLE (page 1)
    ========================== */
        .main-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            border: 1px solid var(--border);
        }

        .main-table th,
        .main-table td {
            border-left: 1px solid var(--border);
            border-right: 1px solid var(--border);
            vertical-align: top;
            padding: 4mm 3mm;
        }

        .main-table thead th {
            background: var(--green);
            color: #fff;
            font-weight: bold;
            text-align: left;
            padding: 2.6mm 3mm;
        }

        /* largeurs colonnes (comme capture) */
        .col-detail {
            width: 63%;
        }

        .col-qte {
            width: 9%;
            text-align: center;
        }

        .col-pu {
            width: 10%;
            text-align: center;
        }

        .col-total {
            width: 10%;
            text-align: center;
        }

        .col-tva {
            width: 8%;
            text-align: center;
        }

        .detail p {
            margin: 0 0 2mm 0;
        }

        .detail .title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 2mm;
        }

        .detail ul {
            margin: 2mm 0 2mm 5mm;
            padding-left: 4mm;
        }

        .detail li {
            margin: 0 0 1mm 0;
        }

        /* Page 1 : numéros alignés verticalement au bon endroit */
        .numbers {
            font-size: 8.5pt;
            line-height: 1.35;
            text-align: right;
            padding-top: 0;
        }

        .numbers .sp {
            height: 33mm;
        }

        /* espace avant les 2 lignes de prix (à ajuster si besoin) */

        .numbers .row {
            padding: 2mm 0;
            border-top: 0;
        }

        /* =========================
       PAGE 2 TOP STRIP (la bande verte avec colonnes)
       (juste l’entête, sans gros tableau)
    ========================== */
        .strip {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 2mm;
            margin-bottom: 0;
        }

        .strip td {
            border: none;
            background: var(--green);
            color: #fff;
            font-weight: bold;
            padding: 2.6mm 3mm;
        }

        .strip .s-detail {
            width: 63%;
            text-align: left;
        }

        .strip .s-qte {
            width: 9%;
            text-align: center;
        }

        .strip .s-pu {
            width: 10%;
            text-align: center;
        }

        .strip .s-total {
            width: 10%;
            text-align: center;
        }

        .strip .s-tva {
            width: 8%;
            text-align: center;
        }

        /* =========================
       PAGE 2 CONTENT (bas)
    ========================== */
        .p2-content {
            margin-top: 95mm;
            /* grand blanc comme capture */
        }

        .section-h {
            font-weight: bold;
            text-transform: uppercase;
            margin: 0 0 2mm 0;
            font-size: 8.5pt;
        }

        .para {
            font-size: 8.2pt;
            line-height: 1.25;
            margin: 0 0 4mm 0;
        }

        .gray-box {
            background: var(--gray);
            border: 1px solid #cfcfcf;
            padding: 4mm 4mm;
            margin-top: 6mm;
        }

        .sign-total {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .sign-total td {
            border: none;
            vertical-align: top;
        }

        .sign-total .sign {
            width: 62%;
            padding-right: 6mm;
            font-size: 8pt;
        }

        .sign-total .tot {
            width: 38%;
            font-size: 8.5pt;
        }

        .totals {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .totals td {
            border: none;
            padding: 1mm 0;
        }

        .totals .lbl {
            text-align: right;
            padding-right: 3mm;
        }

        .totals .val {
            text-align: right;
            font-weight: bold;
        }

        .totals .highlight {
            color: #7b6a00;
        }

        /* reste à payer en jaune/olive */

        .pay-mode {
            margin-top: 3mm;
            font-size: 8pt;
        }

        /* =========================
       FOOTER (ligne + texte + page)
    ========================== */
    
        .footer-line {
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

        .footer-text {
            text-align: center;
            font-size: 7.8pt;
            color: #111;
            line-height: 1.25;
        }

        .page-no {
            text-align: right;
            font-size: 8pt;
            margin-top: 1mm;
            color: #111;
        }
    </style>
</head>

<body>

    <!-- ===================== PAGE 1 ===================== -->
    <div class="page">
        <div class="content">
            <div class="header">
                <table class="header-top">
                    <tr>
                        <td class="logo-wrap">
                            <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="MY HOUSE">
                        </td>
                        <td></td>
                    </tr>
                </table>

                <table class="devis-bar">
                    <tr>
                        <td>DEVIS {{ $document->reference_devis }}</td>
                    </tr>
                </table>
            </div>

            <table class="infos">
                <tr>
                    <td class="left">
                        <div class="muted"><span class="b">Date :</span>
                            {{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</div>

                        <div class="mt2 muted b" style="text-transform:uppercase;">Adresse des travaux :</div>
                        <div class="muted">{{ $document->adresse_travaux }}</div>

                        <div class="mt2 muted"><span class="b">Parcelle cadastrale :</span>
                            {{ $document->parcelle_cadastrale ?? '' }}</div>
                        <div class="muted"><span class="b">N° immatriculation :</span>
                            {{ $document->numero_immatriculation ?? '' }}</div>
                        <div class="muted"><span class="b">Nombre bâtiments :</span>
                            {{ $document->nombre_batiments ?? '' }}</div>
                        <div class="muted"><span class="b">Détails bâtiments :</span>
                            {{ $document->details_batiments ?? '' }}</div>
                        <div class="muted"><span class="b">Nom de résidence :</span>
                            {{ $document->nom_residence ?? '' }}</div>
                        <div class="muted"><span class="b">Date travaux :</span> {{ $document->date_travaux ?? '' }}
                        </div>
                        <div class="muted"><span class="b">Date de désembouage :</span>
                            {{ $document->dates_previsionnelles ?? '' }}</div>
                    </td>

                    <td class="right">
                        <div class="b" style="text-transform:uppercase;">
                            {{ $document->fournisseur_nom ?? 'BBR MAINTENANCE' }}</div>
                        <div class="mt2 muted"><span class="b">Siret :</span> {{ $document->fournisseur_siret ?? '' }}
                        </div>
                        <div class="muted"><span class="b">Adresse :</span> {{ $document->fournisseur_adresse ?? '' }}
                        </div>
                        <div class="muted"><span class="b">Tel :</span> {{ $document->fournisseur_tel ?? '' }}</div>
                        <div class="muted"><span class="b">Mail :</span> {{ $document->fournisseur_email ?? '' }}</div>
                        <div class="muted"><span class="b">Représenté par :</span>
                            {{ $document->fournisseur_representant ?? '' }}</div>
                        <div class="muted"><span class="b">Fonction :</span> {{ $document->fournisseur_fonction ?? '' }}
                        </div>
                    </td>
                </tr>
            </table>

            <table class="main-table">
                <thead>
                    <tr>
                        <th class="col-detail">Détail</th>
                        <th class="col-qte">Quantité</th>
                        <th class="col-pu">P.U HT</th>
                        <th class="col-total">Total HT</th>
                        <th class="col-tva">TVA</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td class="detail">
                            <p>
                                {{ $document->detail_principal ?? "Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude, opération entrant dans le dispositif de prime C.E.E. (Certificat d’Economie d’Energie), conforme aux recommandations de la fiche technique N° BAR-SE-104." }}
                            </p>

                            <div class="mt3">
                                <p><span class="b">Kwh Cumac :</span> {{ $document->wh_cumac }}</p>
                                <p><span class="b">Prime CEE :</span>
                                    {{ number_format($document->prime_cee, 2, ',', ' ') }} €</p>
                                <p>Matériel(s) fourni(s) et mis en place par notre société
                                    {{ $document->client_nom ?? "MY HOUSE" }}, représentée par
                                    {{ $document->client_representant ?? "" }}, SIRET
                                    {{ $document->client_siret ?? "" }}</p>
                            </div>

                            <div class="mt3">
                                <p class="b">Installation collective de chauffage alimentée par une chaudière hors
                                    condensation</p>
                                <p>Puissance nominale de la chaudière : <span
                                        class="b">{{ $document->puissance_chaudiere }}</span> kW</p>
                                <p>Nombre de logements concernés : <span
                                        class="b">{{ $document->nombre_logements }}</span></p>
                            </div>

                            <div class="mt4 b" style="text-transform:uppercase;">Détail de la prestation</div>

                            <p class="mt2">1 - Réglage des organes d’équilibrage d’une installation de chauffage à eau
                                chaude, destiné à assurer une température uniforme dans tous les locaux :</p>

                            <p class="mt2">2 - Mise en place matériel d’équilibrage :</p>
                            <ul>
                                <li>Relevé sur site de l’installation</li>
                                <li>Réalisation d’un plan du sous-sol des PDC</li>
                                <li>Réalisation d’un synoptique des colonnes</li>
                                <li>Réalisation d’une note de calcul des puissances de débits et réglages théoriques par
                                    logement</li>
                                <li>Réglage du point de fonctionnement de la pompe chauffage</li>
                                <li>Réalisation d’une mesure de débit sur les PDC et antennes</li>
                                <li>Un tableau d’enregistrement des températures moyennes sur un échantillon des
                                    logements, après équilibrage</li>
                                <li>L’écart de température entre l’appartement le plus chauffé et le moins chauffé doit
                                    être strictement inférieur à 2°C</li>
                            </ul>

                            <div class="mt3 b" style="text-transform:uppercase;">Compris dans les travaux :</div>
                            <ul>
                                <li>La dépose et l’enlèvement de votre ancien appareil</li>
                                <li>La protection et le nettoyage du chantier</li>
                                <li>Le remplissage et la purge de votre installation</li>
                            </ul>
                        </td>

                        <!-- colonnes chiffrées : comme capture (2 lignes) -->
                        <td class="numbers">
                            <div class="sp"></div>
                            <div class="row">1</div>
                            <div class="row">1</div>
                        </td>

                        <td class="numbers">
                            <div class="sp"></div>
                            <div class="row">{{ number_format($document->ligne1_pu_ht ?? 5315.68, 2, ',', ' ') }} €
                            </div>
                            <div class="row">{{ number_format($document->ligne2_pu_ht ?? 1771.90, 2, ',', ' ') }} €
                            </div>
                        </td>

                        <td class="numbers">
                            <div class="sp"></div>
                            <div class="row">{{ number_format($document->ligne1_total_ht ?? 5315.68, 2, ',', ' ') }} €
                            </div>
                            <div class="row">{{ number_format($document->ligne2_total_ht ?? 1771.90, 2, ',', ' ') }} €
                            </div>
                        </td>

                        <td class="numbers" style="text-align:center;">
                            <div class="sp"></div>
                            <div class="row">5,5 %</div>
                            <div class="row">5,5 %</div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="footer-line">
                <div class="footer-text">
                    MY HOUSE au capital de 7 500 € - Code APE 4322B - SIRET :
                    {{ $document->client_siret ?? "89155603000466" }} - rcs Pau - N° TVA Intracom :
                    {{ $document->client_tva ?? "FR12891556003" }}<br>
                    Tél. : {{ $document->client_tel ?? "05 59 60 21 51" }} Mail :
                    {{ $document->client_email ?? "contact@myhouse64.fr" }}
                </div>
                <div class="page-no">1/2</div>
            </div>

        </div>
    </div>
    <!-- ===================== PAGE 2 ===================== -->
    <div class="page">
        <div class="content">
            <div class="header">
                <table class="header-top">
                    <tr>
                        <td class="logo-wrap">
                            <img src="{{ public_path('assets/img/myhouse/logo.png') }}" alt="MY HOUSE">
                        </td>
                        <td></td>
                    </tr>
                </table>

                <table class="devis-bar">
                    <tr>
                        <td>DEVIS {{ $document->reference_devis }}</td>
                    </tr>
                </table>

                <!-- la bande verte avec intitulés colonnes (comme capture page 2) -->
                <table class="strip">
                    <tr>
                        <td class="s-detail">Détail</td>
                        <td class="s-qte">Quantité</td>
                        <td class="s-pu">P.U HT</td>
                        <td class="s-total">Total HT</td>
                        <td class="s-tva">TVA</td>
                    </tr>
                </table>
            </div>

            <!-- grand espace blanc + contenu en bas -->
            <div class="p2-content">

                <div class="section-h">Conditions de paiement</div>
                <div class="para">
                    « Les travaux ou prestations objet du présent document donneront lieu à une contribution financière
                    de
                    EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous
                    forme de prime,
                    directement ou via son (ses) mandataire(s), sous réserve de l’engagement du fournisseur
                    exclusivement à
                    EBS ENERGIE des documents nécessaires à la valorisation des opérations au titre du dispositif des
                    Certificats
                    d’Économies d’Énergie et sous réserve de la validation de l’éligibilité du dossier par EBS ENERGIE
                    puis par
                    l’autorité administrative compétente.<br><br>
                    Le montant de cette contribution financière, hors champ d’application de la TVA, est susceptible de
                    varier en
                    fonction des travaux effectivement réalisés et du volume des CEE attribués à l’opération et est
                    estimé à
                    {{ number_format($document->prime_cee, 2, ',', ' ') }} € »
                </div>

                <div class="section-h">Gestion des déchets</div>
                <div class="para">
                    Gestion, évacuation et traitements des déchets de chantier comprenant la main d’œuvre liée à la
                    dépose et au tri,
                    le transport des déchets de chantiers vers un ou plusieurs points de collecte et coûts de
                    traitement.
                </div>

                <div class="gray-box">
                    <table class="sign-total">
                        <tr>
                            <td class="sign">
                                <div class="b">Signature, date, cachet commercial & mention « Bon pour accord » :</div>
                                <div>Nom, prénom et fonction du signataire</div>
                            </td>

                            <td class="tot">
                                <table class="totals">
                                    <tr>
                                        <td class="lbl">Total H.T</td>
                                        <td class="val">{{ number_format($document->montant_ht, 2, ',', ' ') }} €</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Total TVA {{ $document->taux_tva ?? '20' }}%</td>
                                        <td class="val">{{ number_format($document->montant_tva, 2, ',', ' ') }} €</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">Total TTC</td>
                                        <td class="val">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl">* Prime CEE</td>
                                        <td class="val">- {{ number_format($document->prime_cee, 2, ',', ' ') }} €</td>
                                    </tr>
                                    <tr>
                                        <td class="lbl b highlight">Reste à payer</td>
                                        <td class="val highlight">
                                            {{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <div class="pay-mode">Mode de paiement : Chèques, virement ou espèce</div>
                </div>

            </div>

            <div class="footer-line">
                <div class="footer-text">
                    MY HOUSE au capital de 7 500 € - Code APE 4322B - SIRET :
                    {{ $document->client_siret ?? "89155603000466" }} - rcs Pau - N° TVA Intracom :
                    {{ $document->client_tva ?? "FR12891556003" }}<br>
                    Tél. : {{ $document->client_tel ?? "05 59 60 21 51" }} Mail :
                    {{ $document->client_email ?? "contact@myhouse64.fr" }}
                </div>
                <div class="page-no">2/2</div>
            </div>
        </div>
    </div>

</body>

</html>