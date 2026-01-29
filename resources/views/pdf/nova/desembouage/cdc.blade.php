<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-us" lang="en-us">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>cdc</title>
    <meta name="author" content="Florence Olive" />
    <style type="text/css">
        @page {
            margin: 20mm;
        }

        /* Global reset + box-sizing to avoid overflow issues */
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
            box-sizing: border-box;
        }

        /* Container padding to enforce inner margins */
        .content-container {
            padding: 6mm;
            padding-bottom: 25mm;
        }

        /* Footer and page numbering */
        .footer {
            position: fixed;
            bottom: 10mm;
            left: 0;
            right: 0;
            font-size: 8pt;
            color: #333;
            text-align: center;
            border-top: 1px solid #003366;
            padding-top: 3mm;
            width: 100%;
        }

        .page-number {
            position: fixed;
            bottom: 8mm;
            right: 15mm;
            font-size: 8pt;
            color: #003366;
        }

        .page-number:after {
            content: "Page " counter(page) " / " counter(pages);
        }

        .p,
        p {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
            margin: 0pt;
        }

        .s1 {
            color: black;
            font-family: Symbol, serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s2 {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s4 {
            color: black;
            font-family: Symbol, serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s5 {
            color: black;
            font-family: "Times New Roman", serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s6 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s7 {
            color: #4F81BC;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s8 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s9 {
            color: #1753C1;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s10 {
            color: #006FC0;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s12 {
            color: #00F;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 8pt;
        }

        .s14 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s15 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s17 {
            color: #4471C4;
            font-family: Calibri, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s18 {
            color: #4470C4;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
        }

        .s19 {
            color: #4471C4;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
        }

        .s20 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: italic;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s21 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 10pt;
            vertical-align: 38pt;
        }

        h1 {
            color: #F00;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s22 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 8pt;
        }

        .a {
            color: #00F;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: underline;
            font-size: 8pt;
        }

        .s23 {
            color: #4471C4;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s24 {
            color: #00F;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s25 {
            color: #00F;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s26 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s27 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s28 {
            color: #545454;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        li {
            display: block;
        }

        #l1 {
            padding-left: 0pt;
        }

        #l1>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Symbol, serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }
    </style>
</head>

<body>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 215pt;text-indent: 0pt;text-align: left;"><span><img width="211" height="46" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_001.jpg') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="123" height="73" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_002.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="175" height="70" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_003.jpg') }}" /></span></p>
    <p style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;text-align: justify;">Le dispositif national des
        certificats d’économies d’énergie (CEE) mis en place par le Ministère en charge de l’énergie impose à l’ensemble
        des fournisseurs d’énergie (électricité, gaz, fioul domestique, chaleur ou froid, carburants automobiles), de
        réaliser des économies et de promouvoir les comportements vertueux auprès des consommateurs d’énergie.</p>
    <p style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;text-align: justify;">Dans le cadre de son partenariat
        avec la société EBS ENERGIE, la société (ENERGIENOVA) s’engage à vous apporter :</p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="68" height="18" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_004.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="12" height="14" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_005.jpg') }}" /></span></p>
    <p style="padding-top: 3pt;padding-left: 23pt;text-indent: 0pt;text-align: left;"><span class="s1"></span><span
            class="s2"> </span>une prime d’un montant de <span style=" color: #4F81BC;">12 259,80 €* </span>;</p>
    <p style="padding-top: 3pt;padding-left: 23pt;text-indent: 0pt;text-align: left;"><span class="s1"></span><span
            class="s2"> </span>un bon d’achat pour des produits de consommation courante d’un montant de <span
            style=" color: #4F81BC;">€ </span>;</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:20.8014pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:158pt">
                <p class="s4" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;"><span
                        class="s5"> </span><span class="s6">un prêt bonifié d’un montant de</span></p>
            </td>
            <td style="width:128pt">
                <p class="s6" style="padding-left: 13pt;text-indent: 0pt;line-height: 10pt;text-align: left;">euros
                    proposé par</p>
            </td>
            <td style="width:175pt">
                <p class="s6" style="padding-left: 43pt;text-indent: 0pt;line-height: 10pt;text-align: left;">au taux
                    effectif global (TEG) de</p>
            </td>
            <td style="width:17pt">
                <p class="s6" style="padding-left: 7pt;text-indent: 0pt;line-height: 10pt;text-align: left;">%</p>
            </td>
        </tr>
        <tr style="height:13pt">
            <td style="width:158pt">
                <p class="s6" style="padding-left: 20pt;text-indent: 0pt;line-height: 11pt;text-align: left;">(valeur de
                    la bonification =</p>
            </td>
            <td style="width:128pt">
                <p class="s7" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">€<span
                        style=" color: #000;">)* ;</span></p>
            </td>
            <td style="width:175pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="width:17pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
        <tr style="height:32pt">
            <td style="width:15pt">
                <p class="s4" style="padding-top: 3pt;padding-left: 2pt;text-indent: 0pt;text-align: left;"></p>
                <p class="s4"
                    style="padding-top: 3pt;padding-left: 2pt;text-indent: 0pt;line-height: 12pt;text-align: left;">
                </p>
            </td>
            <td style="width:271pt">
                <p class="s6"
                    style="padding-left: 5pt;padding-right: 11pt;text-indent: 0pt;line-height: 16pt;text-align: left;">
                    un audit ou conseil personnalisé, sous forme écrite (valeur = un produit ou service offert : [nature
                    à préciser]</p>
            </td>
            <td style="width:111pt">
                <p class="s7" style="padding-top: 3pt;padding-left: 15pt;text-indent: 0pt;text-align: left;">€ <span
                        style=" color: #000;">) ;</span></p>
                <p class="s6"
                    style="padding-top: 3pt;padding-left: 30pt;text-indent: 0pt;line-height: 11pt;text-align: left;">
                    d’une valeur de</p>
            </td>
            <td style="width:81pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s7"
                    style="padding-top: 7pt;padding-left: 17pt;text-indent: 0pt;line-height: 11pt;text-align: left;">€
                </p>
            </td>
        </tr>
    </table>
    <p style="padding-top: 3pt;padding-left: 41pt;text-indent: 0pt;text-align: left;">dans le cadre des travaux suivants
        (1 ligne par opération) :</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:18.754pt" cellspacing="0">
        <tr style="height:17pt">
            <td
                style="width:128pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s8" style="padding-top: 2pt;padding-left: 28pt;text-indent: 0pt;text-align: left;">Nature des
                    travaux</p>
            </td>
            <td
                style="width:63pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s8"
                    style="padding-top: 2pt;padding-left: 7pt;padding-right: 7pt;text-indent: 0pt;text-align: center;">
                    Fiche CEE</p>
            </td>
            <td
                style="width:307pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s8"
                    style="padding-top: 2pt;padding-left: 111pt;padding-right: 110pt;text-indent: 0pt;text-align: center;">
                    Conditions à respecter</p>
            </td>
        </tr>
        <tr style="height:55pt">
            <td
                style="width:128pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p class="s9"
                    style="padding-top: 2pt;padding-left: 8pt;padding-right: 9pt;text-indent: 0pt;text-align: center;">
                    Désembouage d’un réseau hydraulique de chauffage collectif en France métropolitaine</p>
            </td>
            <td
                style="width:63pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s10"
                    style="padding-top: 8pt;padding-left: 7pt;padding-right: 7pt;text-indent: 0pt;text-align: center;">
                    BAR-SE-109</p>
            </td>
            <td
                style="width:307pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p
                    style="padding-top: 7pt;padding-left: 5pt;padding-right: 32pt;text-indent: 0pt;line-height: 108%;text-align: left;">
                    <a href="http://www.ecologique-solidaire.gouv.fr/operations-standardisees-deconomies-denergie"
                        style=" color: black; font-family:Calibri, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt;"
                        target="_blank">Voir le site du Ministère de l’Ecologie et de la Transition Ecologique et
                        Solidaire : </a><a
                        href="http://www.ecologique-solidaire.gouv.fr/operations-standardisees-deconomies-denergie"
                        class="s12"
                        target="_blank">www.ecologique-solidaire.gouv.fr/operations-standardisees-deconomies-denergie</a>
                </p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 12pt;text-align: justify;">au bénéfice de : <span
            style=" color: #4471C4;">(Ajouter d’éventuelles autres conditions à respecter, ou renvoyer à des conditions
            contractuelles)</span></p>
    <ul id="l1">
        <li data-list-text="">
            <p style="padding-left: 41pt;text-indent: -18pt;line-height: 12pt;text-align: left;">Nom : RABATHERM HECS
            </p>
        </li>
        <li data-list-text="">
            <p style="padding-top: 1pt;padding-left: 41pt;text-indent: -18pt;text-align: left;">Prénom :</p>
        </li>
        <li data-list-text="">
            <p style="padding-top: 1pt;padding-left: 41pt;text-indent: -18pt;text-align: left;">Adresse : 21 RUE
                D&#39;ANJOU 92600 ASNIERES-SUR-SEINE</p>
        </li>
        <li data-list-text="">
            <p style="padding-top: 1pt;padding-left: 41pt;text-indent: -18pt;text-align: left;">Téléphone : 01 84 80 90
                08</p>
        </li>
        <li data-list-text="">
            <p style="padding-top: 1pt;padding-left: 41pt;text-indent: -18pt;text-align: left;"><a
                    href="mailto:contact@rabatherm-hecs.fr" class="s14" target="_blank">Adresse E-mail :
                    contact@rabatherm-hecs.fr</a></p>
        </li>
    </ul>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="64" height="16" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_006.png') }}" /></span></p>
    <p class="s15" style="padding-left: 23pt;text-indent: 0pt;text-align: left;">*Montant de prime valable 3 mois à
        compter de la date d’édition du devis <span style=" color: #F00;">06/10/2025</span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Les montants de prime indiqués ci-dessus sont
        définis selon les fiches d’opérations standardisées disponibles sur le site du Ministère en charge de l’énergie,
        et pourront être actualisés en fonction des paramètres relatifs aux travaux réalisés et de la situation fiscale
        du ménage.</p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Le présent engagement est pris dans le cadre de
        la période 5 (2022-2025) du dispositif des certificats d&#39;économies d&#39;énergie (CEE), institué par le
        Titre II du Livre II du Code de l&#39;énergie. Cet engagement est non cumulable avec une autre offre liée au
        dispositif des Certificats d&#39;Economies d&#39;Energie.</p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Cet engagement est valable pour les travaux
        réalisés jusqu&#39;à 1 an après la date d’édition du devis (date de facture des travaux faisant foi).</p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">Dans le cadre de la réglementation, un contrôle
        qualité des travaux sur site ou par contact pourra être demandé. Un refus de ce contrôle sur site ou par contact
        via EBS ENERGIE ou un prestataire d’EBS ENERGIE conduira au refus de cette prime par EBS ENERGIE.</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="71" height="18" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_007.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="135" height="159" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_008.png') }}" /></span></p>
    <p class="s17" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;line-height: 113%;text-align: left;">Le
        présent document doit être signé au plus tard quatorze jours après la date d’engagement de l’opération, et en
        tout état de cause avant la date de début des travaux.</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:8.322pt" cellspacing="0">
        <tr style="height:47pt">
            <td style="width:159pt">
                <p class="s6" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Signature:
                </p>
                <p class="s18" style="padding-left: 2pt;text-indent: 0pt;line-height: 12pt;text-align: left;">NOM Prénom
                    : HAMLET TAMOYAN</p>
                <p class="s18" style="padding-left: 2pt;text-indent: 0pt;line-height: 12pt;text-align: left;">Fonction :
                </p>
                <p class="s18" style="padding-left: 2pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Président
                </p>
            </td>
            <td style="width:132pt">
                <p class="s19" style="padding-left: 12pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Tampon et
                    signature de la</p>
                <p class="s19" style="padding-left: 12pt;text-indent: 0pt;text-align: left;">société</p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s20" style="padding-left: 40pt;text-indent: 0pt;text-align: left;">FORM_CONF_CDC_BAR SE 109_EBS
        Energie_INDIRECT HCDP_2024 09 01</p>
    <p style="padding-left: 25pt;text-indent: 0pt;text-align: left;"><span><img width="192" height="77" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_009.jpg') }}" /></span> <span><img width="214"
                height="46" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_010.jpg') }}" /></span><span class="s21">
        </span><span><img width="100" height="60" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_011.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h1 style="padding-top: 3pt;padding-left: 5pt;text-indent: 0pt;text-align: justify;">/!\ <span class="p">Faites
            réaliser plusieurs devis afin de prendre une décision éclairée. Attention, seules les propositions remises
            avant l’acceptation du devis ou du bon de commande sont valables, et vous ne pouvez pas cumuler plusieurs
            offres CEE différentes pour la même opération.</span></h1>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="699" height="158" alt="image"
                src="{{ public_path('assets/img/nova/cdc_files/Image_012.png') }}" /></span></p>
    <p class="s25" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;"><a
            href="https://www.ebs-energie.com/"
            style=" color: black; font-family:Calibri, sans-serif; font-style: normal; font-weight: normal; text-decoration: underline; font-size: 8pt;"
            target="_blank">Où se renseigner pour bénéficier de cette offre ? </a><a href="https://www.ebs-energie.com/"
            class="a" target="_blank">https://www</a><a href="https://www.ebs-energie.com/" class="s23"
            target="_blank">.ebs-</a><a href="https://www.ebs-energie.com/" class="a" target="_blank">energie.com</a>
        +33(0)1 43 92 28 32</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s22" style="padding-top: 5pt;padding-left: 93pt;text-indent: -88pt;line-height: 224%;text-align: left;">Où
        s’informer sur les aides pour les travaux d’économies d’énergie ?<a href="http://www.faire.gouv.fr/" class="s27"
            target="_blank"> : Site du réseau FAIRE : https://</a><span class="s26">www.faire.gouv.fr Tél :</span></p>
    <p class="s22" style="padding-left: 5pt;text-indent: 0pt;line-height: 7pt;text-align: left;">En cas de litige avec
        le porteur de l’offre ou son partenaire, vous pouvez faire appel gratuitement au médiateur de la consommation
        (6° de l’article L. 611-1</p>
    <p class="s28" style="padding-left: 5pt;text-indent: 0pt;line-height: 108%;text-align: left;"><span class="s22">du
            code de la consommation)</span> <span style=" color: #00F;">Médiation de la Consommation &amp; Patrimoine
        </span>dont nous relevons via le site<a href="http://www.mcpmediation.org/"
            style=" color: #001F5F; font-family:Calibri, sans-serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 8pt;"
            target="_blank">: </a><a href="http://www.mcpmediation.org/" class="s24"
            target="_blank">www.mcpmediation.org</a>,ou par voie postale: <span style=" color: #00F;">12 Square
            Desnouettes - 75015 PARIS </span>ou par téléphone au <span style=" color: #00F;">01.40.61.03.33</span></p>
    <p style="text-indent: 0pt;text-align: left;" />
    <h1 style="padding-left: 5pt;text-indent: 0pt;text-align: justify;">/!\ <span class="p">Seul le professionnel est
            responsable de la conformité des travaux que vous lui confiez. Vérifiez ses qualifications techniques et
            l’éligibilité des produits proposés avant d’engager vos travaux. Un contrôle des travaux effectués dans
            votre logement pourra être réalisé sur demande de EBS ENERGIE ou des autorités publiques.</span></h1>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s20" style="padding-top: 3pt;padding-left: 40pt;text-indent: 0pt;text-align: left;">FORM_CONF_CDC_BAR SE
        109_EBS Energie_INDIRECT HCDP_2024 09 01</p>
    <!-- Footer (commun) -->
    <div class="footer">
        ENERGIE NOVA — Tél. : 01 43 92 28 32 — contact@ebs-energie.com
        <div class="page-number"></div>
    </div>

</body>

</html>