<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <title>Devis M'YHOUSE-2025-D{{ $document->reference_devis }}</title>

    <style>
        /* ===========================
       DOMPDF SAFE – A4 + MARGES
       =========================== */
        @page {
            size: A4;
            margin: 15mm 15mm;
            /* >= 1cm (OK) */
        }

        :root {
            --green: #80A150;
            --txt: #000;
            --frame: 180mm;
            /* 210 - 15 - 15 */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: Calibri, Arial, sans-serif;
            font-size: 8pt;
            /* ↓ un peu pour tenir en 3 pages */
            line-height: 1.22;
            color: var(--txt);
            background: #fff;
        }

        /* Page wrapper (empêche le "plein bord") */
        .page {
            page-break-after: always;
            margin: 5mm;
        }

        .page:last-child {
            page-break-after: avoid;
        }


        .page-content {
            width: var(--frame);
            margin: 0 auto;
            /* centre + garde les marges */
            padding-bottom: 16mm;
            /* espace réservé footer */
        }

        /* Header (comme capture) */
        .header {
            margin-bottom: 4mm;
        }

        .logo {
            width: 165px;
            /* ↓ léger */
            height: auto;
            display: block;
            margin-bottom: 4px;
        }

        .bar {
            display: inline-block;
            background: var(--green);
            color: #fff;
            font-weight: 700;
            font-size: 9pt;
            padding: 4px 10px;
        }

        /* TOP infos (page 1) */
        table.top-grid {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 4px;
        }

        table.top-grid td {
            border: none;
            vertical-align: top;
            padding: 0;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        .left-info {
            padding-right: 8mm;
        }

        .left-info p {
            margin: 1.2px 0;
            font-size: 8.2pt;
        }

        .left-info h4 {
            margin: 5px 0 3px 0;
            font-size: 8.6pt;
            font-weight: 700;
        }

        .right-box {
            border: 1px solid var(--green);
            padding: 6px;
            text-align: right;
            font-size: 8.2pt;
            line-height: 1.25;
        }

        .right-box .title {
            font-size: 10pt;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .right-box p {
            margin: 1.2px 0;
        }

        /* TABLE principal (comme capture) */
        table.main {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-top: 6px;
        }

        table.main th,
        table.main td {
            border: 2px solid var(--green);
            padding: 4px;
            /* ↓ */
            vertical-align: top;
            word-break: break-word;
            overflow-wrap: anywhere;
        }

        table.main thead th {
            background-color: #80A150;
            color: #fff;
            font-weight: 700;
            font-size: 8.5pt;
        }

        /* Largeurs colonnes (comme ton modèle) */
        .col-detail {
            width: 55%;
        }

        .col-qte {
            width: 10%;
            text-align: center;
        }

        .col-pu {
            width: 13%;
            text-align: right;
        }

        .col-total {
            width: 12%;
            text-align: right;
        }

        .col-tva {
            width: 10%;
            text-align: center;
        }

        /* Styles texte */
        .s6 {
            font-size: 7.6pt;
            line-height: 1.22;
        }

        .s7 {
            font-size: 7.8pt;
            font-weight: 700;
        }

        .s8 {
            font-size: 9.2pt;
            font-weight: 700;
        }

        .bold {
            font-weight: 700;
        }

        /* Listes (comme capture) */
        .dash-list,
        .bullet-list,
        .square-list {
            list-style: none;
            margin: 0;
            padding-left: 10px;
        }

        .dash-list li,
        .bullet-list li,
        .square-list li {
            position: relative;
            margin: 0 0 3px 0;
            padding-left: 10px;
        }

        .dash-list li:before {
            content: "-";
            position: absolute;
            left: 0;
            top: 0;
        }

        .bullet-list li:before {
            content: "•";
            position: absolute;
            left: 0;
            top: 0;
        }

        .square-list li:before {
            content: "▪";
            position: absolute;
            left: 0;
            top: 0;
        }

        /* Mini espacements */
        .mt-6 {
            margin-top: 6px;
        }

        .mt-8 {
            margin-top: 8px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-12 {
            margin-top: 12px;
        }

        /* ✅ Footer DANS chaque page (évite la page 4 bug dompdf) */
        .footer {
            position: fixed;
            left: 15mm;
            right: 15mm;
            bottom: 8mm;
            text-align: center;
            font-size: 7.4pt;
            color: #333;
            border-top: 1px solid var(--green);
            padding-top: 2.5mm;
        }

        .pageno {
            position: fixed;
            right: 15mm;
            bottom: 8.5mm;
            font-size: 7.6pt;
            color: #333;
        }

        /* Empêche dompdf de casser au milieu de blocs */
        .avoid-break {
            page-break-inside: avoid;
        }

        /* ======= PAGE 3: blocs texte + cadre gris ======= */
.block{ margin-top: 8mm; }
.section-title{
  font-weight:700;
  font-size: 8.6pt;
  margin-bottom: 2mm;
}
.para{
  font-size: 7.6pt;
  line-height: 1.25;
  margin-bottom: 2mm;
}

/* Cadre gris signature/totaux */
.summary-box{
  margin-top: 6mm;
  background:#ededed;
  border:1px solid #cfcfcf;
  padding: 6mm;
  min-height: 40mm;        /* ✅ crée le grand espace gris comme la capture */
  position: relative;
}

.summary-grid{
  width:100%;
  border-collapse: collapse;
  table-layout: fixed;
}
.summary-left{
  width:65%;
  vertical-align: top;
  padding-right: 6mm;
}
.summary-right{
  width:35%;
  vertical-align: top;
}

.sign-title{ font-size: 7.6pt; margin-bottom: 1mm; }
.sign-sub{ font-size: 7.2pt; margin-bottom: 4mm; color:#222; }

.sign-image-wrap{
  margin-top: 6mm;
  min-height: 35mm; /* garde l'espace même si l'image est petite */
}
.sign-image{
  width: 300px;   /* ajuste selon ton image */
  height: auto;
  display:block;
}

/* Totaux à droite */
.totals{
  width:100%;
  border-collapse: collapse;
}
.totals td{
  font-size: 7.6pt;
  padding: 1mm 0;
}
.t-lbl{ text-align:right; padding-right: 4mm; color:#111; }
.t-val{ text-align:right; color:#111; }

.reste{ color:#7b8f00; } /* vert/olive comme sur capture */

.paymode{
  position: absolute;
  left: 6mm;
  bottom: 4mm;
  font-size: 7.2pt;
  color:#111;
}
    </style>
</head>

<body>

    <!-- ===================== PAGE 1/3 ===================== -->
    <div class="page">
        <div class="page-content">

            <div class="header">
                <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="MY HOUSE"
                    class="logo"><br>
                <div class="bar">DEVIS M'YHOUSE-2025-D{{ $document->reference_devis }}</div>
            </div>

            <table class="top-grid">
                <tr>
                    <td class="left-info" style="width:60%;">
                        <p><span class="bold">Date :</span>
                            {{ \Carbon\Carbon::parse($document->date_devis)->format('d/m/Y') }}</p>

                        <h4>ADRESSE DES TRAVAUX :</h4>
                        <p>{{ $document->adresse_travaux }}</p>

                        <p><span class="bold">Parcelle cadastrale :</span>
                            {{ $document->parcelle_1 }} {{ $document->parcelle_2 }} {{ $document->parcelle_3 }}
                            {{ $document->parcelle_4 }}
                        </p>

                        <p><span class="bold">N° immatriculation :</span> {{ $document->numero_immatriculation }}</p>
                        <p><span class="bold">Nombre bâtiments :</span> {{ $document->nombre_batiments }} Bâtiments</p>
                        <p><span class="bold">Détails bâtiments :</span> {{ $document->details_batiments }}</p>
                        <p><span class="bold">Nom résidence :</span> {{ $document->nom_residence }}</p>
                        <p><span class="bold">Date travaux :</span> {{ $document->dates_previsionnelles }}</p>
                    </td>

                    <td style="width:40%;">
                        <div class="right-box">
                            <div class="title">BBR MAINTENANCE</div>
                            <p>Siret : 93146162800030</p>
                            <p>78 AVENUE DES CHAMPS ELYSEES</p>
                            <p>75008 PARIS</p>
                            <p>Tél : 01 85 09 74 35</p>
                            <p>Mail : tech@bbrmaintenance.fr</p>
                            <p>Représenté par : M. Poulin Thomas</p>
                            <p>Directeur des Services Techniques</p>
                        </div>
                    </td>
                </tr>
            </table>

            <table class="main">
                <thead>
                    <tr>
                        <th class="col-detail">Détail</th>
                        <th class="col-qte">Quantité</th>
                        <th class="col-pu">P.U HT</th>
                        <th class="col-total">Total HT</th>
                        <th class="col-tva">TVA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-detail">
                            <ul class="dash-list">
                                <li>
                                    <p class="s6">
                                        Désembouage de l'ensemble du système de distribution par boucle d'eau d'une
                                        installation de chauffage
                                        collectif alimentée par une chaudière utilisant un combustible fossile ou
                                        alimentée par un réseau de chaleur
                                    </p>

                                    <p class="s6 mt-8">
                                        Opération entrant dans le dispositif de prime C.E.E. (Certificat d'Economie
                                        d'Energie), conforme aux
                                        recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le
                                        ministère de la Transition énergétique.
                                    </p>

                                    <p class="s6 mt-8"><span class="bold">Kwh Cumac :</span> {{ $document->wh_cumac }}
                                    </p>
                                    <p class="s6"><span class="bold">Prime CEE :</span>
                                        {{ number_format($document->prime_cee, 2, ',', ' ') }} €</p>
                                </li>

                                <li>
                                    <p class="s6 mt-8">
                                        <span class="bold">Matériel(s) fourni(s) et mis en place par notre société M'Y
                                            HOUSE</span>, représentée par
                                        Amblar Jean-Christophe, SIRET <span class="bold">89155600300046</span>
                                    </p>

                                    <p class="s6 mt-8"><span class="bold">Installation collective de chauffage alimentée
                                            par une chaudière hors condensation</span></p>

                                    <p class="s6"><span class="bold">Puissance nominale de la chaudière :</span>
                                        {{ $document->puissance_chaudiere }} Kw</p>
                                    <p class="s6"><span class="bold">Nombre de logements concernés :</span>
                                        {{ $document->nombre_logements }}</p>
                                    <p class="s6"><span class="bold">Nombre d'émetteurs désemboués :</span>
                                        {{ $document->nombre_emetteurs }}</p>
                                    <p class="s6"><span class="bold">Nature du réseau :</span> Acier</p>
                                    <p class="s6"><span class="bold">Volume total du circuit :</span>
                                        {{ $document->volume_circuit }} L</p>

                                    <p class="s8 mt-10">DETAIL DE LA PRESTATION</p>
                                    <p class="s7 mt-6">LE DÉSEMBOUAGE COMPORTE LES ÉTAPES SUCCESSIVES SUIVANTES :</p>

                                    <p class="s7 mt-8">A. INJECTION D'UN RÉACTIF DÉSEMBOUANT ET CIRCULATION</p>
                                    <p class="s6 mt-6">PREPARATION ET DIAGNOSTIC INITIAL</p>

                                    <ul class="bullet-list mt-6">
                                        <li>
                                            <p class="s6">Vérification de l'état général de l'installation de chauffage
                                            </p>
                                        </li>
                                        <li>
                                            <p class="s6">Contrôle de la pression et de l'étanchéité du circuit</p>
                                        </li>
                                        <li>
                                            <p class="s6">Test de fonctionnement des vannes et organes de régulation</p>
                                        </li>
                                        <li>
                                            <p class="s6">Relevé des températures et pressions de fonctionnement</p>
                                        </li>
                                    </ul>

                                    <p class="s6 mt-8">Injection du produit désembouant SENTINEL X800</p>
                                    <ul class="bullet-list mt-6">
                                        <li>
                                            <p class="s6">Dosage : 1% du volume d'eau de l'installation</p>
                                        </li>
                                        <li>
                                            <p class="s6">Méthode d'injection : Via un point d'injection dédié ou par le
                                                vase d'expansion</p>
                                        </li>
                                        <li>
                                            <p class="s6">Dilution : Mélange homogène du produit dans l'ensemble du
                                                circuit</p>
                                        </li>
                                    </ul>

                                    <p class="s6 mt-8">CIRCULATION AVEC POMPE DE DÉSEMBOUAGE</p>
                                    <ul class="bullet-list mt-6">
                                        <li>
                                            <p class="s6">Équipement utilisé : Pompe de désembouage haute performance
                                                (débit minimum 30 L/min)</p>
                                        </li>
                                        <li>
                                            <p class="s6">Circulation générale :</p>
                                            <ul class="bullet-list mt-6" style="padding-left:12px;">
                                                <li>
                                                    <p class="s6">Mise en circulation sur l'ensemble du réseau pendant 4
                                                        heures minimum</p>
                                                </li>
                                                <li>
                                                    <p class="s6">Température de circulation : 50-60°C pour optimiser
                                                        l'action du produit</p>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="s6">Circulation réseau par réseau :</p>
                                            <ul class="bullet-list mt-6" style="padding-left:12px;">
                                                <li>
                                                    <p class="s6">Isolation et traitement de chaque réseau de
                                                        distribution individuellement</p>
                                                </li>
                                                <li>
                                                    <p class="s6">Circulation dans les deux sens pour décoller tous les
                                                        dépôts</p>
                                                </li>
                                                <li>
                                                    <p class="s6">Durée par réseau : 2 heures minimum dans chaque sens
                                                    </p>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <p class="s6">Surveillance : Contrôle visuel de la couleur de l'eau (passage
                                                du trouble au clair)</p>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </td>

                        <td class="col-qte">
                            <p>{{ $document->nombre_logements }}</p>
                        </td>
                        <td class="col-pu">
                            <p>{{ number_format($document->montant_ht, 2, ',', ' ') }} €</p>
                        </td>
                        <td class="col-total">
                            <p>{{ number_format($document->montant_ht, 2, ',', ' ') }} €</p>
                        </td>
                        <td class="col-tva">
                            <p>20 %</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="footer">
                M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom :
                FR12891556003<br>
                Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
            </div>
            <div class="pageno">1/3</div>

            <div class="pageno">1/3</div>
        </div>
    </div>

    <!-- ===================== PAGE 2/3 ===================== -->
    <div class="page">
        <div class="page-content">

            <div class="header">
                <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="MY HOUSE"
                    class="logo"><br>
                <div class="bar">DEVIS M'YHOUSE-2025-D{{ $document->reference_devis }}</div>
            </div>

            <!-- ✅ Même tableau + TH (comme page 1) -->
            <table class="main">
                <thead>
                    <tr>
                        <th class="col-detail">Détail</th>
                        <th class="col-qte">Quantité</th>
                        <th class="col-pu">P.U HT</th>
                        <th class="col-total">Total HT</th>
                        <th class="col-tva">TVA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="col-detail">
                            <p class="s7">B. RINÇAGE DES CIRCUITS À L'EAU CLAIRE</p>
                            <p class="s6 mt-6">RINÇAGE GENERAL</p>

                            <ul class="bullet-list mt-6">
                                <li>
                                    <p class="s6">Évacuation complète du produit désembouant par les points de purge</p>
                                </li>
                                <li>
                                    <p class="s6">Remplissage progressif à l'eau claire du réseau public</p>
                                </li>
                                <li>
                                    <p class="s6">Circulation intensive pendant 2 heures minimum</p>
                                </li>
                                <li>
                                    <p class="s6">Contrôle qualité : Vérification de la limpidité de l'eau en sortie</p>
                                </li>
                            </ul>

                            <p class="s7 mt-10">SENTINEL X100 INHIBITEUR</p>
                            <p class="s6 mt-6">
                                Sentinel X100 Inhibiteur pour protection du réseau de chauffage avec solution aqueuse
                                d'agents inhibiteurs
                                de corrosion et anti-tartre.
                            </p>

                            <ul class="bullet-list mt-6">
                                <li>
                                    <p class="s6">Dosage : 1% du volume d'eau de l'installation, soit 1 litre pour 100
                                        litres d'eau</p>
                                </li>
                                <li>
                                    <p class="s6">Aspect : Liquide clair, incolore à jaune pâle</p>
                                </li>
                                <li>
                                    <p class="s6">Densité (20°C) : 1,10 g/ml</p>
                                </li>
                                <li>
                                    <p class="s6">pH (concentré) : Environ 6,4</p>
                                </li>
                                <li>
                                    <p class="s6">Point de congélation : -2,5°C</p>
                                </li>
                                <li>
                                    <p class="s6">Agréé par le ministère de la Santé</p>
                                </li>
                            </ul>

                            <p class="s7 mt-10">C. VÉRIFICATION/INSTALLATION FILTRE ET INJECTION INHIBITEUR</p>
                            <p class="s6 mt-6">VERIFICATION DU SYSTEME DE FILTRATION EXISTANT</p>

                            <ul class="bullet-list mt-6">
                                <li>
                                    <p class="s6">Localisation des filtres à boues existants sur les circuits de retour
                                    </p>
                                </li>
                                <li>
                                    <p class="s6">Démontage et nettoyage des filtres en place</p>
                                </li>
                                <li>
                                    <p class="s6">Contrôle d'efficacité : Vérification du maillage et de l'état général
                                    </p>
                                </li>
                            </ul>

                            <p class="s6 mt-8">INJECTION DU REACTIF INHIBITEUR SENTINEL X100</p>
                            <ul class="bullet-list mt-6">
                                <li>
                                    <p class="s6">Dosage : 1% du volume d'eau de l'installation</p>
                                </li>
                                <li>
                                    <p class="s6">Méthode d'injection : Via point d'injection dédié</p>
                                </li>
                                <li>
                                    <p class="s6">Circulation : Mise en route de la circulation pendant 30 minutes
                                        minimum</p>
                                </li>
                                <li>
                                    <p class="s6">Homogénéisation : Vérification de la répartition uniforme du produit
                                    </p>
                                </li>
                            </ul>

                            <p class="s6 mt-8">CONTROLES FINAUX ET MISE EN SERVICE</p>
                            <ul class="bullet-list mt-6">
                                <li>
                                    <p class="s6">Test de fonctionnement complet de l'installation</p>
                                </li>
                                <li>
                                    <p class="s6">Relevé des paramètres : Température, pression, débit</p>
                                </li>
                                <li>
                                    <p class="s6">Réglages : Ajustement des organes de régulation</p>
                                </li>
                                <li>
                                    <p class="s6">Formation : Explication du fonctionnement au personnel technique</p>
                                </li>
                                <li>
                                    <p class="s6">Documentation : Remise du certificat de désembouage et planning de
                                        maintenance</p>
                                </li>
                            </ul>

                            <p class="s8 mt-10">MATÉRIEL ET ENTREPRISE</p>
                            <p class="s6 mt-6">
                                Matériel(s) fourni(s) et mis en place par <span class="bold">M'Y HOUSE</span>, 5051 rue
                                du Pont Long,
                                64160 Buros, SIRET <span class="bold">89155600300046</span>, Code APE 4322B.
                            </p>
                            <p class="s6 mt-6">
                                Représentée par <span class="bold">M. Amblar Jean-Christophe</span>, 05 59 60 21 51
                                contact@myhouse64.fr
                            </p>

                            <p class="s6 mt-8"><span class="bold">Durée totale de l'intervention</span> : 1 à 2 jours
                                selon la complexité</p>
                            <p class="s6"><span class="bold">Garantie</span> : 2 ans sur l'intervention de désembouage
                            </p>
                            <p class="s6"><span class="bold">Suivi</span> : Contrôle recommandé à 6 mois puis
                                annuellement</p>

                            <p class="s6 mt-8">
                                Qualification <span class="bold">Qualisav Spécialité Désembouage N° 32056 - ID N°
                                    S01946</span>
                            </p>
                        </td>

                        <!-- Colonnes vides comme capture -->
                        <td class="col-qte"></td>
                        <td class="col-pu"></td>
                        <td class="col-total"></td>
                        <td class="col-tva"></td>
                    </tr>
                </tbody>
            </table>
            <div class="footer">
                M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom :
                FR12891556003<br>
                Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
            </div>
            <div class="pageno">2/3</div>
        </div>
    </div>

    <!-- ===================== PAGE 3/3 ===================== -->
    <div class="page">
        <div class="page-content">

            <div class="header">
                <img src="{{ public_path('assets/img/house/Devis_files/Image_001.jpg') }}" alt="MY HOUSE"
                    class="logo"><br>
                <div class="bar">DEVIS M'YHOUSE-2025-D{{ $document->reference_devis }}</div>
            </div>

            <!-- TITRE + TEXTE : CONDITIONS DE PAIEMENT -->
            <div class="block">
                <div class="section-title">CONDITIONS DE PAIEMENT</div>
                <div class="para">
                    « Les travaux ou prestations objet du présent document donneront lieu à une contribution financière
                    de EBS ENERGIE
                    (SIREN 533 333 118), versée par EBS ENERGIE dans le cadre de son rôle incitatif sous forme de prime,
                    directement ou via
                    son (ses) mandataire(s), sous réserve de l'engagement de fournir exclusivement à EBS Energie les
                    documents nécessaires
                    à la valorisation des opérations au titre du dispositif des Certificats d'Économies d'Énergie et
                    sous réserve de la
                    validation de l'éligibilité du dossier par EBS ENERGIE puis par l'autorité administrative
                    compétente.
                </div>
                <div class="para">
                    Le montant de cette contribution financière, hors champ d'application de la TVA, est susceptible de
                    varier en fonction
                    des travaux effectivement réalisés et du volume des CEE attribués à l'opération et est estimé à
                    {{ number_format($document->prime_cee, 2, ',', ' ') }} euros ».
                </div>
            </div>

            <!-- TITRE + TEXTE : GESTION DES DÉCHETS -->
            <div class="block">
                <div class="section-title">Gestion de déchets</div>
                <div class="para">
                    Gestion, évacuation et traitements des déchets de chantier comprenant la main d'œuvre liée à la
                    dépose et au tri,
                    le transport des déchets de chantiers vers un ou plusieurs points de collecte et coûts de
                    traitement.
                </div>
            </div>

            <!-- GRAND CADRE GRIS (signature + totaux) -->
            <div class="summary-box">
                <table class="summary-grid">
                    <tr>
                        <!-- GAUCHE : signature -->
                        <td class="summary-left">
                            <div class="sign-title">
                                <span class="bold">Signature, date, cachet commercial &amp; mention « Bon pour accord »
                                    :</span>
                            </div>
                            <div class="sign-sub">Nom, prénom et fonction du signataire</div>

                            <!-- ✅ IMAGE UNIQUE cachet/signature -->
                            <div class="sign-image-wrap">
                                <img src="{{ public_path('assets/img/house/Facture_files/Image_005.png') }}"
                                    alt="Cachet et signature" class="sign-image">
                            </div>
                        </td>

                        <!-- DROITE : totaux -->
                        <td class="summary-right">
                            <table class="totals">
                                <tr>
                                    <td class="t-lbl">Total H.T</td>
                                    <td class="t-val">{{ number_format($document->montant_ht, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="t-lbl">Total TVA 20%</td>
                                    <td class="t-val">{{ number_format($document->montant_tva, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="t-lbl bold">Total TTC</td>
                                    <td class="t-val bold">{{ number_format($document->montant_ttc, 2, ',', ' ') }} €
                                    </td>
                                </tr>
                                <tr>
                                    <td class="t-lbl">* Prime CEE</td>
                                    <td class="t-val">- {{ number_format($document->prime_cee, 2, ',', ' ') }} €</td>
                                </tr>
                                <tr>
                                    <td class="t-lbl reste bold">Reste à payer</td>
                                    <td class="t-val reste bold">
                                        {{ number_format($document->reste_a_charge, 2, ',', ' ') }} €</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <div class="paymode">Mode de paiement : Chèques, virement ou espèce</div>
            </div>

        </div>

        <!-- Footer DANS la page (anti page blanche dompdf) -->
        <div class="footer">
            M'Y HOUSE au capital de 7 500 € - Code APE 4322B SIRET : 89155600300046 - rcs Pau- N° TVA Intracom :
            FR12891556003<br>
            Tél. : 05 59 60 21 51 Mail : contact@myhouse64.fr
        </div>
        <div class="pageno">3/3</div>
    </div>
    </div>
    =

</body>

</html>