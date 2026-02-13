<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cdc</title>
    <style type="text/css">
        /* Réinitialisation et marges */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Calibri, sans-serif;
            font-size: 10pt;
            line-height: 1.3;
            color: black;
            margin: 40pt 30pt;
            /* Marges de 40pt haut/bas et 30pt gauche/droite */
            padding: 0;
        }

        /* Paragraphes */
        p {
            margin-bottom: 8pt;
            text-align: justify;
        }

        /* Listes */
        ul {
            margin-left: 30pt;
            margin-bottom: 10pt;
            padding-left: 0;
        }

        li {
            margin-bottom: 4pt;
            list-style-type: disc;
        }

        /* Tableaux */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10pt 0 15pt 0;
        }

        td {
            border: 1px solid black;
            padding: 8pt;
            vertical-align: top;
        }

        /* Titres et mise en forme */
        h1 {
            color: #F00;
            font-size: 10pt;
            font-weight: bold;
            margin: 15pt 0 10pt 0;
            text-align: justify;
        }

        .blue-text {
            color: #4F81BC;
            font-weight: bold;
        }

        .red-text {
            color: #F00;
        }

        .italic {
            font-style: italic;
        }

        .center {
            text-align: center;
        }

        .small {
            font-size: 8pt;
        }

        .underline {
            text-decoration: underline;
        }

        /* Signature */
        .signature-box {
            border: 2px solid black;
            height: 120pt;
            margin-top: 30pt;
            position: relative;
        }

        .signature-left {
            position: absolute;
            bottom: 10pt;
            left: 15pt;
            color: #4F81BC;
            font-size: 10pt;
        }

        .signature-right {
            position: absolute;
            bottom: 10pt;
            right: 15pt;
            color: #4F81BC;
            font-size: 10pt;
        }

        /* Espacement des logos en-tête */
        .logo-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20pt;
        }

        .logo-table td {
            border: none;
            padding: 10pt;
            vertical-align: middle;
        }

        /* Sauts de page */
        .page-break {
            page-break-before: always;
            margin-top: 40pt;
        }

        /* Espacement */
        .spacing {
            margin-top: 15pt;
        }

        /* Liens */
        a {
            color: #00F;
            text-decoration: underline;
        }

        /* Couleurs spécifiques */
        .table-header {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .nature-travaux {
            color: #1854C1;
        }

        .fiche-cee {
            color: #006FC0;
            font-weight: bold;
            text-align: center;
        }

        .note-bleue {
            color: #4471C4;
            font-style: italic;
        }

        .banner-container {
            position: relative;
            width: 699px;
            height: 158px;
            margin-top: 30pt;
        }

        .banner-container img {
            width: 699px;
            height: 158px;
        }

        .banner-overlay {
            position: absolute;
            top: 15px;
            left: 40px;
            right: 40px;
            font-size: 8.5pt;
            line-height: 1.35;
            color: #000;
        }

        .banner-overlay p {
            margin-bottom: 6pt;
        }
    </style>
</head>

<body>
    <!-- ====== PAGE 1 ====== -->

    <!-- Logos en haut -->

    <!-- ====== EN-TÊTE AVEC 3 LOGOS ====== -->
    <table class="logo-table">
        <tr>
            <td width="33%" align="right">
                <img src="/assets/img/rehouse/Cdc_files/image_001.jpg" width="176" height="70" alt="logo1">
            </td>
            <td width="33%" align="left">
                <img src="/assets/img/rehouse/Cdc_files/image_002.jpg" width="211" height="46" alt="logo2">
            </td>

            <td width="34%" align="center">
                <img src="/assets/img/rehouse/Cdc_files/image_003.jpg" width="209" height="48" alt="Logo 3">
            </td>


        </tr>
    </table>
    <!-- Introduction -->
    <p>
        Le dispositif national des certificats d'économies d'énergie (CEE) mis en place par le Ministère en charge de
        l'énergie impose à l'ensemble des fournisseurs d'énergie (électricité, gaz, fioul domestique, chaleur ou froid,
        carburants automobiles), de réaliser des économies et de promouvoir les comportements vertueux auprès des
        consommateurs d'énergie.
    </p>

    <!-- Engagement -->
    <p>
        Dans le cadre de son partenariat avec la société EBS ENERGIE, la société ( M'Y HOUSE ) s’engage à vous apporter
        :
    </p>

    <ul>
        <li>une prime d'un montant de <span class="blue-text">{{ $document->prime_cee }} €*</span> ;</li>
        <li>un bon d'achat pour des produits de consommation courante d'un montant de <span class="blue-text">€</span> ;
        </li>
        <li>un prêt bonifié d'un montant de euros proposé par au taux effectif global (TEG) de % (valeur de la
            bonification = €)* ;</li>
        <li>un audit ou conseil personnalisé, sous forme écrite (valeur = un produit ou service offert : [nature à
            préciser] d'une valeur de €) ;</li>
    </ul>

    <p style="padding-left: 40pt; margin-bottom: 15pt;">
        dans le cadre des travaux suivants (1 ligne par opération) :
    </p>

    <!-- Tableau des travaux -->
    <table>
        <tr>
            <td class="table-header" style="width: 40%;">Nature des travaux</td>
            <td class="table-header" style="width: 20%;">Fiche CEE</td>
            <td class="table-header" style="width: 40%;">Conditions à respecter</td>
        </tr>
        <tr>
            <td class="nature-travaux">Réglage des organes
                d’équilibrage d’une
                installation de chauffage
                à eau chaude
            <td class="fiche-cee">BAR-SE-104
            <td>
                <a href="http://www.ecologique-solidaire.gouv.fr/operations-standardisees-deconomies-denergie">
                    Voir le site du Ministère de l'Écologie et de la Transition Écologique et Solidaire
                </a>
            </td>
        </tr>
    </table>

    <!-- ====== PAGE 2 (débute à "au bénéfice de") ====== -->
    <div class="page-break">

        <!-- Bénéficiaire -->
        <p style="margin-top: 0;">
            Au bénéfice de : <span class="note-bleue">(Ajouter d'éventuelles autres conditions à respecter, ou renvoyer
                à des conditions contractuelles)</span>
        </p>

        <ul>
            <li>Nom : BBR MAINTENANCE</li>
            <li>Prénom :</li>
            <li>Adresse : 78 AVENUE DES CHAMPS ELYSEES, 75008 PARIS</li>
            <li>Téléphone : 01 85 09 74 35</li>
            <li>Adresse E-mail : <a href="mailto:tech@bbrmaintenance.fr">tech@bbrmaintenance.fr</a></li>
        </ul>

        <!-- Note sur la prime -->
        <p class="italic spacing">
            *Montant de prime valable 3 mois à compter de la date d'édition du devis <span
                class="red-text">04/12/2025</span>
        </p>

        <!-- Conditions générales -->
        <p>
            Les montants de prime indiqués ci-dessus sont définis selon les fiches d'opérations standardisées
            disponibles sur le site du Ministère en charge de l'énergie, et pourront être actualisés en fonction des
            paramètres relatifs aux travaux réalisés et de la situation fiscale du ménage.
        </p>

        <p>
            Le présent engagement est pris dans le cadre de la période 5 (2022-2025) du dispositif des certificats
            d'économies d'énergie (CEE), institué par le Titre II du Livre II du Code de l'énergie. Cet engagement est
            non cumulable avec une autre offre liée au dispositif des Certificats d'Economies d'Energie.
        </p>

        <p>
            Cet engagement est valable pour les travaux réalisés jusqu'à 1 an après la date d'édition du devis (date de
            facture des travaux faisant foi).
        </p>

        <p>
            Dans le cadre de la réglementation, un contrôle qualité des travaux sur site ou par contact pourra être
            demandé. Un refus de ce contrôle sur site ou par contact via EBS ENERGIE ou un prestataire d'EBS ENERGIE
            conduira au refus de cette prime par EBS ENERGIE.
        </p>

        <p class="spacing">Date de cette proposition : 04/12/2025</p>


        <!-- Note signature -->
        <p class="italic note-bleue spacing">
            Le présent document doit être signé au plus tard quatorze jours après la date d'engagement de l'opération,
            et en tout état de cause avant la date de début des travaux.
        </p>

        <!-- Bloc signature UNIQUE -->
        <div class="spacing">
            <p>NOM Prénom : Amblar Jean-Christophe</p>
            <p>Fonction : Président</p>

            <div class="signature-box">
                <div class="center spacing">
                    <img src="/assets/img/rehouse/Cdc_files/image_005.png" width="305" height="135" alt="image5">
                </div>
            </div>
        </div>

    </div> <!-- Fin page 2 -->

    <!-- ====== PAGE 3 (débute avec les logos 4, 5, 6) ====== -->
    <div class="page-break">

        <!-- Logos intermédiaires -->
        <div class="logo-row">
            <img src="/assets/img/rehouse/Cdc_files/image_006.jpg" width="192" height="77" alt="logo4">
            <img src="/assets/img/rehouse/Cdc_files/image_007.jpg" width="211" height="46" alt="logo5">
            <img src="/assets/img/rehouse/Cdc_files/image_008.jpg" width="209" height="48" alt="logo6">
        </div>

        <!-- Avertissement -->
        <h1>
            /!\ Faites réaliser plusieurs devis afin de prendre une décision éclairée. Attention, seules les
            propositions remises avant l'acceptation du devis ou du bon de commande sont valables, et vous ne pouvez pas
            cumuler plusieurs offres CEE différentes pour la même opération.
        </h1>
        <!-- Dernier avertissement -->
        <h1 class="spacing">
            /!\ Seul le professionnel est responsable de la conformité des travaux que vous lui confiez. Vérifiez ses
            qualifications techniques et l'éligibilité des produits proposés avant d'engager vos travaux. Un contrôle
            des travaux effectués dans votre logement pourra être réalisé sur demande de EBS ENERGIE ou des autorités
            publiques.
        </h1>
        <!-- Informations de contact -->
        <!-- Bannière avec textes dessus -->
        <div class="banner-container">
            <img src="/assets/img/rehouse/Cdc_files/image_009.png" alt="banniere">

            <div class="banner-overlay">
                <p>
                    Où se renseigner pour bénéficier de cette offre ?
                    https://www.ebs-energie.com/ +33(0)1 43 92 28 32
                </p>

                <p class="underline">
                    Où s'informer sur les aides pour les travaux d'économies d'énergie ? :
                    Site du réseau FAIRE : https://www.faire.gouv.fr
                </p>

                <p>
                    En cas de litige avec le porteur de l'offre ou son partenaire, vous pouvez faire appel gratuitement
                    au médiateur de la consommation (article L.611-1 du code de la consommation)
                    <strong>Médiation de la Consommation & Patrimoine</strong> via le site
                    www.mcpmediation.org, ou par courrier : 12 Square Desnouettes - 75015 PARIS
                    ou par téléphone au 01.40.61.03.33
                </p>
            </div>
        </div>

    </div> <!-- Fin page 3 -->
</body>

</html>