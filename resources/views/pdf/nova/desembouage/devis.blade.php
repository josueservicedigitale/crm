jai un probleme de mise en page gars
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Devis</title>
  <style>
    @page {
      margin: 20mm 15mm;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 9pt;
      color: #000;
      margin: 0;
      margin-top: 0;
      padding: 0;
    }

    .page-number:before {
      content: counter(page) " / " counter(pages);
    }

    .page {
      page-break-after: always;
      position: relative;
      padding-top: 28mm;
    }

    .page:last-of-type {
      page-break-after: auto;
    }

    .header-content {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .logo-section {
      flex: 1;
    }

    .devis-info {
      flex: 1;
      text-align: right;
    }

    .devis-ref {
      font-weight: bold;
      color: #036;
      margin-bottom: 2mm;
    }

    .devis-date {
      color: #666;
    }

    .page-content {
      padding: 0 15mm;
    }


    /* Styles des classes existantes */
    .s1 {
      color: #0a0;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    .s2 {
      color: black;
      font-family: Calibri;
      font-size: 8pt;
    }

    .s3 {
      color: black;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    .pdf-header, .pdf-footer {
  position: fixed;
  width: 100%;
  left: 0;
  right: 0;
}
.pdf-header {
  top: 0;
  height: 25mm;
}
.pdf-footer {
  bottom: 0;
  text-align: right;
  font-size: 8pt;
}


    .s4 {
      color: #036;
      font-family: Arial;
      font-weight: bold;
      font-size: 8pt;
    }

    .s5 {
      color: #0f3f70;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    .s6 {
      color: #00006a;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    .s10 {
      color: #fff;
      font-family: Calibri;
      font-weight: bold;
      font-size: 10pt;
    }

    .s11 {
      color: #036;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    .s12 {
      color: black;
      font-family: Calibri;
      font-size: 8pt;
    }

    .s13 {
      color: #036;
      font-family: Calibri;
      font-weight: bold;
      font-size: 10pt;
    }

    .s14 {
      color: black;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
    }

    h1 {
      color: #036;
      font-family: Calibri;
      font-weight: bold;
      font-size: 10pt;
      margin: 4px 0;
    }

    h2 {
      color: black;
      font-family: Calibri;
      font-weight: bold;
      font-size: 9pt;
      margin: 4px 0;
    }

    h3 {
      color: #036;
      font-family: Calibri;
      font-weight: bold;
      font-size: 8pt;
      margin: 4px 0;
    }

    p {
      color: black;
      font-family: Calibri;
      font-size: 7pt;
      margin: 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 4mm 0;
    }

    table td,
    table th {
      border: 1px solid #003366;
      padding: 6px;
      vertical-align: top;
      word-break: break-word;
    }

    .table-header {
      background-color: #003366;
      color: white;
    }

   
    ul,
    ol {
      margin-left: 20px;
      margin-bottom: 4mm;
    }

    li {
      margin-bottom: 2px;
    }

    .avoid-break {
      page-break-inside: avoid;
    }

    .signature-section {
      margin-top: 15mm;
      padding-top: 5mm;
      border-top: 1px solid #ccc;
    }

    /* Styles pour le bloc bénéficiaire/fournisseur */
    .beneficiary-supplier-table {
      width: 100%;
      border-collapse: collapse;
      margin: 5mm 0;
      background-color: #f0f0f0;
      font-family: Calibri;
      font-size: 8pt;
    }

    .beneficiary-supplier-table td {
      border: none;
      padding: 10px 15px;
      vertical-align: top;
      width: 48%;
    }

    .beneficiary-supplier-table td.middle {
      width: 4%;
      padding: 0;
    }

    .column-title {
      font-weight: bold;
      margin-bottom: 8px;
      color: #036;
      font-size: 9pt;
    }

    .column-content p {
      margin: 3px 0;
      line-height: 1.4;
      font-size: 8pt;
    }

    .beneficiary-column {
      text-align: left;
    }

    .supplier-column {
      text-align: right;
    }
  </style>
</head>

<body>

  <div class="pdf-header">
    <table width="80%">
      <tr>
        <td width="33%">
          <img src="{{ public_path('assets/img/nova/Devis_files/Image_002.png') }}" height="45">
        </td>
        <td width="33%" align="center">
          <strong>DEVIS N° {{ $document->reference_devis }}</strong>
        </td>
        <td width="33%" align="right">
          Date : {{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}
        </td>
      </tr>
    </table>
  </div>

  <!-- Page 1 -->
  <div class="page">

    <div class="page-content">
      <!-- Bloc Bénéficiaire / Fournisseur - VERSION CORRIGÉE -->
      <!-- Bloc Bénéficiaire / Fournisseur -->
      <table class="beneficiary-supplier-table"
        style="width:100%; background-color:#f0f0f0; table-layout: fixed; border-collapse: collapse;">
        <tr>
          <!-- Bénéficiaire -->
          <td class="beneficiary-column" valign="top" style="width:49%; padding:10px 15px; text-align:left;">
            <strong style="color:#036; font-size:9pt; display:block; margin-bottom:4px;">BENEFICIAIRE</strong>
            RABATHERM HECS<br>
            21 RUE D'ANJOU<br>
            92600 ASNIERES-SUR-SEINE<br>
            SIRET : 44261333700033<br>
            Mail : contact@rabatherm-hecs.fr<br>
            Tél : 01 84 80 90 08<br>
            Représenté par : M. Offel De Villaucourt Charles
          </td>

          <!-- Espace central -->
          <td class="middle" style="width:2%;"></td>

          <!-- Fournisseur -->
          <td class="supplier-column" valign="top" style="width:49%; padding:10px 15px; text-align:right;">
            <strong style="color:#036; font-size:9pt; display:block; margin-bottom:4px;">FOURNISSEUR</strong>
            ENERGIE NOVA<br>
            60 Rue FRANCOIS 1 ER<br>
            75008 PARIS<br>
            SIRET : 933 487 795 00017<br>
            Représenté par : M. TAMOYAN Hamlet, Président<br>
            Tél : 07 678 470 49<br>
            Mail : direction@energie-nova.com<br>
            RC Décennale ERGO contrat n° 25076156863<br>
            Qualification : Qualisav Spécialité Désembouage N° 31376 - ID N° S01810
          </td>
        </tr>
      </table>


      <br>
      <h3>DESCRIPTIF</h3>
      <p class="s2">Désembouage de l'ensemble du système de distribution par boucle d'eau d'une installation de
        chauffage collectif alimentée par une chaudière utilisant un combustible fossile ou alimenté par un réseau de
        chaleur</p>
      <h3>SITE DES TRAVAUX : <span class="s2">6, 8 All. des Tilleuls, 93110 Rosny-sous-Bois</span></h3>
      <p class="s2"><span class="s5">NUMÉRO IMMATRICULATION DE COPROPRIÉTÉ</span> <span class="s6">:</span> AA0588830
        <b>-</b> RES SONATE
      </p>
      <p class="s5">ZONE CLIMATIQUE <span class="s2">: H1</span></p>
      <p class="s5">PARCELLE CADASTRALE :</p>
      <p class="s5">1 <span class="s2">Parcelle</span> <span class="s7">2</span></p>
      <h3>3 <span class="s8">4</span></h3>
      <br>
      <p class="s5">DATE PREVISIONNELLE DES TRAVAUX <span class="s9">:</span> <span class="s2">Du 07/10/2025 au
          08/10/2025</span></p>
      <h3>CONTACT SUR SITE : <a href="mailto:contact@rabatherm-hecs.fr">Gérant M. Offel De Villaucourt Charles 01 84 80
          90 08 - contact@rabatherm-hecs.fr</a></h3>
      <h3>SECTEUR : <span class="s2">Résidentiel</span></h3>
      <h3>NOMBRE DE BATIMENTS : <span class="s2">3 Batiments .</span></h3>
      <h3>DETAILS : <span class="s2">Bat A ( 47 Logs ), Bat B ( 46 Logs ), Bat C ( 46 Logs )</span></h3>
      <p class="s2">0290 Feuille 000 0T 001</p>
      <br>
      <h3>OBJET : <span class="s2">Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie
          d'Energie), conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère
          de la Transition énergétique.</span></h3>

      <table>
        <tr>
          <td class="table-header">
            <p class="s10">DETAIL</p>
          </td>
          <td class="table-header">
            <p class="s10">QUANTITE</p>
          </td>
          <td class="table-header">
            <p class="s10">PU HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TOTAL HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TVA</p>
          </td>
        </tr>
        <tr>
          <td>
            <p class="s11">Désembouage de l'ensemble du système de distribution par boucle d'eau d'une installation de
              chauffage collectif alimentée par une chaudière utilisant un combustible fossile.</p>
            <p class="s12">Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie d'Energie),
              conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère de la
              Transition énergétique.</p>
          </td>
          <td>
            <p class="s12">1</p>
          </td>
          <td bgcolor="#FEF3C1">
            <p class="s12">12 259,80</p>
          </td>
          <td bgcolor="#FEF3C1">
            <p class="s12">12 259,80</p>
          </td>
          <td>
            <p class="s12">20 %</p>
          </td>
        </tr>
      </table>
    </div>
  </div>
  
  <!-- <div class="page-break"></div> -->

  <!-- Page 2 -->
  <div class="page">

    <div class="page-content">
      <table>
        <tr>
          <td class="table-header">
            <p class="s10">DETAIL</p>
          </td>
          <td class="table-header">
            <p class="s10">QUANTITE</p>
          </td>
          <td class="table-header">
            <p class="s10">PU HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TOTAL HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TVA</p>
          </td>
        </tr>
        <tr>
          <td>
            <p class="s13">CARACTÉRISTIQUES DE L'INSTALLATION</p>
            <p class="s11">INSTALLATION COLLECTIVE DE CHAUFFAGE ALIMENTÉE PAR UNE CHAUDIÈRE HORS CONDENSATION</p>
            <ul>
              <li>Puissance nominale de la chaudière : 670 kW</li>
              <li>Nombre de logements concernés : 139</li>
              <li>Nombre d'émetteurs désemboués : 487</li>
              <li>Nature du réseau : Acier</li>
              <li>Volume total du circuit d'eau: 5 396 L</li>
              <li>Zone climatique : H1</li>
              <li>Filtres : 14</li>
              <li>KWH CUMAC : 1 751 400</li>
              <li>PRIME CEE : 12 259,80 €</li>
              <li>NET DE TAXE</li>
            </ul>
            <p class="s13">DÉTAIL DE LA PRESTATION</p>
            <p class="s11">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES :</p>
            <ol>
              <li>INJECTION D'UN RÉACTIF DÉSEMBOUANT ET CIRCULATION
                <p class="s12">PREPARATION ET DIAGNOSTIC INITIAL</p>
                <ul>
                  <li>Vérification de l'état général de l'installation de chauffage</li>
                  <li>Contrôle de la pression et de l'étanchéité du circuit</li>
                  <li>Test de fonctionnement des vannes et organes de régulation</li>
                  <li>Relevé des températures et pressions de fonctionnement Injection du produit désembouant SENTINEL
                    X800</li>
                  <li>Dosage : 1% du volume d'eau de l'installation</li>
                  <li>Méthode d'injection : Via un point d'injection dédié ou par le vase d'expansion</li>
                  <li>Dilution : Mélange homogène du produit dans l'ensemble du circuit CIRCULATION AVEC POMPE DE
                    DESEMBOUAGE</li>
                  <li>Équipement utilisé : Pompe de désembouage haute performance (débit minimum 30 L/min)</li>
                  <li>Circulation générale :
                    <ul>
                      <li>Mise en circulation sur l'ensemble du réseau pendant 4 heures minimum</li>
                      <li>Température de circulation : 50-60°C pour optimiser l'action du produit</li>
                    </ul>
                  </li>
                  <li>Circulation réseau par réseau :
                    <ul>
                      <li>Isolation et traitement de chaque réseau de distribution individuellement</li>
                      <li>Circulation dans les deux sens pour décoller tous les dépôts</li>
                      <li>Durée par réseau : 2 heures minimum dans chaque sens</li>
                    </ul>
                  </li>
                  <li>Surveillance : Contrôle visuel de la couleur de l'eau (passage du trouble au clair)</li>
                </ul>
              </li>
            </ol>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
    </div>
  </div>
  <!-- <div class="page-break"></div> -->

  <!-- Page 3 -->
  <div class="page">

    <div class="page-content">
      <table>
        <tr>
          <td class="table-header">
            <p class="s10">DETAIL</p>
          </td>
          <td class="table-header">
            <p class="s10">QUANTITE</p>
          </td>
          <td class="table-header">
            <p class="s10">PU HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TOTAL HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TVA</p>
          </td>
        </tr>
        <tr>
          <td>
            <ol start="2">
              <li>RINÇAGE DES CIRCUITS À L'EAU CLAIRE
                <p class="s12">RINÇAGE GENERAL</p>
                <ul>
                  <li>Évacuation complète du produit désembouant par les points de purge</li>
                  <li>Remplissage progressif à l'eau claire du réseau public</li>
                  <li>Circulation intensive pendant 2 heures minimum</li>
                  <li>Contrôle qualité : Vérification de la limpidité de l'eau en sortie</li>
                </ul>
              </li>
            </ol>
            <p class="s12">RINÇAGE RESEAU PAR RESEAU</p>
            <ul>
              <li>Isolation de chaque réseau de distribution</li>
              <li>Rinçage individuel :
                <ul>
                  <li>Ouverture des vannes de purge des émetteurs</li>
                  <li>Circulation d'eau claire jusqu'à obtention d'une eau limpide</li>
                  <li>Fermeture progressive des purges en commençant par les plus éloignées</li>
                </ul>
              </li>
              <li>Volume de rinçage : Minimum 3 fois le volume de chaque réseau</li>
              <li>Contrôle final : Test d'absence de résidus et de mousse REMISE EN PRESSION</li>
              <li>Remplissage complet du circuit à la pression nominale</li>
              <li>Purge de l'air résiduel sur tous les émetteurs</li>
              <li>Vérification de l'absence de fuites</li>
            </ul>
            <p class="s11">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
            <p class="s12">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>
            <ul>
              <li>Localisation des filtres à boues existants sur les circuits de retour</li>
              <li>Démontage et nettoyage des filtres en place</li>
              <li>Contrôle d'efficacité : Vérification du maillage et de l'état général INSTALLATION DE FILTRES
                COMPLEMENTAIRES (SI NECESSAIRE)</li>
              <li>Positionnement : Sur chaque circuit de retour au générateur</li>
              <li>Type de filtre : Filtre magnétique séparateur de boues haute performance</li>
              <li>Raccordement : Avec vannes d'isolement pour maintenance future</li>
              <li>Accessibilité : Installation permettant un entretien facile INJECTION DU REACTIF INHIBITEUR SENTINEL
                X100</li>
              <li>Dosage : 1% du volume d'eau de l'installation</li>
              <li>Méthode d'injection : Via point d'injection dédié</li>
              <li>Circulation : Mise en route de la circulation pendant 30 minutes minimum</li>
              <li>Homogénéisation : Vérification de la répartition uniforme du produit CONTROLES FINAUX ET MISE EN
                SERVICE</li>
              <li>Test de fonctionnement complet de l'installation</li>
              <li>Relevé des paramètres : Température, pression, débit</li>
              <li>Réglages : Ajustement des organes de régulation</li>
              <li>Formation : Explication du fonctionnement au personnel technique</li>
              <li>Documentation : Remise du certificat de désembouage et planning de maintenance</li>
            </ul>
            <p class="s13">PRODUITS UTILISÉS</p>
            <p class="s11">SENTINEL X800 DÉSEMBOUANT</p>
            <p class="s12">Sentinel X800 Désembouant pour nettoyage d'un réseau de chauffage, Sentinel X800 élimine tous
              débris, particules de corrosion et dépôts de calcaire des installations de chauffage central.</p>
            <ul>
              <li>Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau</li>
              <li>Aspect : Liquide clair, incolore à jaune pâle</li>
              <li>Odeur : Légère</li>
              <li>Densité (25°C) : 1,06 g/ml</li>
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
      </table>
    </div>
  </div>
  <!-- <div class="page-break"></div> -->

  <!-- Page 4 -->
  <div class="page">

    <div class="page-content">
      <table>
        <tr>
          <td class="table-header">
            <p class="s10">DETAIL</p>
          </td>
          <td class="table-header">
            <p class="s10">QUANTITE</p>
          </td>
          <td class="table-header">
            <p class="s10">PU HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TOTAL HT</p>
          </td>
          <td class="table-header">
            <p class="s10">TVA</p>
          </td>
        </tr>
        <tr>
          <td>
            <p class="s11">SENTINEL X100 INHIBITEUR</p>
            <p class="s12">Sentinel X100 Inhibiteur pour protection du réseau de chauffage avec solution aqueuse
              d'agents inhibiteurs de corrosion et anti-tartre.</p>
            <ul>
              <li>Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100 litres d'eau</li>
              <li>Aspect : Liquide clair, incolore à jaune pâle</li>
              <li>Densité (20°C) : 1,10 g/ml</li>
              <li>pH (concentré) : Environ 6,4</li>
              <li>Point de congélation : -2,5°C</li>
              <li>Agréé par le ministère de la Santé</li>
            </ul>
            <p class="s13">MATÉRIEL ET ENTREPRISE</p>
            <p class="s12">Matériel(s) fourni(s) et mis en place par <b>ENERGIE NOVA</b>, 60 RUE FRANCOIS IER, 75008
              PARIS ,SIRET 93348779500017, Code APE 7112B.</p>
            <p class="s12">Représentée par <b>M. Tamoyan Hamlet</b> <a href="mailto:direction@energie-nova.com">,
                0767847049 direction@energie-nova.com</a></p>
            <p class="s12">Qualification <b>Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</b></p>
            <p class="s12">RC Décennale <b>W4737408 contrat n° 25076156863</b></p>
            <p class="s14">Durée totale de l'intervention <span class="s12">: 1 à 2 jours selon la complexité</span></p>
            <p class="s14">Garantie <span class="s12">: 2 ans sur l'intervention de désembouage</span></p>
            <p class="s14">Suivi <span class="s12">: Contrôle recommandé à 6 mois puis annuellement</span></p>
          </td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </table>
      <br>
      <p class="s2">12 259,80</p>
      <h3>14 711,76 €</h3>
      <h3>2 451,96</h3>
      <h3>12 259,80</h3>
      <br>
      <h2>CONDITIONS DE PAIEMENT</h2>
      <br>
      <p>« Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de EBS
        ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous forme de prime,
        directement ou via son (ses) mandataire(s), sous réserve de l'engagement de fournir exclusivement à EBS Energie
        les documents nécessaires à la valorisation des opérations au titre du dispositif des Certificats d'Économies
        d'Énergie et sous réserve de la validation de l'éligibilité du dossier par EBS ENERGIE puis par l'autorité
        administrative compétente.</p>
      <p>Le montant de cette contribution financière, hors champ d'application de la TVA, est susceptible de varier en
        fonction des travaux effectivement réalisés et du volume des CEE attribués à l'opération et est estimé à 12
        259,80 euros ».</p>
      <br>
      <h2>Gestion des déchets</h2>
      <br>
      <p>Gestion, évacuation et traitements des déchets de chantier comprenant la main d'œuvre liée à la dépose et au
        tri, le transport des déchets de chantiers vers un ou plusieurs points de collecte et coûts de traitement.</p>
      <h3>MONTANT TOTAL €</h3>
      <h3>HT TVA €</h3>
      <h1>MONTANT TOTAL TTC</h1>
      <p class="s2">PRIME CEE - €</p>
      <br>
      <h3>2 451,96 €</h3>
      <h1>RESTE A CHARGE</h1>
    </div>
  </div>

  <!-- Page 5 -->
  <div class="page">

    <div class="page-content">
      <div class="signature-section">
        <p class="s2">En acceptant le présent devis, j'atteste sur l'honneur :</p>
        <br>
        <ul>
          <li>Que le bâtiment est existant depuis plus de deux ans.</li>
          <li>Ne pas avoir bénéficier de primes CEE pour la fiche N°BAR-SE-109 désembouage</li>
        </ul>
        <br>
        <p class="s2">Date, Signature et cachet du client précédés des mentions manuscrites suivantes :</p>
        <br>

        <div class="avoid-break">
          <ol>
            <li>Lu et approuvé :</li>
            <li>Bon pour accord :</li>
            <li>Devis reçu avant l'exécution des travaux :</li>
          </ol>
          <br>
          <p class="s3">Nom : <span class="s2">Offel De Villaucourt</span></p>
          <br>
          <p class="s3">Prénom : <span class="s2">Charles</span></p>
          <br>
          <p class="s3">Fonction : <span class="s2">Gérant</span></p>
          <br>
          <ol start="4">
            <li>Date :</li>
            <li>Signature :</li>
          </ol>
          <br>
          <p class="s2">Le client reconnaît avoir pris connaissance et accepté les conditions générales de vente.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="pdf-footer">
    Page <span class="page-number"></span>
  </div>

</body>

</html>