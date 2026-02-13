<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Devis</title>

<style>
body { font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 40px; color:#000; }

h2 { margin: 8px 0 4px 0; font-size: 13px; }
p { margin: 2px 0; }

.table { width:100%; border-collapse: collapse; }
.table td, .table th { border:1px solid #003366; padding:6px; vertical-align: top; }
.header-blue { background:#1A4D7E; color:#fff; font-weight:bold; }

.gray-block { background:#f2f2f2; padding:12px; margin:10px 0; }

.parties-table { width:100%; }
.parties-table td { width:45%; vertical-align:top; }
.parties-sep { width:10%; }

.page-break { page-break-after: always; }

.totals-grid { width:60%; margin-left:auto; border-collapse:collapse; }
.totals-grid td { padding:6px 4px; }
.totals-label { text-align:right; }
.totals-value { text-align:right; font-weight:bold; }

.footer {
  position: fixed;
  bottom: 10px;
  right: 20px;
  font-size:10px;
}
.footer:after {
  content: "Page " counter(page) " / " counter(pages);
}
.footer {
  position: fixed;
  bottom: 10px;
  left: 40px;
  right: 40px;
  font-size:10px;
  text-align:center;
  color:#000;
}
</style>
</head>

<body>

<div class="footer">
PATRIMOINE- SASU au capital de 5 000 € - 60 Rue FRANCOIS 1 ER 75008 PARIS | SIRET : 933 487 795 00017 - APE 7112B
</div>


<!-- ================== PAGE 1 ================== -->

<table class="table">
<tr>
<td class="header-blue">REF DEVIS</td>
<td class="header-blue">{{ $document->reference_devis }}</td>
</tr>
<tr>
<td class="header-blue">DATE DEVIS</td>
<td class="header-blue">{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
</tr>
</table>

<div class="gray-block">
  <table class="parties-table">
    <tr>
      <!-- BENEFICIAIRE -->
      <td>
        <h2>BENEFICIAIRE</h2>
        <p><strong>RABATHERM HECS</strong></p>
        <p>21 RUE D'ANJOU</p>
        <p>92600 ASNIERES-SUR-SEINE</p>
        <p>44261333700033</p>
        <p>contact@rabatherm-hecs.fr 01 84 80 90 08</p>
        <p>M. Offel De Villaucourt Charles</p>
        <p>Gérant</p>
      </td>

      <td class="parties-sep"></td>

      <!-- FOURNISSEUR -->
      <td style="text-align:right;">
        <p><strong>PATRIMOINE</strong></p>
        <p>60 Rue FRANCOIS 1 ER</p>
        <p>75008 PARIS</p>
        <p>SIRET 933 487 795 00017</p>
        <p>M. TAMOYAN Hamlet — Président</p>
        <p>0767847049</p>
        <p>direction@patrimoine.fr</p>
        <p>RC Décennale ERGO contrat n° 25076156863</p>
      </td>
    </tr>
  </table>
</div>
<h2>OBJET :</h2>
<p>Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie d'Energie), conforme aux recommandations de la fiche technique N°BAR-SE-104 de C.E.E décrites par le ministère de la Transition énergétique.</p>

<h2>DESIGNATION</h2>
<p>Réglage des organes d'équilibrage d'une installation de chauffage à eau chaude...</p>

<h2>SITE DES TRAVAUX :</h2>
<p><strong>{{ $document->adresse_travaux }}</strong></p>

<p><strong>NUMÉRO IMMATRICULATION DE COPROPRIÉTÉ :</strong> {{ $document->numero_immatriculation }} - {{ $document->nom_residence }}</p>
<p><strong>PARCELLE CADASTRALE :</strong> Parcelle {{ $document->parcelle_1 }} Feuille {{ $document->parcelle_2 }} {{ $document->parcelle_3 }} {{ $document->parcelle_4 }}</p>
<p><strong>DATE DES TRAVAUX :</strong> {{ $document->dates_previsionnelles }}</p>
<p><strong>SECTEUR :</strong> Résidentiel</p>
<p><strong>NOMBRE DE BATIMENTS :</strong> {{ $document->nombre_batiments }} Batiments</p>
<p><strong>DETAILS :</strong> {{ $document->details_batiments }}</p>

<!-- TABLE DETAIL 1 -->
<table class="table">
<tr>
<th>DETAIL</th><th>QUANTITE</th><th>PU HT</th><th>TOTAL HT</th><th>TVA</th>
</tr>
<tr>
<td>
CARACTÉRISTIQUES DE L'INSTALLATION<br>
Puissance nominale de la chaudière : {{ $document->puissance_chaudiere }} kW<br>
Nombre de logements concernés : {{ $document->nombre_logements }}<br>
Nombre d'émetteurs désemboués : {{ $document->nombre_emetteurs }}<br>
Zone climatique : {{ $document->zone_climatique }}<br>
Volume total du circuit d'eau: {{ $document->volume_circuit }} L<br>
Filtres : {{ $document->nombre_filtres }}<br>
KWH CUMAC : {{ $document->wh_cumac }}<br>
PRIME CEE : {{ number_format($document->prime_cee, 2, ',', ' ') }} €
</td>
<td></td><td></td><td></td><td></td>
</tr>
</table>

<div class="page-break"></div>

<!-- ================== PAGE 2 ================== -->
<table class="table">
<tr>
<td class="header-blue">REF DEVIS</td>
<td class="header-blue">{{ $document->reference_devis }}</td>
</tr>
<tr>
<td class="header-blue">DATE DEVIS</td>
<td class="header-blue">{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
</tr>
</table>

<!-- TABLE DETAIL LONG -->
<table class="table">
<tr>
<th>DETAIL</th><th>QUANTITE</th><th>PU HT</th><th>TOTAL HT</th><th>TVA</th>
</tr>
<tr>
<td>
Matériel(s) fourni(s) et mis en place par notre société {{ $document->society }}, Représentée par : M. Offel De Villaucourt Charles<br>
SIRET : {{ $document->reference }}<br><br>
1. - Réglage des organes d'équilibrage d'une installation de chauffage à eau chaude, destiné à assurer une température uniforme dans tous les locaux<br><br>
2. - Mise en place matériel d'équilibrage :<br>
▪ Relevé sur site de l'installation<br>
▪ Réalisation d'un plan du sous-sol des PDC<br>
▪ Réalisation d'un synoptique des colonnes<br>
▪ Réalisation d'une note de calcul des puissances de débits et réglages théoriques par logement<br>
▪ Réglage du point de fonctionnement de la pompe chauffage<br>
▪ Réalisation d'une mesure de débit sur les PDC et antennes<br>
▪ Un tableau d'enregistrement des températures moyennes sur un échantillon des logements, après équilibrage<br>
▪ L'écart de température entre l'appartement le plus chauffé et le moins chauffé doit être strictement inférieur à 2°C<br><br>
Note : Les quantités sont données à titre indicatif. Il appartient au maître d'ouvrage du présent lot de les valider. Les prix des appareillages comprennent leur fourniture, fixation et raccordement. Le marché est passé à prix global et forfaitaire.<br><br>
COMPRIS DANS LES TRAVAUX :<br>
▪ La dépose et l'enlèvement de votre ancien appareil<br>
▪ La protection et le nettoyage du chantier<br>
▪ Le remplissage et la purge de votre installation
</td>
<td>1<br><br>1</td>
<td>4 100,48<br><br>1 366,82</td>
<td>4 100,48<br><br>1 366,82</td>
<td>5,5 %<br><br>5,5 %</td>
</tr>
</table>

<div class="page-break"></div>

<!-- ================== PAGE FINALE ================== -->
<table class="table">
<tr>
<td class="header-blue">REF DEVIS</td>
<td class="header-blue">{{ $document->reference_devis }}</td>
</tr>
<tr>
<td class="header-blue">DATE DEVIS</td>
<td class="header-blue">{{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</td>
</tr>
</table>

<h2>Termes et conditions CEE</h2>
<p>Les travaux ou prestations objet du présent document donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous forme de prime, directement au(x) mandataire(s), sous réserve de l'engagement de fournir exclusivement à EBS ENERGIE les documents nécessaires à la valorisation des opérations au titre du dispositif des Certificats d'Économies d'Énergie et sous réserve de la validation de l'éligibilité du dossier par EBS ENERGIE puis par l'autorité administrative compétente.</p>
<p>Le montant de cette contribution financière, hors champ d'application de la TVA, est susceptible de varier en fonction des travaux effectivement réalisés et du volume des CEE attribués à l'opération et est estimé à <strong>{{ number_format($document->prime_cee, 2, ',', ' ') }} €</strong>.</p>

<br>

<table class="totals-grid">
<tr><td class="totals-label">TOTAL HT</td><td class="totals-value">{{ number_format($document->montant_ht, 2, ',', ' ') }} €</td></tr>
<tr><td class="totals-label">TVA à 5,5 %</td><td class="totals-value">{{ number_format($document->montant_tva, 2, ',', ' ') }} €</td></tr>
<tr><td class="totals-label">MONTANT TOTAL TTC</td><td class="totals-value">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €</td></tr>
<tr><td class="totals-label">PRIME CEE</td><td class="totals-value">- {{ number_format($document->prime_cee, 2, ',', ' ') }} €</td></tr>
<tr><td class="totals-label">RESTE A CHARGE</td><td class="totals-value">{{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</td></tr>
</table>

<br><br>
<p>Date et signature du bénéficiaire :</p>

</body>
</html>