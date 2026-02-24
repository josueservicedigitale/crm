<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Formulaire CEE - EBS ENERGIE</title>

  <style>
    @page { margin: 12mm 12mm 12mm 12mm; }   /* vraies marges imprimante */

    /* ===================== DOMPDF SAFE ===================== */
    * { box-sizing: border-box; margin: 0; padding: 0; }

    html, body{
      font-family: Arial, Helvetica, sans-serif;
      font-size: 9.5pt;
      color:#111;
    }

    /* 2 PAGES EXACTEMENT */
    .page{ page-break-after: always; }
    .page:last-child{ page-break-after: auto; }

    /* grand cadre */
    .frame{
      margin: 5mm;
      border: 1px solid #2b2b2b;
      padding: 10mm 10mm 8mm 10mm;
      height: 260mm;
    }

    .hdr{ width:100%; border-collapse: collapse; table-layout: fixed; }
    .hdr td{ vertical-align: middle; }

    .left{ width: 60mm; text-align: left; }
    .mid{ width: auto; text-align: center; }
    .right{ width: 60mm; text-align: right; }

    /* texte */
    p{ line-height: 1.35; margin: 2mm 0; }
    .small{ font-size: 8.3pt; }
    .tiny{ font-size: 7.7pt; }
    .muted{ color:#4b4b4b; }

    /* lignes de formulaire */
    .row{ margin: 2mm 0; }
    .checkline{
      display: block;
      margin: 1.4mm 0;
      line-height: 1.35;
    }

    .box{
      display: inline-block;
      width: 3.8mm;
      height: 3.8mm;
      border: 1px solid #333;
      vertical-align: -0.6mm;
      margin-right: 2.5mm;
      background: #fff;
    }
    .box.filled{ background:#333; }

    /* tableau nature de travaux */
    .tbl{
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin: 4mm 0 3mm 0;
      font-size: 8.4pt;
    }
    .tbl th, .tbl td{
      border: 1px solid #333;
      padding: 2.5mm 2.5mm;
      vertical-align: top;
      word-break: break-word;
      overflow-wrap: anywhere;
    }
    .tbl th{
      background: #f3f3f3;
      font-weight: 800;
      text-align: center;
    }
    .tbl .c1{ width: 35%; }
    .tbl .c2{ width: 15%; text-align:center; font-weight:700; color:#0a49b5; }
    .tbl .c3{ width: 50%; color:#0a49b5; }

    .note-blue{
      color:#0a49b5;
      margin-top: 1mm;
      margin-bottom: 2mm;
    }

    /* bas de page signature */
    .bottom-area{ margin-top: 6mm; }
    .sig-grid{
      width:100%;
      border-collapse: collapse;
      table-layout: fixed;
      margin-top: 2mm;
    }
    .sig-grid td{
      border:none;
      vertical-align: top;
      padding: 0;
    }
    .sig-left{ width: 45%; }
    .sig-mid{ width: 30%; text-align:center; }
    .sig-right{ width: 25%; }

    .stamp{
      height: auto;
      margin-top: 2mm;
      max-height: 25mm;
    }

    .footer-code{
      position: fixed;
      bottom: 10mm;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 7.3pt;
      color: #333;
    }
    .footer-num{
      position: fixed;
      bottom: 10mm;
      left: 0;
      right: 5mm;
      text-align: right;
      font-size: 9pt;
    }

    /* PAGE 2 : bande bleue d'infos */
    .warn{
      color:#d10f0f;
      font-weight: 800;
      margin-top: 40mm;
    }
    .bluebox{
      border: 1px solid #1a1a1a;
      background: #8cc7f3;
      padding: 5mm 5mm;
      margin-top: 14mm;
      font-size: 8.2pt;
      line-height: 1.35;
      color:#062a43;
    }
    .bluebox a{ color:#062a43; text-decoration: underline; }
    .icon-mini{
      float:right;
      width: 10mm;
      height: 10mm;
      border: 1px solid rgba(0,0,0,.25);
      margin-left: 4mm;
      background: rgba(255,255,255,.35);
      text-align:center;
      line-height: 10mm;
      font-weight: 800;
      color: rgba(0,0,0,.45);
    }

    .dyn{ color:#0a49b5; font-weight:800; }
  </style>
</head>

<body>

  <!-- ===================== PAGE 1 ===================== -->
  <div class="page">
    <div class="frame">

      <table class="hdr">
        <tr>
          <td class="left">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_001.jpg') }}" alt="Logo CEE">
          </td>
          <td class="mid">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_007.jpg') }}" alt="Logo EBS ENERGIE">
          </td>
          <td class="right">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_003.jpg') }}" alt="Logo M'Y HOUSE">
          </td>
        </tr>
      </table>

      <p class="small">
        Le dispositif national des certificats d’économies d’énergie (CEE) mis en place par le Ministère en charge de l’énergie impose à l’ensemble
        des fournisseurs d’énergie (électricité, gaz, fioul domestique, chaleur ou froid, carburants automobiles), de réaliser des économies et de
        promouvoir les comportements vertueux auprès des consommateurs d’énergie.
      </p>

      <p class="small">
        Dans le cadre de son partenariat avec la société EBS ENERGIE, la société (M'Y HOUSE) s’engage à vous apporter :
      </p>

      {{-- ===================== OFFRES / PRIMES (DYNAMIQUE) ===================== --}}
      <div class="row small">

        {{-- PRIME CEE --}}
        <span class="checkline">
          <span class="box {{ ($document->prime_cee ?? 0) > 0 ? 'filled' : '' }}"></span>
          une prime d’un montant de&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->prime_cee) && $document->prime_cee > 0 ? number_format($document->prime_cee, 2, ',', ' ') . ' €' : '_____' }}
          </span> ;
        </span>

        {{-- BON D’ACHAT --}}
        <span class="checkline">
          <span class="box {{ ($document->bon_achat ?? 0) > 0 ? 'filled' : '' }}"></span>
          un bon d’achat pour des produits de consommation courante d’un montant de&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->bon_achat) && $document->bon_achat > 0 ? number_format($document->bon_achat, 2, ',', ' ') . ' €' : '_____' }}
          </span> ;
        </span>

        {{-- PRÊT BONIFIÉ --}}
        <span class="checkline">
          <span class="box {{ ($document->pret_bonifie ?? 0) > 0 ? 'filled' : '' }}"></span>
          un prêt bonifié d’un montant de&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->pret_bonifie) && $document->pret_bonifie > 0 ? number_format($document->pret_bonifie, 2, ',', ' ') . ' €' : '_____' }}
          </span>
          proposé par&nbsp;&nbsp;
          <span class="dyn">
            {{ $document->pret_organisme ?: '_____' }}
          </span>
          au taux effectif global (TEG) de&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->pret_teg) && $document->pret_teg !== null ? $document->pret_teg . ' %' : '_____' }}
          </span> ;
        </span>

        {{-- AUDIT --}}
        <span class="checkline">
          <span class="box {{ !empty($document->audit) ? 'filled' : '' }}"></span>
          un audit ou conseil personnalisé comme écrit (valeur =&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->audit_valeur) && $document->audit_valeur > 0 ? number_format($document->audit_valeur, 2, ',', ' ') . ' €' : '_____' }}
          </span>) ;
        </span>

        {{-- PRODUIT / SERVICE OFFERT --}}
        <span class="checkline">
          <span class="box {{ !empty($document->produit_offert) ? 'filled' : '' }}"></span>
          un produit ou service offert&nbsp;:&nbsp;&nbsp;[nature à préciser]
          <span class="dyn">
            {{ $document->produit_offert_nature ?: '____________' }}
          </span>
          d’une valeur de&nbsp;&nbsp;
          <span class="dyn">
            {{ isset($document->produit_offert_valeur) && $document->produit_offert_valeur > 0 ? number_format($document->produit_offert_valeur, 2, ',', ' ') . ' €' : '_____' }}
          </span>
        </span>

      </div>

      <p class="small">
        dans le cadre des travaux suivants (1 ligne par opération) :
      </p>

      <table class="tbl">
        <tr>
          <th class="c1">Nature des travaux</th>
          <th class="c2">Fiche CEE</th>
          <th class="c3">Conditions à respecter</th>
        </tr>
        <tr>
          <td class="c1">
            <span style="color:#0a49b5; font-weight:800;">
              {{ $document->nature_travaux ?? 'Désembouage d’un réseau hydraulique de chauffage collectif en France métropolitaine' }}
            </span>
          </td>
          <td class="c2">{{ $document->fiche_cee ?? 'BAR-SE-109' }}</td>
          <td class="c3">
            Voir le site du Ministère de l’Écologie et de la Transition Écologique et Solidaire :
            <br>
            <span style="text-decoration: underline;">
              www.ecologique-solidaire.gouv.fr/operations-standardisees-deconomies-denergie
            </span>
          </td>
        </tr>
      </table>

      <p class="note-blue tiny">
        au bénéfice de : (Ajouter d’éventuelles autres conditions à respecter, ou renvoyer à des conditions contractuelles)
      </p>

      {{-- ===================== BÉNÉFICIAIRE (DYNAMIQUE) ===================== --}}
      <div class="small">
        <div>•&nbsp;&nbsp;Nom : <b>{{ $document->beneficiaire_nom ?? 'BBR MAINTENANCE' }}</b></div>
        <div>•&nbsp;&nbsp;Prénom : <b>{{ $document->beneficiaire_prenom ?? '_______________________' }}</b></div>
        <div>•&nbsp;&nbsp;Adresse : <b>{{ $document->adresse_travaux ?? '78 AVENUE DES CHAMPS ELYSEES, 75008 PARIS' }}</b></div>
        <div>•&nbsp;&nbsp;Téléphone : <b>{{ $document->beneficiaire_telephone ?? '01 85 09 74 35' }}</b></div>
        <div>•&nbsp;&nbsp;Adresse e-mail : <b>{{ $document->beneficiaire_email ?? 'tech@bbrmaintenance.fr' }}</b></div>
      </div>

      <p class="small" style="margin-top:4mm;">
        *Montant de prime valable 3 mois à compter de la date d’édition du devis
        <span style="color:#d10f0f; font-weight:800;">
          {{ $document->date_devis ? \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') : 'Non renseignée' }}
        </span>
      </p>

      <p class="tiny muted">
        Les montants de prime indiqués ci-dessus sont définis selon les fiches d’opérations standardisées disponibles sur le site du Ministère en charge
        de l’énergie, et pourront être actualisés en fonction des paramètres relatifs aux travaux réalisés et de la situation fiscale du ménage.
        <br><br>
        Le présent engagement est pris dans le cadre de la période 5 (2022-2025) du dispositif des certificats d’économies d’énergie (CEE), institué
        par le Titre II du Livre II du Code de l’Énergie. Cet engagement est non cumulable avec une autre offre liée au dispositif des Certificats
        d’Économies d’Énergie.
        <br><br>
        Cet engagement est valable pour les travaux réalisés jusqu’à 1 an après la date d’édition du devis (date de factures des travaux faisant foi).
        <br><br>
        Dans le cadre de la réglementation, un contrôle qualité des travaux sur site par un contact pourra être demandé. Un refus de ce contrôle sur site
        ou par contact via EBS ENERGIE ou un prestataire d’EBS ENERGIE conduira au refus de cette prime par EBS ENERGIE.
      </p>

      <p class="small" style="margin-top:4mm;">
        Date de cette proposition :
        <b>
          {{ $document->date_signature ? \Carbon\Carbon::parse($document->date_signature)->format('d/m/Y') : 'Non renseignée' }}
        </b>
      </p>

      <p class="tiny note-blue">
        Le présent document doit être signé au plus tard quatorze jours après la date d’engagement de l’opération, et en tout état de cause avant la date
        de début des travaux.
      </p>

      {{-- ===================== SIGNATURE (DYNAMIQUE) ===================== --}}
      <div class="bottom-area">
        <table class="sig-grid">
          <tr>
            <td class="sig-left tiny">
              Signature:<br>
              NOM Prénom : <span style="color:#0a49b5;">{{ $document->signataire_nom ?? 'Amblar Jean-Christophe' }}</span><br>
              Fonction : <span style="color:#0a49b5;">{{ $document->signataire_fonction ?? 'Président' }}</span>
            </td>

            <td class="sig-mid tiny">
              Tampon et signature de la société
              <div>
                @if(!empty($document->cachet_image))
                  <img class="stamp" src="{{ Storage::path($document->cachet_image) }}" alt="Cachet">
                @else
                  <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_005.png') }}" alt="Cachet M'Y HOUSE">
                @endif
              </div>
            </td>

            <td class="sig-right tiny"></td>
          </tr>
        </table>
      </div>

      <div class="footer-code">
        FORM_CONF_CDC_BAR_109_EBS Energie_INDIRECT HCDP_2024 09 01
      </div>
      <div class="footer-num">Page 1 / 2</div>

    </div>
  </div>

  <!-- ===================== PAGE 2 ===================== -->
  <div class="page">
    <div class="frame">

      <table class="hdr">
        <tr>
          <td class="left">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_001.jpg') }}" alt="Logo CEE">
          </td>
          <td class="mid">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_007.jpg') }}" alt="Logo EBS ENERGIE">
          </td>
          <td class="right">
            <img class="stamp" src="{{ public_path('assets/img/house/Cdc_files/Image_003.jpg') }}" alt="Logo M'Y HOUSE">
          </td>
        </tr>
      </table>

      <div class="warn small">///</div>
      <p class="small">
        Faites réaliser plusieurs devis afin de prendre une décision éclairée. Attention, seules les propositions remises avant
        l’acceptation du devis ou du bon de commande sont valables, et vous ne pouvez pas cumuler plusieurs offres CEE différentes
        pour la même opération.
      </p>

      <div class="warn small" style="margin-top:4mm;">///</div>
      <p class="small">
        Seul le professionnel est responsable de la conformité des travaux que vous lui confiez. Vérifiez ses qualifications techniques
        et l’éligibilité des produits proposés avant d’engager vos travaux. Un contrôle des travaux effectués dans votre logement pourra
        être réalisé sur demande de EBS ENERGIE ou des autorités publiques.
      </p>

      <div class="bluebox">
        <div class="icon-mini">≡</div>

        <div style="font-weight:800; text-decoration: underline;">
          Où se renseigner pour bénéficier de cette offre ?&nbsp;:
          <span style="text-decoration: underline;">https://www.ebu-energie.com</span>
          &nbsp;(+33)01 43 92 92 32
        </div>

        <div style="margin-top:3mm; font-weight:800; text-decoration: underline;">
          Où s’informer sur le site vous les travaux d’économies d’énergie ? :
          Site du réseau FAIRE : <span style="text-decoration: underline;">https://www.faire.gouv.fr</span>
        </div>

        <div style="margin-top:3mm;">
          En cas de litige avec le porteur de l’offre ou son partenaire, vous pouvez faire appel gratuitement au médiateur de la consommation
          (6° de l’article L. 611-1 du code de la consommation) <b>Médiation de la Consommation et Patrimoine</b> dont nous relevons via le site :
          <span style="text-decoration: underline;">www.mcpmediation.org</span> ou par voie postale : <b>12 Square Desnouettes - 75015 PARIS</b>
          ou par téléphone au <b>01 40 61 03 33</b>
        </div>
      </div>

      <div class="footer-code">
        FORM_CONF_CDC_BAR_109_EBS Energie_INDIRECT HCDP_2024 09 01
      </div>
      <div class="footer-num">Page 2 / 2</div>

    </div>
  </div>

</body>
</html>