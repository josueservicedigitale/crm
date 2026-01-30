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
.page.last-page {
  page-break-after: auto;
}

.page.final-page {
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
}



.pdf-header {
  top: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 180mm;   /* 210mm (A4) - 15mm - 15mm ≈ zone centrale */
  height: 25mm;
}

.pdf-footer {
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 180mm;
  text-align: right;
  font-size: 8pt;
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



    /* Blocs gris neutres (structure seulement) */
.gray-block {
  background-color: #f0f0f0; /* même gris que ton bloc bénéficiaire */
  padding: 8px 10px;
  margin-bottom: 6mm;
  border-radius: 3px;
}

/* Titres de bloc → utilisent TES classes existantes */
.block-title {
  margin-bottom: 3mm;
}

/* Tableaux financiers sans changer ton style global */
.invoice-table td,
.invoice-table th,
.summary-table td {
  border: 1px solid #003366; /* identique à tes tableaux */
  padding: 6px;
}

/* Zone récapitulatif final */
.total-summary {
  background-color: #e6e6e6;
  padding: 6px;
  border: 1px solid #003366;
}

/* Alignement montants */
.amount {
  text-align: right;
}

/* Total final plus visible SANS changer couleur */
.final-total td {
  font-weight: bold;
}

/* Signatures */
.signature-line {
  border-bottom: 1px solid #000;
  height: 18px;
  margin: 8px 0;
}

.signature-box {
  border: 1px solid #000;
  height: 45px;
  width: 160px;
}

/* Note importante */
.important-note {
  margin-top: 8mm;
  text-align: center;
}

/* Empêche coupure PDF */
.avoid-break {
  page-break-inside: avoid;
}

  </style>
</head>

<body>

  <div class="pdf-header">
    <table width="70%">
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
      <!-- Bloc Bénéficiaire / Fournisseur -->
      <table class="beneficiary-supplier-table"
        style="width:100%; background-color:#f0f0f0; table-layout: fixed; border-collapse: collapse;">
        <tr>
          <!-- Bénéficiaire -->
          <td class="beneficiary-column" valign="top" style="width:49%; padding:10px 15px; text-align:left;">
            <strong style="color:#036; font-size:9pt; display:block; margin-bottom:4px;">BENEFICIAIRE</strong>
            {{ $document->society }}<br>
            {{ $document->activity }}<br>
            SIRET : {{ $document->reference }}<br>
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
      <h3>SITE DES TRAVAUX : <span class="s2">{{ $document->adresse_travaux }}</span></h3>
      <p class="s2"><span class="s5">NUMÉRO IMMATRICULATION DE COPROPRIÉTÉ</span> <span class="s6">:</span> {{ $document->numero_immatriculation }}
        <b>-</b> {{ $document->nom_residence }}
      </p>
      <p class="s5">ZONE CLIMATIQUE <span class="s2">: {{ $document->zone_climatique }}</span></p>
      <p class="s5">PARCELLE CADASTRALE :</p>
      <p class="s5">{{ $document->parcelle_1 }} <span class="s2">Parcelle</span> <span class="s7">{{ $document->parcelle_2 }}</span></p>
      <h3>{{ $document->parcelle_3 }} <span class="s8">{{ $document->parcelle_4 }}</span></h3>
      <br>
      <p class="s5">DATE PREVISIONNELLE DES TRAVAUX <span class="s9">:</span> <span class="s2">{{ $document->dates_previsionnelles }}</span></p>
      <h3>SECTEUR : <span class="s2">Résidentiel</span></h3>
      <h3>NOMBRE DE BATIMENTS : <span class="s2">{{ $document->nombre_batiments }} Batiments</span></h3>
      <h3>DETAILS : <span class="s2">{{ $document->details_batiments }}</span></h3>
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
            <p class="s12">{{ number_format($document->montant_ht, 2, ',', ' ') }}</p>
          </td>
          <td bgcolor="#FEF3C1">
            <p class="s12">{{ number_format($document->montant_ht, 2, ',', ' ') }}</p>
          </td>
          <td>
            <p class="s12">20 %</p>
          </td>
        </tr>
      </table>
    </div>
  </div>

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
              <li>Puissance nominale de la chaudière : {{ $document->puissance_chaudiere }} kW</li>
              <li>Nombre de logements concernés : {{ $document->nombre_logements }}</li>
              <li>Nombre d'émetteurs désemboués : {{ $document->nombre_emetteurs }}</li>
              <li>Nature du réseau : Acier</li>
              <li>Volume total du circuit d'eau: {{ $document->volume_circuit }} L</li>
              <li>Zone climatique : {{ $document->zone_climatique }}</li>
              <li>Filtres : {{ $document->nombre_filtres }}</li>
              <li>KWH CUMAC : {{ $document->wh_cumac }}</li>
              <li>PRIME CEE : {{ number_format($document->prime_cee, 2, ',', ' ') }} €</li>
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

  <!-- Page 3 -->
  <div class="page">
    <div class="page-content">
      <table>
        <thead>
          <tr>
            <th class="table-header">DÉTAIL</th>
            <th class="table-header">QUANTITÉ</th>
            <th class="table-header">PU HT</th>
            <th class="table-header">TOTAL HT</th>
            <th class="table-header">TVA</th>
          </tr>
        </thead>
        <tbody>
          <!-- Article 1 : Désembouage Chimique -->
          <tr>
            <td>
              <p><strong>1. DÉSEMBOUAGE CHIMIQUE DU RÉSEAU</strong></p>
              <p class="s12">INJECTION DU PRODUIT SENTINEL X800</p>
              <ul class="s12">
                <li>Dosage : 1% du volume total du circuit</li>
                <li>Circulation du produit pendant 6 à 8 heures</li>
                <li>Contrôle du pH et de l'activité du désembouant</li>
              </ul>
            </td>
            <td>1 Intervention</td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Article 2 : Rinçage Général -->
          <tr>
            <td>
              <p><strong>2. RINÇAGE DES CIRCUITS À L'EAU CLAIRE</strong></p>
              <p class="s12">RINÇAGE GÉNÉRAL</p>
              <ul class="s12">
                <li>Évacuation complète du produit désembouant</li>
                <li>Remplissage progressif à l'eau claire</li>
                <li>Circulation intensive pendant 2 heures minimum</li>
                <li>Contrôle qualité : Vérification de la limpidité</li>
              </ul>
            </td>
            <td>1 Intervention</td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Article 3 : Rinçage Réseau par Réseau -->
          <tr>
            <td>
              <p class="s12">RINÇAGE RÉSEAU PAR RÉSEAU</p>
              <ul class="s12">
                <li>Isolation et rinçage individuel de chaque réseau</li>
                <li>Volume de rinçage : Min. 3x le volume de chaque réseau</li>
                <li>Contrôle final : Test d'absence de résidus</li>
              </ul>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Article 4 : Remise en Pression -->
          <tr>
            <td>
              <p class="s12">REMISE EN PRESSION</p>
              <ul class="s12">
                <li>Remplissage complet à la pression nominale</li>
                <li>Purge de l'air résiduel sur tous les émetteurs</li>
                <li>Vérification de l'absence de fuites</li>
              </ul>
            </td>
            <td>1 Intervention</td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Article 5 : Injection Inhibiteur -->
          <tr>
            <td>
              <p><strong>3. INJECTION INHIBITEUR DE CORROSION SENTINEL X100</strong></p>
              <ul class="s12">
                <li>Dosage : 1% du volume d'eau de l'installation</li>
                <li>Injection via point dédié et circulation pour homogénéisation</li>
                <li>Produit fourni (voir détail ci-dessous)</li>
              </ul>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Article 6 : Produit Consommable -->
          <tr>
            <td>
              <p class="s13">PRODUIT INHIBITEUR SENTINEL X100</p>
              <p class="s12">Inhibiteur de corrosion pour chauffage central. Protège les métaux (acier, fonte, aluminium, cuivre).</p>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td>20%</td>
          </tr>

          <!-- Ligne pour Totaux -->
          <tr class="total-row">
            <td colspan="3"></td>
            <td><strong>TOTAL GÉNÉRAL HT</strong></td>
            <td><strong>{{ number_format($document->montant_ht, 2, ',', ' ') }} €</strong></td>
          </tr>
          <tr class="total-row">
            <td colspan="3"></td>
            <td><strong>TVA (20%)</strong></td>
            <td><strong>{{ number_format($document->montant_tva, 2, ',', ' ') }} €</strong></td>
          </tr>
          <tr class="total-row">
            <td colspan="3"></td>
            <td><strong>TOTAL TTC</strong></td>
            <td><strong>{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</strong></td>
          </tr>
        </tbody>
      </table>

      <!-- Section descriptive détaillée -->
    
    </div>
  </div>


  <div class="page">
    <div class="page-content">
      </table>

    <div class="technical-description">
        <p class="s11">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
        <p class="s12">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>
        <ul>
          <li>Localisation des filtres à boues existants sur les circuits de retour</li>
          <li>Démontage et nettoyage des filtres en place</li>
          <li>Contrôle d'efficacité : Vérification du maillage et de l'état général</li>
        </ul>
        <p class="s12">INSTALLATION DE FILTRES COMPLEMENTAIRES (SI NECESSAIRE)</p>
        <ul>
          <li>Positionnement : Sur chaque circuit de retour au générateur</li>
          <li>Type de filtre : Filtre magnétique séparateur de boues haute performance</li>
          <li>Raccordement : Avec vannes d'isolement pour maintenance future</li>
          <li>Accessibilité : Installation permettant un entretien facile</li>
        </ul>
        <p class="s12">INJECTION DU REACTIF INHIBITEUR SENTINEL X100</p>
        <ul>
          <li>Dosage : 1% du volume d'eau de l'installation</li>
          <li>Méthode d'injection : Via point d'injection dédié</li>
          <li>Circulation : Mise en route de la circulation pendant 30 minutes minimum</li>
          <li>Homogénéisation : Vérification de la répartition uniforme du produit</li>
        </ul>
        <p class="s12">CONTROLES FINAUX ET MISE EN SERVICE</p>
        <ul>
          <li>Test de fonctionnement complet de l'installation</li>
          <li>Relevé des paramètres : Température, pression, débit</li>
          <li>Réglages : Ajustement des organes de régulation</li>
          <li>Formation : Explication du fonctionnement au personnel technique</li>
          <li>Documentation : Remise du certificat de désembouage et planning de maintenance</li>
        </ul>
      </div>
     </table>
    </div>
  </div>
  <!-- Page 4 -->
  <div class="page">
    <div class="page-content">
      <div class="gray-block avoid-break">
        <p class="s13">FOURNITURES ET FRAIS ANNEXES</p>

        <table class="invoice-table">
          <tr>
            <td class="table-header"><p class="s10">DÉTAIL</p></td>
            <td class="table-header"><p class="s10">QTÉ</p></td>
            <td class="table-header"><p class="s10">PU HT</p></td>
            <td class="table-header"><p class="s10">TOTAL HT</p></td>
            <td class="table-header"><p class="s10">TVA</p></td>
          </tr>

          <tr>
            <td>
              <p class="s11">INHIBITEUR DE CORROSION SENTINEL X100</p>
              <p class="s12">Solution inhibitrice pour protection du réseau de chauffage.</p>
            </td>
            <td><p class="s12">15 L</p></td>
            <td><p class="s12">45,00 €</p></td>
            <td><p class="s12">675,00 €</p></td>
            <td><p class="s12">20%</p></td>
          </tr>

          <tr>
            <td><p class="s11">FRAIS DE DÉPLACEMENT ET LOGISTIQUE</p></td>
            <td><p class="s12">1</p></td>
            <td><p class="s12">350,00 €</p></td>
            <td><p class="s12">350,00 €</p></td>
            <td><p class="s12">20%</p></td>
          </tr>

          <tr>
            <td colspan="3"></td>
            <td><p class="s11">SOUS-TOTAL HT</p></td>
            <td><p class="s11">{{ number_format($document->montant_ht, 2, ',', ' ') }} €</p></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td><p class="s11">TVA (20%)</p></td>
            <td><p class="s11">{{ number_format($document->montant_tva, 2, ',', ' ') }} €</p></td>
          </tr>
          <tr>
            <td colspan="3"></td>
            <td><p class="s13">TOTAL TTC</p></td>
            <td><p class="s13">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</p></td>
          </tr>
        </table>
      </div>

      <div class="gray-block avoid-break">
        <p class="s13">ENTREPRISE & GARANTIES</p>
        <p class="s12">Matériel fourni par <span class="s11">ENERGIE NOVA</span></p>
        <p class="s12">SIRET : 933 487 795 00017</p>
        <p class="s12">RC Décennale : Contrat n° 25076156863</p>
        <p class="s12">Garantie : 2 ans — Suivi recommandé annuel</p>
      </div>

      <div class="gray-block avoid-break">
        <p class="s13">PRIME CEE</p>
        <p class="s12">Prime versée par EBS ENERGIE sous réserve de validation.</p>
        <p class="s12">Montant estimé : <span class="s11">{{ number_format($document->prime_cee, 2, ',', ' ') }} €</span></p>
      </div>

      <div class="gray-block avoid-break">
        <p class="s13">GESTION DES DÉCHETS</p>
        <p class="s12">Tri, évacuation, transport et traitement des déchets de chantier.</p>
      </div>

      <div class="total-summary avoid-break">
        <table class="summary-table">
          <tr>
            <td><p class="s11">MONTANT TOTAL TTC</p></td>
            <td class="amount"><p class="s11">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</p></td>
          </tr>
          <tr>
            <td><p class="s12">PRIME CEE</p></td>
            <td class="amount"><p class="s12">- {{ number_format($document->prime_cee, 2, ',', ' ') }} €</p></td>
          </tr>
          <tr>
            <td><p class="s13">RESTE À CHARGE</p></td>
            <td class="amount"><p class="s13">{{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</p></td>
          </tr>
        </table>
      </div>
    </div>
  </div>

  <!-- Page 5 -->
  <div class="page last-page">
    <div class="page-content">
      <div class="gray-block avoid-break">
        <p class="s13">ATTESTATIONS DU CLIENT</p>
        <ul class="s12">
          <li>Bâtiment achevé depuis plus de 2 ans</li>
          <li>Aucune prime CEE BAR-SE-109 déjà perçue</li>
        </ul>
        <p class="s12">Mention manuscrite : <span class="s11">Lu et approuvé, bon pour accord</span></p>
      </div>

      <div class="gray-block avoid-break">
        <p class="s13">ACCEPTATION DU DEVIS — CLIENT</p>
        <p class="s12">Nom : OFFEL DE VILLAUCOURT</p>
        <p class="s12">Prénom : Charles</p>
        <p class="s12">Fonction : Gérant</p>
        <br><br>
        <p class="s12">Date : ____ / ____ / ________</p>
        <br><br>
        <p class="s12">Signature :</p>
        <div class="signature-line"></div>
      </div>

      <div class="gray-block avoid-break">
        <p class="s13">POUR LE PRESTATAIRE — ENERGIE NOVA</p>
        <p class="s12">Représenté par M. Tamoyan Hamlet</p>
        <p class="s12">SIRET : 933 487 795 00017</p>
        <br><br>
        <p class="s12">Date : ____ / ____ / ________</p>
        <br><br>
        <p class="s12">Signature :</p>
        <div class="signature-line"></div>
      </div>

      <p class="important-note s12">
        Le client accepte les conditions générales de vente — Validité du devis : 30 jours à compter du {{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}
      </p>
    </div>
  </div>

  <!-- Footer pour toutes les pages -->
  <div class="pdf-footer">
    Page <span class="page-number"></span> / <span class="total-pages"></span>
  </div>
</body>

</html>
