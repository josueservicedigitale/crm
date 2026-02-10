<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        @page {
            margin: 10mm;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #000;
            line-height: 1.5;
        }

        .container {
            margin: 0 10mm;
        }

        p {
            margin: 6px 0;
            text-align: justify;
        }

        h1 {
            font-size: 13px;
            color: #c00000;
            margin: 10px 0 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        td {
            vertical-align: top;
        }

        .logos-top td {
            width: 33%;
        }

        .logos-top img {
            height: 60px;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .bordered td,
        .bordered th {
            border: 1px solid #000;
            padding: 6px;
        }

        .small {
            font-size: 10px;
        }

        .footer {
            position: fixed;
            bottom: -10mm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 4px;
        }

        .page-number:after {
            content: "Page " counter(page) " /" counter(pages);
        }

        .banner-container {
            position: relative;
            width: 100%;
            height: 180px;
            
            margin-top: 20px;
        }

        .banner-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .banner-overlay {
            position: relative;
            padding: 12px 30px;
            color: #000;
            font-size: 11px;
            line-height: 1.4;
        }

        .banner-overlay p {
            margin: 0 0 6px 0;
        }


        .underline {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- LOGOS HAUT -->
        <table class="logos-top">
            <tr>
                <td>
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_001.jpg') }}">
                </td>
                <td class="center">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_002.jpg') }}" width="80%" height="60px">
                </td>
                <td class="right">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_003.jpg') }}">
                </td>
            </tr>
        </table>

        <p>
            Le dispositif national des certificats d’économies d’énergie (CEE) mis en place par le Ministère en charge
            de l’énergie impose à
            l’ensemble des fournisseurs d’énergie (électricité, gaz, fioul domestique, chaleur ou froid, carburants
            automobiles), de réaliser des
            économies et de promouvoir les comportements vertueux auprès des consommateurs d’énergie.
        </p>

        <p>
            Dans le cadre de son partenariat avec la société EBS ENERGIE, la société ( M'Y HOUSE ) s’engage à vous
            apporter :
        </p>

        <table style="width:100%; border-collapse:collapse; margin-top:8px;">
            <tr>
                <td style="width:25px; vertical-align:top;">
                    <input type="checkbox">
                </td>
                <td>
                    une prime d’un montant de <span style="color: #007bff;">8 026,20 € *</span>  ;
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">
                    <input type="checkbox">
                </td>
                <td>
                    un bon d’achat pour des produits de consommation courante d’un montant de ______€ ;
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">
                    <input type="checkbox">
                </td>
                <td>
                    un prêt bonifié d’un montant de_____ euros proposé par ______au taux effectif global (TEG) de ____%
                    (valeur de la bonification = _____€)* ;
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">
                    <input type="checkbox">
                </td>
                <td>
                    un audit ou conseil personnalisé, sous forme écrite (valeur = ____€ ) ;
                </td>
            </tr>

            <tr>
                <td style="vertical-align:top;">
                    <input type="checkbox">
                </td>
                <td>
                    un produit ou service offert : ______[nature à préciser] d’une valeur de _______€
                </td>
            </tr>
        </table>

        <p style="margin-top:8px;">
            dans le cadre des travaux suivants (1 ligne par opération) :
        </p>



        <table class="bordered">
            <tr>
                <th>Nature des travaux</th>
                <th>Fiche CEE</th>
                <th>Conditions à respecter</th>
            </tr>
            <tr>
                <td>Désembouage d’un réseau hydraulique de chauffage collectif</td>
                <td class="center">BAR-SE-109</td>
                <td>Voir conditions sur le site du Ministère</td>
            </tr>
        </table>

        <div class="page-break">

            <!-- Bénéficiaire -->
            <p style="margin-top: 0;">
                Au bénéfice de : <span class="note-bleue">(Ajouter d'éventuelles autres conditions à respecter, ou
                    renvoyer
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
                *Montant de prime valable 3 mois à compter de la date d'édition du devis <span style="color: #f81520; font-weight: bold;">04/12/2025</span>
            </p>

            <!-- Conditions générales -->
            <p>
                Les montants de prime indiqués ci-dessus sont définis selon les fiches d'opérations standardisées
                disponibles sur le site du Ministère en charge de l'énergie, et pourront être actualisés en fonction des
                paramètres relatifs aux travaux réalisés et de la situation fiscale du ménage.
            </p>

            <p>
                Le présent engagement est pris dans le cadre de la période 5 (2022-2025) du dispositif des certificats
                d'économies d'énergie (CEE), institué par le Titre II du Livre II du Code de l'énergie. Cet engagement
                est
                non cumulable avec une autre offre liée au dispositif des Certificats d'Economies d'Energie.
            </p>

            <p>
                Cet engagement est valable pour les travaux réalisés jusqu'à 1 an après la date d'édition du devis (date
                de
                facture des travaux faisant foi).
            </p>

            <p>
                Dans le cadre de la réglementation, un contrôle qualité des travaux sur site ou par contact pourra être
                demandé. Un refus de ce contrôle sur site ou par contact via EBS ENERGIE ou un prestataire d'EBS ENERGIE
                conduira au refus de cette prime par EBS ENERGIE.
            </p>
            <div class="page-break"></div>

            <table class="logos-top">
            <tr>
                <td>
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_001.jpg') }}">
                </td>
                <td class="center">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_002.jpg') }}" width="80%" height="60px">
                </td>
                <td class="right">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_003.jpg') }}">
                </td>
            </tr>
        </table>
<br><br><br>

            <p class="spacing">Date de cette proposition : 04/12/2025</p>


            <!-- Note signature -->
            <p class="italic note-bleue spacing">
                Le présent document doit être signé au plus tard quatorze jours après la date d'engagement de
                l'opération,
                et en tout état de cause avant la date de début des travaux.
            </p>

            <!-- Bloc signature UNIQUE -->
            <div class="spacing">
                <p>NOM Prénom : Amblar Jean-Christophe</p>
                <p>Fonction : Président</p>

                <div class="signature-box">
                    <div class="center spacing">
                        <img src="{{ public_path('assets/img/house/cdc_files/image_005.png') }}" width="305" height="135" alt="image5">
                    </div>
                </div>
            </div>

        </div> <!-- Fin page 2 -->

        <br><br>

        <table>
            <tr>
                <td>
                    Signature :<br><br>
                    NOM Prénom : HAMLET TAMOYAN<br>
                    Fonction : Président
                </td>
                <td class="center">
                    Tampon et signature de la société
                </td>
            </tr>
        </table>

        <p class="small">
            Les montants de prime peuvent être actualisés selon les travaux réalisés.
        </p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        MYHOUSE — Tél : 01 43 92 28 32 — contact@ebs-energie.com
        <div class="page-number"></div>
    </div>

    <!-- ================== PAGE 2 ================== -->

    <div style="page-break-before:always" class="container">

         <table class="logos-top">
            <tr>
                <td>
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_001.jpg') }}">
                </td>
                <td class="center">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_002.jpg') }}" width="80%" height="60px">
                </td>
                <td class="right">
                    <img src="{{ public_path('assets/img/house/cdc_files/Image_003.jpg') }}">
                </td>
            </tr>
        </table>

        <br><br><br><br><br><br>

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
            <img src="{{ public_path('assets/img/house/cdc_files/image_009.png') }}" class="banner-img">

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


</body>

</html>