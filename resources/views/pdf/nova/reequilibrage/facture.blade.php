<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Facture {{ $document->reference_facture }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 10pt; color: #000; margin: 20px; }
    h1 { font-size: 14pt; color: #FFF; background-color: #1A4D7E; padding: 4px; }
    h2 { font-size: 11pt; color: #FFF; background-color: #003366; padding: 4px; }
    h3 { font-size: 10pt; margin-top: 10px; font-weight: bold; }
    p { margin: 4px 0; }
    table { border-collapse: collapse; width: 100%; margin-top: 10px; }
    th, td { border: 1px solid #000; padding: 6px; }
    th { background-color: #003366; color: #FFF; }
    .signature-box { border: 1px dashed #000; height: 120px; margin-top: 20px; padding: 10px; }
    .page-break { page-break-before: always; }
    .totals-grid { width: 100%; border-collapse: collapse; margin-top: 20px; }
    .totals-grid th, .totals-grid td { border: 1px solid #000; padding: 8px; }
    .grey-block { background-color: #f5f5f5; padding: 10px; margin: 15px 0; }
    .page-number { text-align: center; margin-top: 15px; font-size: 8pt; color: #666; }
  </style>
</head>
<body>

<!-- PAGE 1 -->
<div>
  <p><img src="{{ public_path('assets/img/rehouse/Facture_files/Image_001.png') }}" width="150" alt="Logo"></p>
  <h1>FACTURE {{ $document->reference_facture }}</h1>
  <p>Date : {{ $document->date_facture }}</p>

  <!-- Bloc infos -->
  <div class="grey-block">
    <table style="width:100%;">
      <tr>
        <td style="width:50%; vertical-align:top;">
          <h3>Bénéficiaire</h3>
          <strong>{{ $document->society }}</strong><br/>
          {{ $document->adresse_travaux }}<br/>
          Numéro immatriculation : {{ $document->numero_immatriculation }}<br/>
          Nom de résidence : {{ $document->nom_residence }}<br/>
          Parcelle cadastrale : {{ $document->parcelle_1 }}
        </td>
        <td style="width:50%; vertical-align:top;">
          <h3>ENERGIE NOVA</h3>
          <strong>ENERGIE NOVA</strong><br/>
          Activité : {{ $document->activity }}<br/>
          Type : {{ $document->type }}<br/>
          Référence devis : {{ $document->reference_devis }}<br/>
          Date devis : {{ $document->date_devis }}
        </td>
      </tr>
    </table>
  </div>

  <h2>Objet</h2>
  <p>Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Économie d'Énergie), conforme aux recommandations de la fiche BAR-SE-104.</p>

  <h2>Désignation</h2>
  <p>Réglage des organes d'équilibrage d'une installation de chauffage à eau chaude.</p>

  <h3>Site des travaux</h3>
  <p>{{ $document->adresse_travaux }}</p>

  <h2>Caractéristiques</h2>
  <table>
    <thead>
      <tr>
        <th>Détail</th>
        <th>Quantité</th>
        <th>PU HT</th>
        <th>Total HT</th>
        <th>TVA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          Type : {{ $document->type }}<br/>
          Zone climatique : {{ $document->zone_climatique }}<br/>
          Nombre de logements : {{ $document->nombre_logements }}<br/>
          Puissance chaudière : {{ $document->puissance_chaudiere }} Kw<br/>
          • KWH CUMAC : <strong>{{ $document->wh_cumac }}</strong><br/>
          • PRIME CEE : <strong>{{ $document->prime_cee }} €</strong>
        </td>
        <td>1</td>
        <td class="text-right">{{ $document->montant_ht }} €</td>
        <td class="text-right">{{ $document->montant_ht }} €</td>
        <td>5,5 %</td>
      </tr>
    </tbody>
  </table>

  <div class="page-number">Page 1</div>
</div>

<!-- PAGE 2 -->
<div class="page-break">
  <h2>Détail de la prestation</h2>
  <table>
    <thead>
      <tr>
        <th>Description</th>
        <th>Qté</th>
        <th>PU HT</th>
        <th>Total HT</th>
        <th>TVA</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <strong>1.</strong> Réglage des organes d'équilibrage<br/>
          <strong>2.</strong> Mise en place matériel d’équilibrage :
          <ul>
            <li>Relevé sur site</li>
            <li>Plan du sous-sol</li>
            <li>Synoptique des colonnes</li>
            <li>Note de calcul des débits</li>
            <li>Réglage pompe chauffage</li>
            <li>Mesure de débit</li>
            <li>Tableau des températures</li>
            <li>Écart de température < 2°C</li>
          </ul>
        </td>
        <td>1</td>
        <td class="text-right">{{ $document->montant_ht }} €</td>
        <td class="text-right">{{ $document->montant_ht }} €</td>
        <td>5,5 %</td>
      </tr>
      <tr>
        <td>
          <strong>Compris dans les travaux :</strong>
          <ul>
            <li>Dépose et enlèvement ancien appareil</li>
            <li>Protection et nettoyage chantier</li>
            <li>Remplissage et purge installation</li>
          </ul>
        </td>
        <td>1</td>
        <td class="text-right">{{ $document->somme }} €</td>
        <td class="text-right">{{ $document->somme }} €</td>
        <td>5,5 %</td>
      </tr>
    </tbody>
  </table>

  <div class="page-number">Page 2</div>
</div>

<!-- PAGE 3 -->
<div class="page-break">
  <h2>Conditions CEE</h2>
  <p>Les travaux donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333 118), versée sous réserve de validation de l’éligibilité du dossier par l’autorité compétente.</p>
  <p>Montant estimé : <strong>{{ $document->prime_cee }} €</strong></p>

  <h2>Totaux</h2>
  <table class="totals-grid">
    <tr>
      <th>Total HT</th>
      <td>{{ $document->montant_ht }} €</td>
      <th>TVA 5,5%</th>
      <td>{{ $document->montant_tva }} €</td>
    </tr>
    <tr>
      <th>Total TTC</th>
      <td>{{ $document->montant_ttc }} €</td>
      <th>Prime CEE</th>
      <td>- {{ $document->prime_cee }} €</td>
    </tr>
    <tr>
      <th colspan="3">Reste à charge</th>
      <td><strong>{{ $document->reste_a_charge }} €</strong></td>
    </tr>
  </table>

  <h2>Signature</h2>
  <div class="signature-box"></div>
  <p>Date de signature : {{ $document->date_signature }}</p>

  <div class="page-number">Page 3</div>
</div>

</body>
</html>
