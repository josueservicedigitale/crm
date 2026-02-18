<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Facture - ENERGIENOVA</title>

  <style>
    /* ===========================
       DOMPDF SAFE (A4) — 3 PAGES
       =========================== */
    @page { size: A4; margin: 18mm 15mm 16mm 15mm; }

    :root{
      --blue:#0b3b5b;     /* bandeau */
      --blue2:#0a3550;    /* variantes */
      --green:#62b14f;    /* ENERGIENOVA */
      --line:#5a86a6;     /* traits tableau */
      --frame:180mm;      /* 210 - 15 - 15 */
      --text:#0b0b0b;
    }

    *{ margin:0; padding:0; box-sizing:border-box; }
    html, body{ font-family: Arial, Helvetica, sans-serif; font-size: 9pt; color:var(--text); background:#fff; }

    .page{ page-break-after: always; }
    .page:last-child{ page-break-after: auto; }

    /* cadre imprimable garanti */
    .page-content{
      width: var(--frame);
      margin: 10mm auto;
    }

    /* anti débordements */
    table{ width:100%; border-collapse: collapse; table-layout: fixed; }
    img{ max-width:100%; height:auto; }
    td, th, p, li, div{
      word-break: break-word;
      overflow-wrap: anywhere;
    }

    /* ===========================
       HEADER (logo + bandeau ref/date)
       =========================== */
    .head{
      margin-bottom: 6mm;
    }

    .brand-row{
      width:100%;
      margin-bottom: 3mm;
    }
    .brand-row td{ vertical-align: middle; }

    .logoBox{
      width: 28mm;
    }
    .logoBox img{
      width: 22mm;
      height: 22mm;
      object-fit: contain;
      display:block;
    }
    .brandName{
      font-weight: 800;
      font-size: 18pt;
      color: var(--green);
      letter-spacing: .5px;
    }

    .refbar{
      border:1px solid var(--blue);
    }
    .refbar td{
      padding: 6px 8px;
      border-right: 1px solid var(--blue);
      font-weight: 700;
      color:#fff;
      background: var(--blue);
      background-color: #0c5b8f;
      text-transform: uppercase;
      font-size: 9pt;
    }
    .refbar td.value{
      background:#fff;
      color:#0b0b0b;
      text-transform:none;
      font-weight: 700;
      border-right: 0;
    }
    .refbar td.value.right{
      text-align:center;
    }

    /* ===========================
       BLOCS PAGE 1
       =========================== */
    .twoCols{
      margin-top: 4mm;
      margin-bottom: 5mm;
    }
    .twoCols td{
      vertical-align: top;
      font-size: 7.7pt;
      line-height: 1.35;
      padding-right: 8mm;
    }
    .twoCols td:last-child{ padding-right:0; }
    .labelSmall{
      color: var(--blue);
      font-weight: 800;
      text-transform: uppercase;
      font-size: 7.4pt;
      margin-bottom: 2mm;
      display:block;
    }
    .strong{ font-weight: 800; }
    .muted{ color:#3a3a3a; }

    .metaGrid{
      width:100%;
      margin: 2mm 0 6mm 0;
      font-size: 7.6pt;
      line-height: 1.4;
    }
    .metaGrid td{
      border:none;
      padding: 1mm 0;
      vertical-align: top;
    }
    .metaGrid .k{
      width: 26mm;
      color: var(--blue);
      font-weight: 800;
      text-transform: uppercase;
    }

    .box{
      border:1px solid #a9c0cf;
      padding: 6px 8px;
      margin-top: 3mm;
      font-size: 7.7pt;
      line-height: 1.35;
    }
    .boxTitle{
      color: var(--blue);
      font-weight: 800;
      text-transform: uppercase;
      font-size: 7.8pt;
      margin-bottom: 2mm;
    }

    /* ===========================
       TABLE “DETAIL / QUANTITE / …”
       =========================== */
    .mainTable{
      margin-top: 6mm;
      border:1px solid #a9c0cf;
    }
    .mainTable th{
      background: var(--blue);
      background-color: #0c5b8f;
      color:#fff;
      padding: 6px 6px;
      text-transform: uppercase;
      font-weight: 800;
      font-size: 8pt;
      border-right: 1px solid var(--blue);
    }
    .mainTable th:last-child{ border-right: 0; }

    .mainTable td{
      border-top: 1px solid #a9c0cf;
      border-right: 1px solid #a9c0cf;
      padding: 6px 7px;
      vertical-align: top;
      font-size: 7.6pt;
      line-height: 1.25;
      height: 30mm; /* laisse le grand vide comme sur capture */
    }
    .mainTable td:last-child{ border-right:0; }

    .colDetail{ width: 56%; }
    .colQte{ width: 10%; text-align:center; }
    .colPU{ width: 12%; text-align:center; }
    .colTHT{ width: 12%; text-align:center; }
    .colTVA{ width: 10%; text-align:center; }

    .detailTitle{
      color: var(--blue);
      font-weight: 800;
      text-transform: uppercase;
      font-size: 7.8pt;
      margin-bottom: 2mm;
    }

    ul{ margin-left: 14px; margin-top: 2mm; }
    li{ margin: 0.6mm 0; }

    /* ===========================
       PAGE 2 table (mêmes colonnes)
       =========================== */
    .mainTable.p2 td{ height: 150mm; } /* grande zone texte */

    .lines{
      margin-top: 6mm;
    }
    .lines .item{
      margin-top: 6mm;
    }
    .lines .n{
      font-weight: 800;
      margin-right: 2mm;
    }

    .note{
      margin-top: 6mm;
      font-size: 7.2pt;
      line-height: 1.35;
    }
    .subBlockTitle{
      margin-top: 10mm;
      font-weight: 800;
      text-transform: uppercase;
      font-size: 7.6pt;
    }

    /* ===========================
       PAGE 3: termes + totaux
       =========================== */
    .p3grid{
      margin-top: 8mm;
    }
    .p3grid td{ vertical-align: top; }

    .termsTitle{
      font-size: 7.8pt;
      color:#1d1d1d;
      margin-bottom: 2mm;
    }
    .termsBox{
      border:1px solid #b8c9d6;
      padding: 7px 8px;
      width: 88mm;
      font-size: 7.2pt;
      line-height: 1.35;
    }

    .totalsBox{
      width: 62mm;
      margin-left: auto;
      font-size: 7.8pt;
    }
    .totalsBox table{ margin-top: 12mm; }
    .totalsBox td{
      border:none;
      padding: 1.3mm 0;
      font-weight: 800;
    }
    .totalsBox .k{ color: var(--blue); text-transform: uppercase; }
    .totalsBox .v{ text-align:right; width: 28mm; }
    .totalsBox .bigK{ color: var(--blue); text-transform: uppercase; padding-top: 2.5mm; }
    .totalsBox .bigV{ text-align:right; padding-top: 2.5mm; }
    .totalsBox .restK{ color: var(--blue); text-transform: uppercase; padding-top: 3mm; }
    .totalsBox .restV{ text-align:right; padding-top: 3mm; }

    .signLine{
      margin-top: 30mm;
      font-size: 8pt;
    }

    /* ===========================
       FOOTER (bas de page)
       =========================== */
   .footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 7pt;
    color: #2b2b2b;
}

    .pageno{
      margin-top: 1.5mm;
      text-align:right;
      font-size: 7pt;
      color:#2b2b2b;
    }
  </style>
</head>

<body>

  <!-- ===================== PAGE 1 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="head">
        <table class="brand-row">
          <tr>
            <td class="logoBox">
              <img src="{{ public_path('assets/img/renova/Devis_files/Image_002.png') }}" alt="Logo">
            </td>
          
          </tr>
        </table>

        <!-- Bandeau ref/date (look capture) -->
        <table class="refbar">
          <tr>
            <td style="width:26mm;">REF FACTURE</td>
            <td class="value right" style="width:100mm;">{{ $document->reference_facture }}</td>
          </tr>
          <tr>
            <td>DATE FACTURE</td>
            <td class="value right">{{ \Carbon\Carbon::parse($document->date_facture)->format('d/m/Y') }}</td>
          </tr>
        </table>
      </div>

      <!-- bloc adresses (comme capture) -->
      <table class="twoCols">
        <tr>
          <td style="width:50%;">
            <span class="labelSmall">ENERGIE NOVA</span>
            60 Rue FRANCOIS 1 ER<br>
            75008 PARIS<br>
            <span class="muted">SIRET</span> 933 487 795 00017<br><br>

            Représenté par <span class="strong">M. TAMOYAN Hamlet</span>, en qualité de Président<br>
            07 67 87 04 09 &nbsp; direction@energie-nova.com<br><br>

            RC Décennale ERGO contrat n° {{ $document->rc_contrat ?? '25076156863' }}
          </td>

          <td style="width:50%;">
            <span class="labelSmall">BÉNÉFICIAIRE</span>
            <span class="strong">{{ $document->society }}</span><br>
            {{ $document->adresse_beneficiaire ?? '' }}<br>
            {{ $document->ville_beneficiaire ?? '' }}<br><br>

            <table class="metaGrid">
              <tr><td class="k">SIRET</td><td>{{ $document->reference }}</td></tr>
              <tr><td class="k">MAIL</td><td>{{ $document->email_beneficiaire ?? '' }}</td></tr>
              <tr><td class="k">TEL</td><td>{{ $document->tel_beneficiaire ?? '' }}</td></tr>
              <tr><td class="k">REPRÉSENTÉ PAR</td><td>{{ $document->representant ?? '' }}</td></tr>
              <tr><td class="k">FONCTION</td><td>{{ $document->fonction ?? '' }}</td></tr>
            </table>
          </td>
        </tr>
      </table>

      <!-- OBJET -->
      <div style="font-size:7.6pt; line-height:1.35; margin-top:1mm;">
        <span class="strong" style="color:var(--blue); text-transform:uppercase;">OBJET :</span>
        Opération entrant dans le dispositif de prime C.E.E. (Certificat d’Economie d’Energie),
        conforme aux recommandations de la fiche technique N°BAR-SE-104 de C.E.E. décrites par le ministère de la Transition énergétique.
      </div>

      <!-- DESIGNATION BOX -->
      <div class="box">
        <div class="boxTitle">DESIGNATION</div>

        Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude, opération entrant dans le dispositif de prime C.E.E.
        (Certificat d’Economie d’Energie), conforme aux recommandations de la fiche BAR-SE-104.
        <br><br>

        <div><span class="strong" style="color:var(--blue); text-transform:uppercase;">SITE DES TRAVAUX :</span>
          {{ $document->adresse_travaux }}
        </div>

        <div><span class="strong" style="color:var(--blue); text-transform:uppercase;">NUMÉRO IMMATRICULATION DE COPROPRIÉTÉ :</span>
          {{ $document->numero_immatriculation ?? '' }} &nbsp;-&nbsp; {{ $document->nom_residence ?? '' }}
        </div>

        <div><span class="strong" style="color:var(--blue); text-transform:uppercase;">PARCELLE CADASTRALE :</span></div>
        <div style="margin-top:1mm;">
          1&nbsp;&nbsp;Parcelle {{ $document->parcelle_1 ?? '' }} Feuille {{ $document->parcelle_2 ?? '' }}
        </div>

        <div style="margin-top:3mm;">
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">DATE DES TRAVAUX :</span> {{ $document->date_travaux ?? '' }}<br>
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">DATE DE DÉSEMBOUAGE :</span> {{ $document->dates_previsionnelles ?? '' }}<br>
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">CONTACT SUR SITE :</span> {{ $document->contact_site ?? '' }}<br>
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">SECTEUR :</span> Résidentiel<br>
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">NOMBRE DE BÂTIMENTS :</span> {{ $document->nombre_batiments ?? '' }}<br>
          <span class="strong" style="color:var(--blue); text-transform:uppercase;">DÉTAILS :</span> {{ $document->details_batiments ?? '' }}
        </div>
      </div>

      <!-- TABLE -->
      <table class="mainTable">
        <thead>
          <tr>
            <th class="colDetail">DETAIL</th>
            <th class="colQte">QUANTITE</th>
            <th class="colPU">PU HT</th>
            <th class="colTHT">TOTAL HT</th>
            <th class="colTVA">TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <div class="detailTitle">CARACTÉRISTIQUES DE L’INSTALLATION</div>
              Type de chauffage : Chauffage collectif à combustible<br>
              Zone climatique : H1<br>
              Nombre de logements : {{ $document->nombre_logements ?? '' }}<br>
              Installation existante depuis plus de 2 ans : OUI
              <br><br>
              <ul>
                <li><span class="strong" style="color:var(--blue);">KWH CUMAC :</span> {{ $document->wh_cumac ?? '' }}</li>
                <li><span class="strong" style="color:var(--blue);">PRIME CEE :</span> {{ number_format($document->prime_cee ?? 0, 2, ',', ' ') }} €</li>
              </ul>
            </td>
            <td></td><td></td><td></td><td></td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 1/3</div>

    </div>
  </div>

  <!-- ===================== PAGE 2 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="head">
        <table class="brand-row">
          <tr>
            <td class="logoBox">
              <img src="{{ public_path('assets/img/renova/Devis_files/Image_002.png') }}" alt="Logo">
            </td>
        
          </tr>
        </table>

        <table class="refbar">
          <tr>
            <td style="width:26mm;">REF FACTURE</td>
            <td class="value right" style="width:100mm;">{{ $document->reference_facture }}</td>
          </tr>
          <tr>
            <td>DATE FACTURE</td>
            <td class="value right">{{ \Carbon\Carbon::parse($document->date_facture)->format('d/m/Y') }}</td>
          </tr>
        </table>
      </div>

      <table class="mainTable p2">
        <thead>
          <tr>
            <th class="colDetail">DETAIL</th>
            <th class="colQte">QUANTITE</th>
            <th class="colPU">PU HT</th>
            <th class="colTHT">Total HT</th>
            <th class="colTVA">TVA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              Matériel(s) fourni(s) et mis en place par notre société {{ $document->society ?? 'RABATHERM HECS' }},<br><br>
              Représentée par : {{ $document->representant ?? '' }}<br>
              SIRET : {{ $document->siret_beneficiaire ?? '' }}<br><br>

              <div class="lines">
                <div class="item">
                  <span class="n">1 -</span>
                  Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude,
                  destiné à assurer une température uniforme dans tous les locaux
                </div>

                <div class="item">
                  <span class="n">2 -</span>
                  Mise en place matériel d’équilibrage :
                </div>

                <ul>
                  <li>Relevé sur site de l’installation</li>
                  <li>Réalisation d’un plan du sous-sol des PDC</li>
                  <li>Réalisation d’un synoptique des colonnes</li>
                  <li>Réalisation d’une note de calcul des puissances, débits et réglages théoriques par logement</li>
                  <li>Réglage du point de fonctionnement de la pompe chauffage</li>
                  <li>Réalisation d’une mesure de débit sur les PDC et antennes</li>
                  <li>Un tableau d’enregistrement des températures moyennes sur un échantillon des logements, après équilibrage</li>
                  <li>L’écart de température entre l’appartement le plus chauffé et le moins chauffé doit être strictement inférieur à 2°C</li>
                </ul>

                <div class="note">
                  Note : Les quantités sont données à titre indicatif. Il appartient au maître d’ouvrage du présent lot de les valider.
                  Les prix des appareillages comprennent la fourniture, fixation et raccordement.
                  Le marché est passé à prix global et forfaitaire.
                </div>

                <div class="subBlockTitle">COMPRIS DANS LES TRAVAUX :</div>
                <ul>
                  <li>La dépose et l’enlèvement de votre ancien appareil</li>
                  <li>La protection et le nettoyage du chantier</li>
                  <li>Le remplissage et la purge de votre installation</li>
                </ul>
              </div>
            </td>

            <td class="colQte" style="text-align:center;">
              <div style="margin-top:38mm;">1</div>
              <div style="margin-top:8mm;">1</div>
            </td>

            <td class="colPU" style="text-align:center;">
              <div style="margin-top:38mm;">{{ number_format($document->pu_1 ?? 0, 2, ',', ' ') }}</div>
              <div style="margin-top:8mm;">{{ number_format($document->pu_2 ?? 0, 2, ',', ' ') }}</div>
            </td>

            <td class="colTHT" style="text-align:center;">
              <div style="margin-top:38mm;">{{ number_format($document->total_1 ?? 0, 2, ',', ' ') }}</div>
              <div style="margin-top:8mm;">{{ number_format($document->total_2 ?? 0, 2, ',', ' ') }}</div>
            </td>

            <td class="colTVA" style="text-align:center;">
              <div style="margin-top:38mm;">{{ $document->tva_rate ?? '5,5' }} %</div>
              <div style="margin-top:8mm;">{{ $document->tva_rate ?? '5,5' }} %</div>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="footer">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 2/3</div>

    </div>
  </div>

  <!-- ===================== PAGE 3 ===================== -->
  <div class="page">
    <div class="page-content">

      <div class="head">
        <table class="brand-row">
          <tr>
            <td class="logoBox">
              <img src="{{ public_path('assets/img/renova/Devis_files/Image_002.png') }}" alt="Logo">
            </td>
          </tr>
        </table>

        <table class="refbar">
          <tr>
            <td style="width:26mm;">REF FACTURE</td>
            <td class="value right" style="width:100mm;">{{ $document->reference_facture }}</td>
          </tr>
          <tr>
            <td>DATE FACTURE</td>
            <td class="value right">{{ \Carbon\Carbon::parse($document->date_facture)->format('d/m/Y') }}</td>
          </tr>
        </table>
      </div>

      <table class="p3grid">
        <tr>
          <td style="width:60%;">
            <div class="termsTitle">Termes et conditions CEE</div>
            <div class="termsBox">
              Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de
              EBS ENERGIE (SIREN 533 331 118), versée dans le cadre de son rôle d’incitation sous forme de prime,
              directement au mandataire, sous réserve de l’engagement de fournir exclusivement à EBS ENERGIE
              les documents nécessaires à la valorisation des opérations au titre du dispositif des CEE.
              <br><br>
              Le montant de cette contribution financière, hors champ d’application de la TVA, est susceptible de varier
              en fonction des travaux effectivement réalisés et du volume des CEE attribués à l’opération et est estimé
              à <span class="strong">{{ number_format($document->prime_cee ?? 0, 2, ',', ' ') }} €</span>.
            </div>
          </td>

          <td style="width:40%;">
            <div class="totalsBox">
              <table>
                <tr>
                  <td class="k">TOTAL HT</td>
                  <td class="v">{{ number_format($document->montant_ht ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                  <td class="k">TVA à {{ $document->tva_rate ?? '5,5' }} %</td>
                  <td class="v">{{ number_format($document->montant_tva ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                  <td class="bigK">MONTANT TOTAL TTC</td>
                  <td class="bigV">{{ number_format($document->montant_ttc ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                  <td class="k">PRIME CEE</td>
                  <td class="v">- {{ number_format($document->prime_cee ?? 0, 2, ',', ' ') }} €</td>
                </tr>
                <tr>
                  <td class="restK">RESTE À CHARGE</td>
                  <td class="restV">{{ number_format($document->reste_a_charge ?? 0, 2, ',', ' ') }} €</td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>

      <div class="signLine">Date et signature du bénéficiaire :</div>

      <div class="footer" style="margin-top: 40mm;">
        ENERGIE NOVA - SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS<br>
        SIRET : 933 487 795 00017 - APE 7112B
      </div>
      <div class="pageno">p. 3/3</div>

    </div>
  </div>

</body>
</html>
