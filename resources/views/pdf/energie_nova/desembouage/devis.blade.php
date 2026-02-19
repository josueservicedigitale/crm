<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Devis - ENERGIE NOVA</title>

  <style>
    /* ===========================
       DOMPDF SAFE – MARGES GARANTIES
       =========================== */

    @page {
      size: A4;
      margin: 20mm 15mm;
    }

    :root {
      --blue: #0b3b5b;
      --blue2: #0a3550;
      --green: #62b14f;
      --border: #0b3b5b;
      --tbl: #003366;
      --gray: #f0f0f0;
      --frame: 180mm;
      /* 210 - 15 - 15 = 180mm : largeur imprimable */
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html,
    body {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 9pt;
      color: #000;
      background: #fff;
    }

    /* Pages */
    .page {
      page-break-after: always;
    }

    .page:last-child {
      page-break-after: auto;
    }

    /* ✅ CADRE IMPRIMABLE RÉEL : empêche tout débordement */
    .page-content {
      width: var(--frame);
      margin: 5mm auto;
      padding: 5mm;
      /* le cadre fait déjà les marges */
    }

    /* Safety overflow */
    img,
    table,
    div {
      max-width: 100%;
    }

    img {
      height: auto;
    }

    /* Wrap agressif */
    td,
    th,
    p,
    li,
    div {
      word-break: break-word;
      overflow-wrap: anywhere;
    }

    /* Typo */
    .strong {
      font-weight: 800;
    }

    .line {
      margin: 1px 0;
    }

    .sectionTitle {
      margin: 3mm 0 2mm 0;
      font-weight: 800;
      color: var(--blue);
      text-transform: uppercase;
      font-size: 9pt;
    }

    .subTitle {
      margin: 2.5mm 0 1.5mm 0;
      font-weight: 800;
      color: var(--blue);
      font-size: 8.7pt;
      text-transform: uppercase;
    }

    .para {
      margin: 1.2mm 0;
      line-height: 1.25;
    }

    /* Tables dompdf safe */
    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      /* IMPORTANT */
      margin: 4mm 0;
    }

    /* Header top (table) */
    .top {
      margin: 0 0 4mm 0;
    }

    .top-table {
      margin: 0;
    }

    .top-table td {
      border: none;
      padding: 0;
      vertical-align: top;
    }

    .brand-inner {
      margin: 0;
    }

    .brand-inner td {
      border: none;
      padding: 0;
    }

    .brand-logo {
      width: 100mm;
      height: 22mm;
      display: flex;
      align-items: center;
      justify-content: center;

    }

    .brand-logo img {
      max-width: 100%;
      max-height: 100%;
      width: auto;
      height: auto;
      display: block;
    }

    .brand-name {
      color: var(--green);
      font-weight: 800;
      font-size: 20pt;
      letter-spacing: .5px;
      padding-top: 4mm;
    }

    .refbox {
      width: 85mm;
      border: 2px solid var(--border);
      border-collapse: collapse;
      display: inline-table;
      font-size: 10pt;
      margin-top: 1mm;
      background-color: var(--tbl);
    }

    .refbox td {
      border: 2px solid var(--border);
      padding: 6px 7px;
      font-weight: 700;
      color: #ffffff;
    }

    .refbox .k {
      width: 40%;
      background: var(--blue);
      color: #fff;
      font-weight: 800;
      text-transform: uppercase;
    }

    /* 2 colonnes infos */
    .cols {
      margin: 0 0 3mm 0;
    }

    .cols td {
      border: none;
      padding: 0;
      vertical-align: top;
      font-size: 8.7pt;
      line-height: 1.3;
    }

    .cols td.left {
      padding-right: 10mm;
    }

    .cols h4 {
      margin: 0 0 2mm 0;
      font-size: 9pt;
      color: var(--blue);
      text-transform: uppercase;
      font-weight: 800;
    }

    /* Bloc encadré */
    .box {
      border: 2px solid var(--border);
      padding: 6px 7px;
      margin-top: 4mm;
      font-size: 8.5pt;
      line-height: 1.3;
    }

    .box .title {
      font-weight: 800;
      color: var(--blue);
      text-transform: uppercase;
      margin-bottom: 2mm;
    }

    .object {
      margin-top: 3mm;
      font-size: 8.7pt;
      line-height: 1.3;
    }

    .object .label {
      font-weight: 800;
      color: var(--blue);
    }

    /* Table principale bleue */
    table.main {
      margin-top: 5mm;
      font-size: 8.6pt;
    }

    table.main th,
    table.main td {
      border: 2px solid var(--border);
      padding: 6px 7px;
      vertical-align: top;
    }

    table.main thead th {
      background: var(--blue);
      background-color: var(--tbl);
      color: #fff;
      font-weight: 800;
      text-transform: uppercase;
      font-size: 8.8pt;
      letter-spacing: .2px;
    }

    .w-detail {
      width: 60%;
    }

    .w-qte {
      width: 10%;
      text-align: center;
    }

    .w-pu {
      width: 12%;
      text-align: center;
    }

    .w-total {
      width: 12%;
      text-align: center;
    }

    .w-tva {
      width: 6%;
      text-align: center;
    }

    /* Anti pages fantômes: éviter les colonnes vides énormes */
    table.grid4 thead th:nth-child(1) {
      width: 58%;
    }

    table.grid4 thead th:nth-child(2) {
      width: 10%;
      text-align: center;
    }

    table.grid4 thead th:nth-child(3) {
      width: 10%;
      text-align: center;
    }

    table.grid4 thead th:nth-child(4) {
      width: 12%;
      text-align: center;
    }

    table.grid4 thead th:nth-child(5) {
      width: 10%;
      text-align: center;
    }

    .avoid-break {
      page-break-inside: avoid;
    }

    /* Footer */
    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 7pt;
      color: #2b2b2b;
    }

    .pageno {
      margin-top: 2mm;
      text-align: right;
      font-size: 8pt;
      color: #1b1b1b;
    }

    /* Page 4 bottom 2 colonnes */
    .bottomRow {
      margin-top: 6mm;
    }

    .bottomRow td {
      border: none;
      vertical-align: top;
      padding: 0;
    }

    .paybox {
      border: 2px solid var(--border);
      padding: 8px;
      font-size: 8.5pt;
      line-height: 1.3;
    }

    .paybox .title {
      font-weight: 800;
      color: var(--blue);
      text-transform: uppercase;
      margin-bottom: 2mm;
    }

    .totals {
      padding-left: 8mm;
      font-size: 9pt;
      line-height: 1.55;
    }

    .totals-table {
      margin: 0;
    }

    .totals-table td {
      border: none;
      padding: 1mm 0;
      font-weight: 800;
    }

    .totals-table .lbl {
      color: var(--blue);
      text-transform: uppercase;
    }

    .totals-table .val {
      text-align: right;
      width: 45mm;
      color: #000;
    }

    .totals-table .big {
      font-size: 10.5pt;
      padding-top: 2mm;
    }

    .totals-table .rest {
      font-size: 10.5pt;
      padding-top: 3mm;
    }
  </style>
</head>

<body>

  <!-- ===================== PAGE 1 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="top">
        <table class="top-table">
          <tr>
            <td class="brand">
              <table class="brand-inner">
                <tr>
                  <td class="brand-logo">
                    <img src="{{ public_path('assets/img/nova/Devis_files/Image_002.png') }}" alt="Logo">
                  </td>
                </tr>
              </table>
            </td>

            <td class="refbox-wrap" style="text-align:right;">
              <table class="refbox">
                <tr>
                  <td class="k">REF DEVIS</td>
                  <td>{{ $document->reference_devis }}</td>
                </tr>
                <tr>
                  <td class="k">DATE DEVIS</td>
                  <td>{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <table class="cols">
        <tr>
          <td class="left">
            <h4>ENERGIE NOVA</h4>
            <div class="line">60 Rue FRANCOIS 1 ER</div>
            <div class="line">75008 PARIS</div>
            <div class="line">SIRET 933 487 795 00017</div>
            <br>
            <div class="line"><span class="strong">Représenté par</span> M. TAMOYAN Hamlet, en qualité de Président
            </div>
            <div class="line">07 67 87 04 09 - direction@energie-nova.com</div>
            <br>
            <div class="line">RC Décennale ERGO contrat n° 2507651683 Qualification</div>
            <div class="line">Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</div>
          </td>

          <td>
            <h4>BÉNÉFICIAIRE</h4>
            <div class="line strong">{{ $document->society }}</div>
            <div class="line">{{ $document->activity }}</div>
            <div class="line">{{ $document->adresse_beneficiaire ?? '' }}</div>
            <br>
            <div class="line"><span class="strong">SIRET</span> {{ $document->reference }}</div>
            <div class="line"><span class="strong">MAIL</span> {{ $document->email_beneficiaire ?? '' }}</div>
            <div class="line"><span class="strong">TEL</span> {{ $document->tel_beneficiaire ?? '' }}</div>
            <br>
            <div class="line"><span class="strong">REPRÉSENTÉ PAR</span> {{ $document->representant ?? '' }}</div>
            <div class="line"><span class="strong">FONCTION</span> {{ $document->fonction ?? '' }}</div>
          </td>
        </tr>
      </table>

      <div class="object">
        <span class="label">OBJET :</span>
        Opération entrant dans le dispositif de prime C.E.E. (Certificat d’Economie d’Energie),
        conforme aux recommandations de la fiche technique N° BAR-SE-109 de C.E.E. décrites
        par le ministère de la Transition énergétique.
      </div>

      <div class="box">
        <div class="title">DESCRIPTION</div>
        Désembouage de l’ensemble du système de distribution par boucle d’eau d’une installation de chauffage collectif
        alimentée par une chaudière utilisant un combustible fossile ou alimenté par un réseau de chaleur.
        <br><br>

        <div class="para"><span class="strong">SITE DES TRAVAUX :</span> {{ $document->adresse_travaux }}</div>
        <div class="para"><span class="strong">NUMÉRO IMMATRICULATION DE COPROPRIÉTÉ :</span>
          {{ $document->numero_immatriculation }} - {{ $document->nom_residence }}</div>
        <div class="para"><span class="strong">ZONE CLIMATIQUE :</span> {{ $document->zone_climatique }}</div>

        <div class="para"><span class="strong">PARCELLE CADASTRALE :</span></div>
        <div class="para">1&nbsp;&nbsp;Parcelle {{ $document->parcelle_1 }} Feuille
          {{ $document->parcelle_2 }}&nbsp;&nbsp;&nbsp;&nbsp;2</div>
        <div class="para">
          3&nbsp;&nbsp;{{ $document->parcelle_3 }}&nbsp;&nbsp;&nbsp;&nbsp;4&nbsp;&nbsp;{{ $document->parcelle_4 }}</div>

        <br>
        <div class="para"><span class="strong">DATE PRÉVISIONNELLE DES TRAVAUX :</span>
          {{ $document->dates_previsionnelles }}</div>
        <div class="para"><span class="strong">CONTACT SUR SITE :</span> {{ $document->contact_site ?? 'Gérant' }}</div>
        <div class="para"><span class="strong">SECTEUR :</span> Résidentiel</div>
        <div class="para"><span class="strong">NOMBRE DE BÂTIMENTS :</span> {{ $document->nombre_batiments }} Bâtiments
        </div>
        <div class="para"><span class="strong">DÉTAILS :</span> {{ $document->details_batiments }}</div>
      </div>

      <table class="main">
        <thead>
          <tr>
            <th class="w-detail">DETAIL</th>
            <th class="w-qte">QUANTITE</th>
            <th class="w-pu">PU HT</th>
            <th class="w-total">TOTAL HT</th>
            <th class="w-tva">TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="strong" style="color:var(--blue);">
                Désembouage de l’ensemble du système de distribution par boucle d’eau d’une installation de chauffage
                collectif
                alimentée par une chaudière utilisant un combustible fossile
              </div>
              <br>
              Opération entrant dans le dispositif de prime C.E.E. (Certificat d’Economie d’Energie),
              conforme aux recommandations de la fiche technique N° BAR-SE-109 de C.E.E. décrites
              par le ministère de la Transition énergétique.
            </td>
            <td class="w-qte">1</td>
            <td class="w-pu">{{ number_format($document->montant_ht, 2, ',', ' ') }}</td>
            <td class="w-total">{{ number_format($document->montant_ht, 2, ',', ' ') }}</td>
            <td class="w-tva">20 %</td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 1/4</div>

    </div>
  </div>

  <!-- ===================== PAGE 2 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="top">
        <table class="top-table">
          <tr>
            <td class="brand">
              <table class="brand-inner">
                <tr>
                  <td class="brand-logo">
                    <img src="{{ public_path('assets/img/nova/Devis_files/Image_002.png') }}" alt="Logo">
                  </td>
                </tr>
              </table>
            </td>

            <td class="refbox-wrap" style="text-align:right;">
              <table class="refbox">
                <tr>
                  <td class="k">REF DEVIS</td>
                  <td>{{ $document->reference_devis }}</td>
                </tr>
                <tr>
                  <td class="k">DATE DEVIS</td>
                  <td>{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <table class="main grid4">
        <thead>
          <tr>
            <th>DETAIL</th>
            <th>QUANTITE</th>
            <th>PU HT</th>
            <th>TOTAL HT</th>
            <th>TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="sectionTitle">CARACTÉRISTIQUES DE L’INSTALLATION</div>
              <div class="strong" style="color:var(--blue); margin-bottom:4px;">
                INSTALLATION COLLECTIVE DE CHAUFFAGE ALIMENTÉE PAR UNE CHAUDIÈRE HORS CONDENSATION
              </div>
              <ul>
                <li>Puissance nominale de la chaudière : {{ $document->puissance_chaudiere }} kW</li>
                <li>Nombre de logements concernés : {{ $document->nombre_logements }}</li>
                <li>Nombre d’émetteurs désemboués : {{ $document->nombre_emetteurs }}</li>
                <li>Nature du réseau : Acier</li>
                <li>Volume total du circuit d’eau : {{ $document->volume_circuit }} L</li>
                <li>Zone climatique : {{ $document->zone_climatique }}</li>
                <li>Filtres : {{ $document->nombre_filtres }}</li>
              </ul>

              <div class="para" style="margin-top:10px;">
                <span class="strong" style="color:var(--blue);">KWH CUMAC :</span> {{ $document->wh_cumac }}
              </div>
              <div class="para">
                <span class="strong" style="color:var(--blue);">PRIME CEE :</span>
                {{ number_format($document->prime_cee, 2, ',', ' ') }} €
              </div>
              <div class="para">
                <span class="strong" style="color:var(--blue);">NET DE TAXE</span>
              </div>

              <div class="sectionTitle" style="margin-top:14px;">DÉTAIL DE LA PRESTATION</div>
              <div class="strong" style="color:var(--blue);">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES :
              </div>

              <div class="subTitle">A. INJECTION D’UN RÉACTIF DÉSEMBOUANT ET CIRCULATION</div>
              <div class="strong" style="color:var(--blue2); margin-top:6px;">PRÉPARATION ET DIAGNOSTIC INITIAL</div>
              <ul>
                <li>Vérification de l’état général de l’installation de chauffage</li>
                <li>Contrôle de la pression et de l’étanchéité du circuit</li>
                <li>Test de fonctionnement des vannes et organes de régulation</li>
                <li>Relevé des températures et pressions en fonctionnement</li>
              </ul>

              <div class="para strong" style="margin-top:8px;">Injection du produit désembouant SENTINEL X800</div>
              <ul>
                <li>Dosage : 1% du volume d’eau de l’installation</li>
                <li>Méthode d’injection : Via un point d’injection dédié ou par le vase d’expansion</li>
                <li>Dilution : Mélange homogène du produit dans l’ensemble du circuit</li>
              </ul>

              <div class="strong" style="color:var(--blue2); margin-top:10px;">CIRCULATION AVEC POMPE DE DÉSEMBOUAGE
              </div>
              <ul>
                <li>Équipement utilisé : Pompe de désembouage haute performance (débit minimum 30 L/min)</li>
                <li>Circulation générale :
                  <ul>
                    <li>Mise en circulation sur l’ensemble du réseau pendant 4 heures minimum</li>
                    <li>Température de circulation : 50-60°C pour optimiser l’action du produit</li>
                  </ul>
                </li>
                <li>Circulation réseau par réseau :
                  <ul>
                    <li>Isolation et traitement de chaque réseau de distribution individuellement</li>
                    <li>Circulation dans les deux sens pour décoller tous les dépôts</li>
                    <li>Durée par réseau : 2 heures minimum dans chaque sens</li>
                  </ul>
                </li>
                <li>Surveillance : Contrôle visuel de la couleur de l’eau (passage du trouble au clair)</li>
              </ul>

              <div class="subTitle" style="margin-top:10px;">B. RINÇAGE DES CIRCUITS À L’EAU CLAIRE</div>
              <div class="strong" style="color:var(--blue2);">RINÇAGE GÉNÉRAL</div>
              <ul>
                <li>Évacuation complète du produit désembouant par les points de purge</li>
                <li>Remplissage progressif à l’eau claire du réseau public</li>
                <li>Circulation intensive pendant 2 heures minimum</li>
                <li>Contrôle qualité : Vérification de la limpidité de l’eau en sortie</li>
              </ul>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 2/4</div>

    </div>
  </div>

  <!-- ===================== PAGE 3 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="top">
        <table class="top-table">
          <tr>
            <td class="brand">
              <table class="brand-inner">
                <tr>
                  <td class="brand-logo">
                    <img src="{{ public_path('assets/img/nova/Devis_files/Image_002.png') }}" alt="Logo">
                  </td>

                </tr>
              </table>
            </td>

            <td class="refbox-wrap" style="text-align:right;">
              <table class="refbox">
                <tr>
                  <td class="k">REF DEVIS</td>
                  <td>{{ $document->reference_devis }}</td>
                </tr>
                <tr>
                  <td class="k">DATE DEVIS</td>
                  <td>{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <table class="main grid4">
        <thead>
          <tr>
            <th>DETAIL</th>
            <th>QUANTITE</th>
            <th>PU HT</th>
            <th>TOTAL HT</th>
            <th>TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="subTitle">RINÇAGE RÉSEAU PAR RÉSEAU</div>
              <ul>
                <li>Isolation de chaque réseau de distribution</li>
                <li>Rinçage individuel :
                  <ul>
                    <li>Ouverture des vannes de purge des émetteurs</li>
                    <li>Circulation d’eau claire jusqu’à obtention d’une eau limpide</li>
                    <li>Fermeture progressive des purges en commençant par les plus éloignées</li>
                  </ul>
                </li>
                <li>Volume de rinçage : Minimum 3 fois le volume de chaque réseau</li>
                <li>Contrôle final : Test d’absence de résidus et de mousse</li>
              </ul>

              <div class="subTitle" style="margin-top:10px;">REMISE EN PRESSION</div>
              <ul>
                <li>Remplissage complet du circuit à la pression nominale</li>
                <li>Purge de l’air résiduel sur tous les émetteurs</li>
                <li>Vérification de l’absence de fuites</li>
              </ul>

              <div class="sectionTitle" style="margin-top:14px;">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION
                INHIBITEUR</div>

              <div class="strong" style="color:var(--blue2); margin-top:6px;">VÉRIFICATION DU SYSTÈME DE FILTRATION
                EXISTANT</div>
              <ul>
                <li>Localisation des filtres à boues existants sur les circuits de retour</li>
                <li>Démontage et nettoyage des filtres en place</li>
                <li>Contrôle d’efficacité : Vérification du maillage et de l’état général</li>
              </ul>

              <div class="strong" style="color:var(--blue2); margin-top:10px;">INSTALLATION DE FILTRES COMPLÉMENTAIRES
                (SI NÉCESSAIRE)</div>
              <ul>
                <li>Positionnement : Sur chaque circuit de retour au générateur</li>
                <li>Type de filtre : Filtre magnétique séparateur de boues haute performance</li>
                <li>Raccordement : Avec vannes d’isolement pour maintenance future</li>
                <li>Accessibilité : Installation permettant un entretien facile</li>
              </ul>

              <div class="strong" style="color:var(--blue2); margin-top:10px;">INJECTION DU RÉACTIF INHIBITEUR SENTINEL
                X100</div>
              <ul>
                <li>Dosage : 1% du volume d’eau de l’installation</li>
                <li>Méthode d’injection : Via point d’injection dédié</li>
                <li>Circulation : Mise en route de la circulation pendant 30 minutes minimum</li>
                <li>Homogénéisation : Vérification de la répartition uniforme du produit</li>
              </ul>

              <div class="sectionTitle" style="margin-top:14px;">CONTRÔLES FINAUX ET MISE EN SERVICE</div>
              <ul>
                <li>Test de fonctionnement complet de l’installation</li>
                <li>Relevé des paramètres : Température, pression, débit</li>
                <li>Réglages : Ajustement des organes de régulation</li>
                <li>Formation : Explication du fonctionnement au personnel technique</li>
                <li>Documentation : Remise du certificat de désembouage et planning de maintenance</li>
              </ul>

              <div class="sectionTitle" style="margin-top:14px;">PRODUITS UTILISÉS</div>
              <div class="strong" style="color:var(--blue);">SENTINEL X800 DÉSEMBOUANT</div>
              <div class="para">
                Sentinel X800 désembouant pour nettoyage d’un réseau de chauffage, élimine boues, particules de
                corrosion et dépôts de calcaire.
              </div>
              <ul>
                <li>Dosage : 1% du volume d’eau de l’installation</li>
                <li>Aspect : Liquide clair, incolore à jaune pâle</li>
                <li>Odeur : Légère</li>
                <li>Densité (20°C) : 1,06 g/ml</li>
                <li>pH (concentré) : Environ 6,3</li>
                <li>Point de congélation : -8°C</li>
                <li>Agréé par le ministère de la Santé</li>
              </ul>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 3/4</div>

    </div>
  </div>

  <!-- ===================== PAGE 4 (DOMPDF SAFE) ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="top">
        <table class="top-table">
          <tr>
            <td class="brand">
              <table class="brand-inner">
                <tr>
                  <td class="brand-logo">
                    <img src="{{ public_path('assets/img/nova/Devis_files/Image_002.png') }}" alt="Logo">
                  </td>

                </tr>
              </table>
            </td>

            <td class="refbox-wrap" style="text-align:right;">
              <table class="refbox">
                <tr>
                  <td class="k">REF DEVIS</td>
                  <td>{{ $document->reference_devis }}</td>
                </tr>
                <tr>
                  <td class="k">DATE DEVIS</td>
                  <td>{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>

      <table class="main" style="margin-top:0;">
        <thead>
          <tr>
            <th>DETAIL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="strong" style="color:var(--blue);">SENTINEL X100 INHIBITEUR</div>
              <div class="para">
                Sentinel X100 inhibiteur pour protection du réseau de chauffage avec agents inhibiteurs de corrosion et
                anti-tartre.
              </div>

              <ul>
                <li>Dosage : 1% du volume d’eau de l’installation</li>
                <li>Aspect : Liquide clair, incolore à jaune pâle</li>
                <li>Densité (20°C) : 1,10 g/ml</li>
                <li>pH (concentré) : Environ 6,4</li>
                <li>Point de congélation : -2,5°C</li>
                <li>Agréé par le ministère de la Santé</li>
              </ul>

              <div class="sectionTitle" style="margin-top:6mm;">MATÉRIEL ET ENTREPRISE</div>
              <div class="para">
                Matériel / soumis et mis en place par <span class="strong">ENERGIE NOVA</span>,
                60 RUE FRANCOIS 1ER, 75008 PARIS, SIRET 93348779500017, Code APE 7112B.<br>
                Représentée par M. Tamoyan Hamlet, 07 67 87 04 09, direction@energie-nova.com
              </div>

              <div class="para" style="margin-top:2mm;">
                Qualification Qualisav Spécialité Désembouage N° 31376 - ID N° S01810
              </div>

              <div class="para">
                RC Décennale V4737408 contrat n° 2507651683
              </div>

              <div class="para" style="margin-top:3mm;">
                <span class="strong">Durée totale de l’intervention :</span> 1 à 2 jours selon la complexité<br>
                <span class="strong">Garantie :</span> 1 an sur l’intervention de désembouage<br>
                <span class="strong">Suivi :</span> Contrôle recommandé à 6 mois puis annuellement
              </div>

              <table class="bottomRow avoid-break">
                <tr>
                  <td style="width:55%; padding-right:8mm;">
                    <div class="paybox">
                      <div class="title">CONDITIONS DE PAIEMENT</div>
                      <div class="para">
                        Prime versée sous réserve de validation, documents CEE nécessaires, et respect des exigences de
                        l’opération.
                      </div>

                      <div class="subTitle" style="margin-top:3mm;">Gestion des déchets</div>
                      <div class="para">
                        Tri, évacuation, transport et traitement des déchets de chantier.
                      </div>
                    </div>
                  </td>

                  <td style="width:45%;">
                    <div class="totals">
                      <table class="totals-table">
                        <tr>
                          <td class="lbl">MONTANT TOTAL</td>
                          <td class="val">{{ number_format($document->montant_ht, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                          <td class="lbl">HT TVA</td>
                          <td class="val">{{ number_format($document->montant_tva, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                          <td class="lbl big">MONTANT TOTAL TTC</td>
                          <td class="val big">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                          <td class="lbl">PRIME CEE</td>
                          <td class="val">{{ number_format($document->prime_cee, 2, ',', ' ') }} €</td>
                        </tr>
                        <tr>
                          <td class="lbl rest">RESTE À CHARGE</td>
                          <td class="val rest">{{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
              </table>

              <div class="attest">
                <div class="para">En acceptant le présent devis, j’atteste sur l’honneur :</div>
                <ul>
                  <li>Que le bâtiment est existant depuis plus de deux ans.</li>
                  <li>Ne pas avoir bénéficié de primes CEE pour la fiche N° BAR-SE-109 désembouage</li>
                </ul>
              </div>

            </td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 4/4</div>

    </div>
  </div>

</body>

</html>