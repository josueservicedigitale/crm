<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Attestation de réalisation</title>

<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 10pt;
    line-height: 1.3;
    margin: 15px;
}

h1 { color:#80A150; font-size:16pt; text-align:center; margin:5px 0; }
h2 { color:#00007F; font-size:12pt; text-align:center; margin:3px 0; }
h3 { color:#036; font-size:10pt; margin-top:15px; }

p { margin:3px 0; font-size:9pt; }

.section-title { color:#00007F; font-size:12pt; margin:15px 0 8px; }
.section-subtitle { color:#099; font-size:11pt; margin:10px 0 5px; }
.certification-title { color:#80A150; font-size:12pt; margin:15px 0 8px; }

table { width:100%; border-collapse:collapse; margin:8px 0; }
td { border:1px solid #99CC99; padding:5px; font-size:9pt; vertical-align:top; }

ul { margin:4px 0; padding-left:18px; }
li { margin-bottom:3px; font-size:9pt; }

.page-break { page-break-before: always; }
.signature-section { text-align:right; margin-top:25px; }
</style>
</head>

<body>

<!-- ================= LOGOS PAGE 1 ================= -->
<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
<tr>
<td width="50%" align="left" style="border:none; padding:0;">
    <img src="file://{{ public_path('assets/img/house/Attestation_realisation_files/Image_002.jpg') }}" height="70">
</td>
<td width="50%" align="right" style="border:none; padding:0;">
    <img src="file://{{ public_path('assets/img/house/Attestation_realisation_files/Image_001.jpg') }}" height="70">
</td>
</tr>
</table>

<h1>Attestation de réalisation d'opération CEE</h1>
<h2>Fiche BAR-SE-109</h2>
<h2>Désembouage de système de chauffage collectif</h2>

<p><strong style="color:#80A150;">M'YHOUSE</strong><br>
5051 RUE DU PONT LONG – 64160 BUROS<br>
SIRET 89155600300046<br>
M. Amblar Jean-Christophe – Président<br>
contact@myhouse64.fr – 05 59 60 21 51<br>
Qualification Qualisav N°32056 – ID S01946
</p>

<h3 style="color:#036;">BBR MAINTENANCE</h3>
<p>
78 AVENUE DES CHAMPS ELYSEES – 75008 PARIS<br>
SIRET 93146162800030<br>
tech@bbrmaintenance.fr<br>
M. Poulin Thomas – Directeur des Services Techniques
</p>

<div class="section-title">1. Informations techniques de l'opération</div>

<table>
<tr><td>Adresse du bâtiment</td><td>{{ $document->adresse_travaux }}<br>{{ $document->nom_residence }}</td></tr>
<tr><td>Nature de l'opération</td><td>{{ $document->activity ?? 'Désembouage de système collectif' }}</td></tr>
<tr><td>Nombre de logements</td><td>{{ $document->nombre_logements }} logements</td></tr>
<tr><td>Type d'installation</td><td>{{ $document->type }} {{ $document->puissance_chaudiere }} kW</td></tr>
<tr><td>Émetteurs désemboués</td><td>{{ $document->nombre_emetteurs }}</td></tr>
<tr><td>Volume circuit</td><td>{{ $document->volume_circuit }} L {{ $document->zone_climatique }}</td></tr>
<tr><td>Période d'exécution</td><td>{{ $document->dates_previsionnelles }}</td></tr>
<tr><td>Bâtiments</td><td>{{ $document->nombre_batiments }}<br>{{ $document->details_batiments }}</td></tr>
<tr><td>Filtres</td><td>{{ $document->nombre_filtres }}</td></tr>
</table>

<!-- ================= PAGE 2 ================= -->
<div class="page-break"></div>

<table width="100%" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
<tr>
<td width="50%" align="left" style="border:none; padding:0;">
    <img src="file://{{ public_path('assets/img/house/Attestation_realisation_files/Image_002.jpg') }}" height="70">
</td>
<td width="50%" align="right" style="border:none; padding:0;">
    <img src="file://{{ public_path('assets/img/house/Attestation_realisation_files/Image_001.jpg') }}" height="70">
</td>
</tr>
</table>

<div class="section-title">2. Étapes de l'opération réalisée</div>

<div class="section-subtitle">1. Préparation et Injection</div>
<ul>
<li>Diagnostic technique initial</li>
<li>Injection SENTINEL X800 (1%)</li>
<li>Circulation générale et par réseau</li>
</ul>

<div class="section-subtitle">2. Rinçage et Contrôle</div>
<ul>
<li>Rinçage intensif</li>
<li>Remise en pression et purge d'air</li>
</ul>

<div class="section-subtitle">3. Protection et Finalisation</div>
<ul>
<li>Nettoyage filtres</li>
<li>Injection SENTINEL X100 (1%)</li>
<li>Contrôles finaux</li>
</ul>

<div class="certification-title">3. Certification</div>

<p>Je soussigné, <strong>M. Amblar Jean-Christophe</strong>, président de <strong style="color:#80A150;">M'YHOUSE</strong>, atteste que :</p>

<ul>
    <li>Travaux réalisés selon les règles professionnelles</li>
    <li>Conforme à la fiche CEE BAR-SE-109</li>
    <li>Au Devis <strong>{{ $document->reference_devis ?? '' }}</strong> accepté le <strong>{{ $document->date_devis ?? '' }}</strong></li>
    <li>Produits SENTINEL utilisés conformément aux prescriptions</li>
    <li>Produits agréés par le ministère de la Santé</li>
    <li>Montant HT : {{ number_format($document->montant_ht ?? 0, 2, ',', ' ') }} €</li>
    <li>Montant TTC : {{ number_format($document->montant_ttc ?? 0, 2, ',', ' ') }} €</li>
    <li>Prime CEE : {{ number_format($document->prime_cee ?? 0, 2, ',', ' ') }} €</li>
    <li>Reste à charge : {{ number_format($document->reste_a_charge ?? 0, 2, ',', ' ') }} €</li>
</ul>

<div class="signature-section">
<p>Fait le {{ $document->date_signature ?? date('d/m/Y') }}</p>
<p><strong>M. Amblar Jean-Christophe</strong><br>Président M'YHOUSE</p>

@if(!empty($document->file_path))
    <img src="file://{{ public_path($document->file_path) }}" height="90">
@else
    <img src="file://{{ public_path('assets/img/house/Attestation_realisation_files/Image_005.png') }}" height="90">
@endif
</div>

</body>
</html>
