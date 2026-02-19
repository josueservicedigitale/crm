<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Attestation de réalisation d'opération CEE</title>

  <style>
    /* ===================== DOMPDF SAFE ===================== */
    @page { margin: 14mm 14mm; }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    html, body{
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10pt;
      color:#111;
    }

    :root{
      --green:#2ea44f;
      --blue:#1c2f8a;
      --border-green:#86c89a;
      --muted:#666;
    }

    img{ max-width:100%; height:auto; }
    table{ width:100%; border-collapse: collapse; table-layout: fixed; }

    /* ===================== PAGE ===================== */
    .page{
      position: relative;
      page-break-after: always;
      /* IMPORTANT: on réserve de la place pour footer + num page */
      padding-bottom: 24mm;
    }
    .page:last-child{ page-break-after: auto; }

    /* Zone sûre interne */
    .content{ padding: 6mm 6mm 0 6mm; }

    /* ===================== HEADER ===================== */
    .hdr{ padding: 0 6mm; margin-top: 5mm; }
    .hdr-table td{ border:none; vertical-align: top; }

    .logo-left{ width: 60mm; }
    .logo-right{ width: 45mm; text-align:right; }

    .logo-left img, .logo-right img{ height: 18mm; }

    .top-title-box{
      margin-top: 4mm;
      border: 1.5px solid var(--border-green);
      padding: 5mm 6mm;
      text-align: center;
    }
    .top-title-box .t1{ color: var(--green); font-weight: 900; font-size: 12pt; margin-bottom: 2mm; }
    .top-title-box .t2{ color: var(--blue);  font-weight: 900; font-size: 10.5pt; margin-bottom: 1mm; }
    .top-title-box .t3{ color: var(--blue);  font-weight: 900; font-size: 10.5pt; }

    /* ===================== TEXT UTILS ===================== */
    .brand-green{ color: var(--green); font-weight: 800; }
    .title-blue{ color: var(--blue); font-weight: 800; }
    .tiny{ font-size: 7.8pt; }
    .muted{ color: var(--muted); }
    .name{ font-weight: 900; }

    /* ===================== PARTY BLOCK ===================== */
    .party{ margin-top: 5mm; padding: 0 6mm; }
    .party td{ border:none; vertical-align: top; }
    .party .col{ width: 50%; }

    .party h4{ font-size: 10pt; margin-bottom: 2mm; font-weight: 900; }

    .party .kv{
      margin-top: 2mm;
      font-size: 8.6pt;
      line-height: 1.35;
      word-break: break-word;
      overflow-wrap: anywhere;
    }
    .party .kv b{
      color: var(--blue);
      font-weight: 900;
      display: inline-block;
      min-width: 22mm;
    }

 
    /* ===================== SECTIONS ===================== */
    .section{ margin-top: 6mm; padding: 0 6mm; }
    .h-section{ color: var(--blue); font-weight: 900; font-size: 11pt; margin-bottom: 3mm; }
    .h-sub{ color: var(--green); font-weight: 900; font-size: 10.3pt; margin-top: 4mm; margin-bottom: 2mm; }

    /* ===================== GREEN TABLE ===================== */
    .green-table{ border: 1.5px solid var(--border-green); margin-top: 3mm; }
    .green-table td{
      border:none;
      padding: 2.2mm 3mm;
      vertical-align: top;
      font-size: 8.8pt;
      line-height: 1.25;
      word-break: break-word;
      overflow-wrap: anywhere;
    }
    .green-table .k{ width: 40%; color:#333; }
    .green-table .v{ width: 60%; color:#111; }

    /* ===================== BULLETS ===================== */
    ul.bul{ margin-left: 7mm; margin-top: 1.5mm; margin-bottom: 2mm; }
    ul.bul li{ margin: 1.2mm 0; font-size: 8.8pt; line-height: 1.25; }

    /* ===================== CERT PAGE ===================== */
    .cert{ padding: 0 6mm; margin-top: 5mm; }
    .cert p{ font-size: 9pt; line-height: 1.35; margin: 2mm 0; }

    .signature{ margin-top: 10mm; text-align: center; font-size: 9pt; }
    .signature .place{ margin-top: 6mm; font-weight: 700; }
    .signature .sig-name{ margin-top: 1mm; font-weight: 900; }
    .signature .sig-role{ margin-top: 1mm; font-size: 8.5pt; }

    .stamp{ margin-top: 10mm; text-align: center; }
    .stamp img{ height: 24mm; }

    /* ===================== FOOTER (fixed) ===================== */
    /* IMPORTANT: On le met DANS chaque page (scopé),
       et on réserve padding-bottom pour éviter chevauchement. */
    .footer{
      position: absolute;
      left: 0;
      right: 0;
      bottom: 10mm;
      text-align: center;
      font-size: 7.8pt;
      color:#333;
      line-height: 1.25;
      border-top: 1px solid #bbb;
      padding-top: 3mm;
      margin: 0 6mm;
    }
    .page-no{
      position: absolute;
      right: 6mm;
      bottom: 4mm;
      font-size: 8pt;
      color:#333;
    }
  </style>
</head>

<body>

  <!-- ===================== PAGE 1 (GARANTI: 1ère page) ===================== -->
  <div class="page">

    <div class="hdr">
      <table class="hdr-table">
        <tr>
          <td class="logo-left">
            <img src="{{ public_path('assets/img/house/Attestation_realisation_files/Image_002.jpg') }}" alt="MYHOUSE">
          </td>
          <td></td>
          <td class="logo-right">
            <img src="{{ public_path('assets/img/nova/attestation_realisation_files/logo2.png') }}" alt="QUALISAV">
          </td>
        </tr>
      </table>

      <div class="top-title-box">
        <div class="t1">ATTESTATION DE RÉALISATION D'OPÉRATION CEE</div>
        <div class="t2">FICHE BAR-SE-109</div>
        <div class="t3">DÉSEMBOUAGE DE SYSTÈME DE CHAUFFAGE COLLECTIF</div>
      </div>
    </div>

    <div class="content">

      <table class="party">
        <tr>
          <td class="col">
            <h4 class="brand-green">MYHOUSE</h4>
            <div class="kv tiny">
              5051 RUE DU PONT LONG<br>
              64160 BUROS<br>
              SIRET 89155600300046
            </div>
            <div class="kv tiny" style="margin-top:3mm;">
              Représenté par <b>M.</b> <span class="name">Amblar Jean-Christophe</span>, en qualité de Président
              <span class="muted">05 59 60 21 51</span><br>
              <span class="muted">contact@myhouse64.fr</span>
            </div>

            <div class="kv tiny" style="margin-top:3mm;">
              RC Décennale ERGO contrat n° 25076156863<br>
              Qualification Qualisav Spécialité Désembouage N° 31376 - ID N° S01810
            </div>
          </td>

          <td class="col" style="padding-left:10mm;">
            <h4 class="title-blue">BÉNÉFICIAIRE</h4>
            <div class="kv tiny">
              <b class="title-blue" style="min-width:auto; display:block;">
                {{ $document->beneficiaire_nom ?? 'BBR MAINTENANCE' }}
              </b>
              {{ $document->beneficiaire_adresse ?? '78 AVENUE DES CHAMPS ELYSEES' }}<br>
              {{ $document->beneficiaire_cp_ville ?? '75008 PARIS' }}
            </div>

            <div class="kv tiny" style="margin-top:3mm;">
              <b>SIRET</b> {{ $document->beneficiaire_siret ?? '93146162800030' }}<br>
              <b>MAIL</b> {{ $document->beneficiaire_mail ?? 'tech@bbrmaintenance.fr' }}<br>
              <b>TEL</b> {{ $document->beneficiaire_tel ?? '01 84 80 90 08' }}<br><br>
              <b>REPRÉSENTÉ PAR</b> {{ $document->beneficiaire_representant ?? 'M. Poulin Thomas' }}<br>
              <b>FONCTION</b> {{ $document->beneficiaire_fonction ?? 'Directeur des Services Techniques' }}
            </div>
          </td>
        </tr>
      </table>

      <div class="section">
        <div class="h-section">1. INFORMATIONS TECHNIQUES DE L'OPÉRATION</div>

        <table class="green-table">
          <tr><td class="k">Adresse du bâtiment</td><td class="v">{{ $document->adresse_batiment ?? '66,70 Rue de Paris, 92100 Boulogne-Billancourt' }}</td></tr>
          <tr><td class="k">Nature de l’opération</td><td class="v">Désembouage du système de distribution par boucle d’eau d’une installation collective de chauffage</td></tr>
          <tr><td class="k">Type d’installation de chauffage</td><td class="v">{{ $document->type_installation ?? 'Chaudière hors condensation' }}</td></tr>
          <tr><td class="k">Puissance nominale de la chaudière</td><td class="v">{{ $document->puissance_chaudiere ?? '820' }} kW</td></tr>
          <tr><td class="k">Nombre d’émetteurs désemboués</td><td class="v">{{ $document->nombre_emetteurs ?? '639' }}</td></tr>
          <tr><td class="k">Nature du réseau</td><td class="v">{{ $document->nature_reseau ?? 'Acier' }}</td></tr>
          <tr><td class="k">Volume d’eau total du circuit</td><td class="v">{{ $document->volume_circuit ?? '7664' }} L</td></tr>
          <tr><td class="k">Zone climatique</td><td class="v">{{ $document->zone_climatique ?? 'H1' }}</td></tr>
          <tr><td class="k">Période d’exécution</td><td class="v">{{ $document->periode_execution ?? 'Du 29/09/2025 au 30/09/2025' }}</td></tr>
          <tr><td class="k">Réactif désembouant utilisé</td><td class="v">{{ $document->produit_desembouant ?? 'SENTINEL X800' }}</td></tr>
          <tr><td class="k">Réactif inhibiteur utilisé</td><td class="v">{{ $document->produit_inhibiteur ?? 'SENTINEL X100' }}</td></tr>
          <tr><td class="k">Nombre de bâtiments</td><td class="v">{{ $document->nombre_batiments ?? '2' }}</td></tr>
          <tr><td class="k">Bâtiments</td><td class="v">{{ $document->details_batiments ?? 'Bat A (99 Logs), Bat B (99 Logs)' }}</td></tr>
        </table>
      </div>

    </div>

    <div class="footer">
      M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom : FR12891556003<br>
      Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
    </div>
    <div class="page-no">Page 1/2</div>

  </div><!-- ✅ FIN PAGE 1 -->

  <!-- ===================== PAGE 2 (GARANTI: 2ème page) ===================== -->
  <div class="page">

    <div class="hdr">
      <table class="hdr-table">
        <tr>
          <td class="logo-left">
            <img src="{{ public_path('assets/img/house/Attestation_realisation_files/Image_002.jpg') }}" alt="MYHOUSE">
          </td>
          <td></td>
          <td class="logo-right">
            <img src="{{ public_path('assets/img/nova/attestation_realisation_files/logo2.png') }}" alt="QUALISAV">
          </td>
        </tr>
      </table>
    </div>

    <div class="content">

      <div class="section" style="margin-top:6mm;">
        <div class="h-section">2. ETAPES DE L’OPÉRATION RÉALISÉE</div>
        <div class="tiny muted" style="margin-bottom:3mm;">
          (Conformément à la procédure standard BAR-SE-109 et au descriptif facture)
        </div>

        <div class="h-sub">1. PRÉPARATION ET INJECTION</div>
        <ul class="bul">
          <li>Diagnostic technique initial (pression, étanchéité, températures)</li>
          <li>Injection de {{ $document->produit_desembouant ?? 'SENTINEL X800' }} (dosage : 1% du volume d’eau)</li>
          <li>Circulation générale (4h min. à 50-60°C) et par réseau (2h/sens)</li>
        </ul>

        <div class="h-sub">2. RINÇAGE ET CONTRÔLE</div>
        <ul class="bul">
          <li>Évacuation complète du désembouant et rinçage intensif (3x volume/réseau)</li>
          <li>Remise en pression et purge d’air</li>
        </ul>
      </div>

      <div class="section" style="margin-top:0;">
        <div class="h-sub" style="margin-top:0;">3. PROTECTION ET FINALISATION</div>
        <ul class="bul">
          <li>Vérification/nettoyage des filtres existants</li>
          <li>Injection de {{ $document->produit_inhibiteur ?? 'SENTINEL X100' }} (dosage : 1% du volume d’eau)</li>
          <li>Contrôles finaux et mise en service</li>
        </ul>
      </div>

      <div class="section" style="margin-top:7mm;">
        <div class="h-sub" style="font-size:11pt;">3. CERTIFICATION</div>

        <div class="cert">
          <p>
            Je soussigné, <span class="name">M. Amblar Jean-Christophe</span> président de
            <span class="brand-green">MYHOUSE</span>, atteste que :
          </p>

          <ul class="bul">
            <li>Les travaux de désembouage ont été réalisés conformément aux techniques professionnelles et aux bonnes pratiques du secteur.</li>
            <li>L’opération est conforme :
              <ul class="bul" style="margin-top:2mm;">
                <li>À la fiche CEE BAR-SE-109</li>
                <li>Au devis référence {{ $document->reference_devis ?? 'M\'YHOUSE-2025-0138' }}</li>
                <li>Aux normes techniques du ministère de la Transition énergétique.</li>
              </ul>
            </li>
            <li>
              Les produits utilisés ({{ $document->produit_desembouant ?? 'SENTINEL X800' }}/{{ $document->produit_inhibiteur ?? 'SENTINEL X100' }})
              sont agréés par le ministère de la Santé.
            </li>
          </ul>

          <div class="signature">
            <div class="place">Fait à Paris, le {{ $document->date_certification ?? '01/10/2025' }}</div>
            <div class="sig-name">M. Amblar Jean-Christophe</div>
            <div class="sig-role">Président de <span class="brand-green">MYHOUSE</span></div>

            <div class="stamp">
              <img src="{{ public_path('assets/img/house/Attestation_realisation_files/Image_005.png') }}" alt="Cachet MYHOUSE">
            </div>
          </div>
        </div>
      </div>
    </div>

     <div class="footer">
      M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom : FR12891556003<br>
      Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
    </div>
    <div class="page-no">Page 2/2</div>

  </div><!-- ✅ FIN PAGE 2 -->

</body>
</html>
