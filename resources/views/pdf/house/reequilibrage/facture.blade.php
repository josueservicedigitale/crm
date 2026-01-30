<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Facture {{ $document->reference_facture }}</title>

<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 9.5pt;
        color: #000;
        margin: 15px;
        line-height: 1.35;
    }

    h1 {
        font-size: 13pt;
        color: #FFF;
        background-color: #81A150;
        padding: 5px;
        margin: 5px 0;
    }

    h3 {
        font-size: 10pt;
        margin: 8px 0 4px 0;
    }

    h4 {
        font-size: 9pt;
        margin: 4px 0;
    }

    p { margin: 3px 0; }

    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 8px;
    }

    td, th {
        border: 1px solid #000;
        padding: 5px;
        vertical-align: top;
    }

    th {
        background-color: #81A150;
        color: #FFF;
        font-weight: bold;
    }

    ul {
        margin: 3px 0 3px 15px;
        padding: 0;
    }

    li { margin-bottom: 2px; }

    .small-text { font-size: 8.8pt; }

    .signature-box {
        border: 1px dashed #000;
        height: 120px;
        margin-top: 15px;
        padding: 8px;
    }

    .page-break {
        page-break-before: always;
    }

    @page {
        margin: 18mm 15mm;
    }

    table { page-break-inside: auto; }
    tr { page-break-inside: avoid; }
    thead { display: table-header-group; }
</style>
</head>

<body>

<!-- =================== PAGE 1 =================== -->

<img src="{{ public_path('assets/img/rehouse/Facture_files/Image_001.jpg') }}" width="180">

<h1>FACTURE {{ $document->reference_facture }}</h1>
<p>Date : {{ $document->date_facture }}</p>

<table>
<tr>
<td style="width:50%;">
    <h4>Adresse des travaux :</h4>
    <p>{{ $document->adresse_travaux }}</p>
    <p>@php
$parcelles = array_filter([
    $document->parcelle_1,
    $document->parcelle_2,
    $document->parcelle_3,
    $document->parcelle_4
]);
@endphp

@if(count($parcelles))
<p><strong>Parcelles cadastrales :</strong> {{ implode(', ', $parcelles) }}</p>
@endif
</p>
    <p>N° immatriculation : {{ $document->numero_immatriculation }}</p>
    <p>Nombre bâtiments : {{ $document->nombre_batiments }}</p>
    <p>Détails bâtiments : {{ $document->details_batiments }}</p>
    <p>Nom résidence : {{ $document->nom_residence }}</p>
    <p>Date travaux : {{ $document->date_travaux }}</p>
    <p>Date désembouage : {{ $document->date_desembouage }}</p>
</td>

<td style="width:50%;">
    <p><strong>BBR MAINTENANCE</strong></p>
    <p>Siret : 93146162800030</p>
    <p>78 Avenue des Champs Élysées, 75008 Paris</p>
    <p>Tél : 01 85 09 74 35</p>
    <p>Mail : tech@bbrmaintenance.fr</p>
    <p>Représenté par : M. Poulin Thomas</p>
</td>
</tr>
</table>

<table>
<thead>
<tr>
<th>Détail</th>
<th>Qté</th>
<th>P.U HT</th>
<th>Total HT</th>
<th>TVA</th>
</tr>
</thead>

<tbody>
<tr>
<td class="small-text">
Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude.<br>
Kwh Cumac : <b>{{ $document->wh_cumac }}</b> — Prime CEE : <b>{{ $document->prime_cee }}</b> €<br>
Installation : <b>{{ $document->type }}</b> — Puissance chaudière : {{ $document->puissance_chaudiere }} Kw<br>
Logements concernés : <b>{{ $document->nombre_logements }}</b><br><br>

<b>Détail de la prestation :</b>
<ul>
<li>Réglage des organes d’équilibrage</li>
<li>Mise en place matériel d’équilibrage</li>
<li>Relevé sur site</li>
<li>Plan du sous-sol</li>
<li>Synoptique des colonnes</li>
<li>Note de calcul des débits</li>
<li>Réglage pompe chauffage</li>
<li>Mesure de débit</li>
<li>Tableau des températures</li>
</ul>

<b>Compris dans les travaux :</b>
<ul>
<li>Dépose et enlèvement ancien appareil</li>
<li>Protection et nettoyage chantier</li>
<li>Remplissage et purge installation</li>
</ul>
</td>

<td style="text-align:center;">1</td>
<td style="text-align:right;">{{ $document->montant_ht }} €</td>
<td style="text-align:right;">{{ $document->montant_ht }} €</td>
<td style="text-align:center;">5,5 %</td>
</tr>
</tbody>
</table>

<!-- =================== PAGE 2 =================== -->
<div class="page-break"></div>

<img src="{{ public_path('assets/img/rehouse/Facture_files/Image_001.jpg') }}" width="180">

<h1>FACTURE {{ $document->reference_facture }}</h1>
<p>Date : {{ $document->date_facture }}</p>

<h3>Conditions de paiement</h3>
<p class="small-text">
Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333 118). Le montant est estimé à 7 614,60 €.
</p>

<h3>Totaux</h3>
<table>
<tr><th>Total H.T</th><td>{{ $document->montant_ht }} €</td></tr>
<tr><th>Total TVA 5,5%</th><td>{{ $document->montant_tva }} €</td></tr>
<tr><th>Total TTC</th><td>{{ $document->montant_ttc }} €</td></tr>
<tr><th>Prime CEE</th><td>{{ $document->prime_cee }} €</td></tr>
<tr><th>Reste à payer</th><td><strong>{{ $document->reste_a_charge }} €</strong></td></tr>
</table>

<p>Mode de paiement : Chèques, virement ou espèce</p>

<h3>Gestion des déchets</h3>
<p class="small-text">
Gestion, évacuation et traitement des déchets de chantier comprenant la main d’œuvre liée à la dépose, le tri, le transport et le traitement.
</p>

<p><img src="{{ public_path('assets/img/rehouse/Facture_files/Image_003.png') }}" width="350"></p>

<h3>Signature</h3>
<p><b>Signature, date, cachet commercial & mention « Bon pour accord » :</b></p>

<div class="signature-box">
Nom, prénom et fonction du signataire :
</div>

</body>
</html>
