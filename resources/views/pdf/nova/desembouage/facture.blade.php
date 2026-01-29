<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Facture</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .s1 {
            color: #0A0;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s2 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .a,
        a {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        h3 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s4 {
            color: #036;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s5 {
            color: #0F3F70;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s6 {
            color: #00006A;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s7 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
            vertical-align: 1pt;
        }

        .s8 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
            vertical-align: -1pt;
        }

        .s9 {
            color: #0F3F70;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s10 {
            color: #FFF;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s11 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s12 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s13 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s14 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s15 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        h2 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        p {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 7pt;
            margin: 0pt;
        }

        h1 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        li {
            display: block;
        }

        #l1 {
            padding-left: 0pt;
        }

        #l1>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        li {
            display: block;
        }

        #l2 {
            padding-left: 0pt;
            counter-reset: d1 1;
        }

        #l2>li>*:first-child:before {
            counter-increment: d1;
            content: counter(d1, upper-latin)". ";
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        #l2>li:first-child>*:first-child:before {
            counter-increment: d1 0;
        }

        #l3 {
            padding-left: 0pt;
        }

        #l3>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        #l4 {
            padding-left: 0pt;
        }

        #l4>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        #l5 {
            padding-left: 0pt;
        }

        #l5>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        #l6 {
            padding-left: 0pt;
        }

        #l6>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        li {
            display: block;
        }

        #l7 {
            padding-left: 0pt;
        }

        #l7>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        #l8 {
            padding-left: 0pt;
        }

        #l8>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        li {
            display: block;
        }

        #l9 {
            padding-left: 0pt;
        }

        #l9>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        li {
            display: block;
        }

        #l10 {
            padding-left: 0pt;
        }

        #l10>li>*:first-child:before {
            content: " ";
            color: black;
            font-family: Wingdings;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
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
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s1" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">ENERGIE NOVA</p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">60 Rue FRANCOIS 1 ER</p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">75008 PARIS</p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">SIRET 933 487 795 00017</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">Représenté par <b>M. TAMOYANHamlet</b><a
            href="mailto:direction@energie-nova.com" class="a" target="_blank">, en qualité de Président 0767847049
        </a><a href="mailto:direction@energie-nova.com" target="_blank">direction@energie-nova.com</a></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">RC Décennale ERGO contrat n° 25076156863
        Qualification Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</p>
    <h3 style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">BENEFICIAIRE</h3>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h3 style="padding-left: 7pt;text-indent: 0pt;text-align: justify;">SIRET MAIL TEL</h3>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h3 style="padding-left: 7pt;text-indent: 0pt;text-align: left;">REPRESENTE PAR FONCTION</h3>
    <p class="s4" style="padding-top: 4pt;padding-left: 7pt;text-indent: 0pt;text-align: left;">RABATHERM HECS</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s2" style="padding-left: 9pt;text-indent: 0pt;line-height: 10pt;text-align: left;">21 RUE D&#39;ANJOU</p>
    <p class="s2" style="padding-left: 9pt;text-indent: 0pt;line-height: 10pt;text-align: left;">92600
        ASNIERES-SUR-SEINE</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;line-height: 10pt;text-align: left;">44261333700033</p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">contact@rabatherm-hecs.fr 01 84 80 90 08
    </p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s2" style="padding-left: 7pt;text-indent: 0pt;text-align: left;">M. Offel De Villaucourt Charles</p>
    <p class="s2" style="padding-top: 3pt;padding-left: 9pt;text-indent: 0pt;text-align: left;">Gérant</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h3 style="padding-left: 2pt;text-indent: 0pt;text-align: left;">DESCRIPTIF</h3>
    <p class="s2" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">Désembouage de l’ensemble du système de
        distribution par boucle d’eau d’une installation de chauffage collectif alimentée par une chaudière utilisant un
        combustible fossile ou alimenté par un réseau de chaleur</p>
    <h3 style="padding-top: 3pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">SITE DES TRAVAUX : <span
            class="s2">6, 8 All. des Tilleuls, 93110 Rosny-sous-Bois</span></h3>
    <p class="s2" style="padding-left: 2pt;text-indent: 0pt;text-align: left;"><span class="s5">NUMÉRO IMMATRICULATION
            DE COPROPRIÉTÉ </span><span class="s6">: </span>AA0588830 <b>- </b>RES SONATE</p>
    <p class="s5" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">ZONE CLIMATIQUE <span class="s2">:
            H1</span></p>
    <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">PARCELLE CADASTRALE :
    </p>
    <p class="s5" style="padding-top: 1pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">1 <span
            class="s2">Parcelle </span><span class="s7">2</span></p>
    <h3 style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">3 <span class="s8">4</span></h3>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s5" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">DATE PREVISIONNELLE DES
        TRAVAUX<span class="s9">: </span><span class="s2">Du 07/10/2025 au 08/10/2025</span></p>
    <h3 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">CONTACT SUR SITE : <a
            href="mailto:contact@rabatherm-hecs.fr" class="a" target="_blank">Gérant M. Offel De Villaucourt Charles 01
            84 80 90 08 - </a><a href="mailto:contact@rabatherm-hecs.fr" target="_blank">contact@rabatherm-hecs.fr</a>
    </h3>
    <h3 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">SECTEUR : <span
            class="s2">Résidentiel</span></h3>
    <h3 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">NOMBRE DE BATIMENTS : <span
            class="s2">3 Batiments .</span></h3>
    <h3 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">DETAILS : <span class="s2">Bat A (
            47 Logs ), Bat B ( 46 Logs ), Bat C ( 46 Logs )</span></h3>
    <p style="text-indent: 0pt;text-align: left;" />
    <p class="s2" style="padding-left: 1pt;text-indent: 0pt;text-align: left;">0290 Feuille 000 0T 001</p>
    <p style="text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <img alt="image" height="28" src="{{ public_path('assets/img/nova/Facture_files/Image_001.png') }}"
                width="248" />
        </span>
    </p>
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <img alt="image" height="14" src="{{ public_path('assets/img/nova/Facture_files/Image_002.png') }}"
                width="55" />
        </span>
    </p>
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <img alt="image" height="14" src="{{ public_path('assets/img/nova/Facture_files/Image_003.png') }}"
                width="55" />
        </span>
    </p>
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <img alt="image" height="26" src="{{ public_path('assets/img/nova/Facture_files/Image_004.png') }}"
                width="213" />
        </span>
    </p>
    <h3 style="padding-top: 3pt;padding-left: 10pt;text-indent: 0pt;text-align: left;">OBJET : <span
            class="s2">Opération entrant dans le dispositif de prime C.E.E. (Certificat d&#39;Economie d&#39;Energie),
            conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère de la
            Transition énergétique.</span></h3>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:5.125pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt;border-bottom-style:solid;border-bottom-width:2pt;border-bottom-color:#FFFFFF"
                bgcolor="#003366">
                <p class="s10"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:57pt;border-bottom-style:solid;border-bottom-width:2pt;border-bottom-color:#FFFFFF"
                bgcolor="#003366">
                <p class="s10" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QUANTITE
                </p>
            </td>
            <td style="width:71pt;border-bottom-style:solid;border-bottom-width:2pt;border-bottom-color:#FFFFFF"
                colspan="3" bgcolor="#003366">
                <p class="s10" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt;border-bottom-style:solid;border-bottom-width:2pt;border-bottom-color:#FFFFFF"
                colspan="3" bgcolor="#003366">
                <p class="s10" style="padding-left: 16pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TOTAL HT
                </p>
            </td>
            <td style="width:34pt;border-bottom-style:solid;border-bottom-width:2pt;border-bottom-color:#FFFFFF"
                bgcolor="#003366">
                <p class="s10" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TVA</p>
            </td>
        </tr>
        <tr style="height:11pt">
            <td style="width:290pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                rowspan="2">
                <p class="s11" style="padding-left: 5pt;text-indent: 0pt;line-height: 8pt;text-align: justify;">
                    Désembouage de l’ensemble du système de distribution par boucle d’eau d’une</p>
                <p class="s11" style="padding-left: 5pt;padding-right: 5pt;text-indent: 0pt;text-align: justify;">
                    installation de chauffage collectif alimentée par une chaudière utilisant un combustible fossile.
                </p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s12" style="padding-left: 5pt;padding-right: 5pt;text-indent: 0pt;text-align: justify;">
                    Opération entrant dans le dispositif de prime C.E.E. (Certificat d&#39;Economie d&#39;Energie),
                    conforme aux recommandations de la fiche technique N°BAR-SE-109 de C.E.E décrites par le ministère
                    de la Transition énergétique.</p>
            </td>
            <td style="width:57pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                rowspan="2">
                <p class="s12" style="padding-right: 5pt;text-indent: 0pt;line-height: 9pt;text-align: right;">1</p>
            </td>
            <td
                style="width:26pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-left-style:solid;border-left-width:1pt;border-left-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="width:37pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF"
                bgcolor="#FEF3C1">
                <p class="s12" style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">12 259,80
                </p>
            </td>
            <td
                style="width:8pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:29pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-left-style:solid;border-left-width:1pt;border-left-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="width:36pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF"
                bgcolor="#FEF3C1">
                <p class="s12" style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">12 259,80
                </p>
            </td>
            <td
                style="width:6pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="width:34pt;border-top-style:solid;border-top-width:2pt;border-top-color:#FFFFFF;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                rowspan="2">
                <p class="s12" style="padding-left: 12pt;text-indent: 0pt;text-align: left;">20 %</p>
            </td>
        </tr>
        <tr style="height:76pt">
            <td style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                colspan="3">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                colspan="3">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:5.125pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt" bgcolor="#003366">
                <p class="s10"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:57pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QUANTITE
                </p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 16pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TOTAL HT
                </p>
            </td>
            <td style="width:34pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TVA</p>
            </td>
        </tr>
        <tr style="height:631pt">
            <td
                style="width:290pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p class="s13" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">CARACTÉRISTIQUES DE
                    L&#39;INSTALLATION</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s11" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">INSTALLATION COLLECTIVE DE
                    CHAUFFAGE ALIMENTÉE PAR UNE CHAUDIÈRE HORS CONDENSATION</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l1">
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Puissance
                            nominale de la chaudière : 670 kW</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Nombre de
                            logements concernés : 139</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Nombre
                            d&#39;émetteurs désemboués : 487</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Nature du réseau
                            : Acier</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Volume total du
                            circuit d&#39;eau: 5 396 L</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Zone climatique :
                            H1</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Filtres : 14</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="">
                        <p class="s11" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">KWH CUMAC : <span
                                class="s12">1 751 400</span></p>
                    </li>
                    <li data-list-text="">
                        <p class="s11" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">PRIME CEE : <span
                                class="s12">12 259,80 €</span></p>
                    </li>
                </ul>
                <p class="s11" style="padding-left: 41pt;text-indent: 0pt;text-align: left;">NET DE TAXE</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">DÉTAIL DE LA PRESTATION</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s11" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">LE DÉSEMBOUAGE COMPORTE LES
                    ÉTAPES SUCCESSIVES SUIVANTES :</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ol id="l2">
                    <li data-list-text="A.">
                        <p class="s11" style="padding-left: 14pt;text-indent: -8pt;text-align: left;">INJECTION D&#39;UN
                            RÉACTIF DÉSEMBOUANT ET CIRCULATION</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s12" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">PREPARATION ET
                            DIAGNOSTIC INITIAL</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <ul id="l3">
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Vérification de l&#39;état général de l&#39;installation de chauffage</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Contrôle de la pression et de l&#39;étanchéité du circuit</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Test de fonctionnement des vannes et organes de régulation</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 5pt;padding-right: 63pt;text-indent: 18pt;line-height: 199%;text-align: left;">
                                    Relevé des températures et pressions de fonctionnement Injection du produit
                                    désembouant SENTINEL X800</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Dosage :
                                    1% du volume d&#39;eau de l&#39;installation</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                    Méthode d&#39;injection : Via un point d&#39;injection dédié ou par le vase
                                    d&#39;expansion</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 5pt;padding-right: 29pt;text-indent: 18pt;line-height: 200%;text-align: left;">
                                    Dilution : Mélange homogène du produit dans l&#39;ensemble du circuit CIRCULATION
                                    AVEC POMPE DE DESEMBOUAGE</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                    Équipement utilisé : Pompe de désembouage haute performance (débit minimum 30 L/min)
                                </p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Circulation générale :</p>
                                <ul id="l4">
                                    <li data-list-text="">
                                        <p class="s12"
                                            style="padding-left: 77pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                            Mise en circulation sur l&#39;ensemble du réseau pendant 4 heures minimum
                                        </p>
                                    </li>
                                    <li data-list-text="">
                                        <p class="s12"
                                            style="padding-left: 77pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                            Température de circulation : 50-60°C pour optimiser l&#39;action du produit
                                        </p>
                                    </li>
                                </ul>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Circulation réseau par réseau :</p>
                                <ul id="l5">
                                    <li data-list-text="">
                                        <p class="s12"
                                            style="padding-left: 77pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                            Isolation et traitement de chaque réseau de distribution individuellement
                                        </p>
                                    </li>
                                    <li data-list-text="">
                                        <p class="s12"
                                            style="padding-left: 77pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                            Circulation dans les deux sens pour décoller tous les dépôts</p>
                                    </li>
                                    <li data-list-text="">
                                        <p class="s12"
                                            style="padding-left: 77pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                            Durée par réseau : 2 heures minimum dans chaque sens</p>
                                    </li>
                                </ul>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                    Surveillance : Contrôle visuel de la couleur de l&#39;eau (passage du trouble au
                                    clair)</p>
                                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                            </li>
                        </ul>
                    </li>
                    <li data-list-text="B.">
                        <p class="s11" style="padding-left: 13pt;text-indent: -8pt;text-align: left;">RINÇAGE DES
                            CIRCUITS À L&#39;EAU CLAIRE</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s12" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">RINÇAGE GENERAL</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <ul id="l6">
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Évacuation complète du produit désembouant par les points de purge</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Remplissage progressif à l&#39;eau claire du réseau public</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Circulation intensive pendant 2 heures minimum</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Contrôle qualité : Vérification de la limpidité de l&#39;eau en sortie</p>
                            </li>
                        </ul>
                    </li>
                </ol>
            </td>
            <td
                style="width:57pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:34pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="32" height="43" alt="image"
                src="{{ public_path('assets/img/nova/Facture_files/Image_005.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="29" height="14" alt="image"
                src="{{ public_path('assets/img/nova/Facture_files/Image_006.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="16" height="14" alt="image"
                src="{{ public_path('assets/img/nova/Facture_files/Image_007.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="57" height="29" alt="image"
                src="{{ public_path('assets/img/nova/Facture_files/Image_008.png') }}" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:5.125pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt" bgcolor="#003366">
                <p class="s10"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:57pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QUANTITE
                </p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 16pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TOTAL HT
                </p>
            </td>
            <td style="width:34pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TVA</p>
            </td>
        </tr>
        <tr style="height:628pt">
            <td
                style="width:290pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">RINÇAGE RESEAU PAR RESEAU
                </p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l7">
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Isolation de
                            chaque réseau de distribution</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Rinçage
                            individuel :</p>
                        <ul id="l8">
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 77pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Ouverture des vannes de purge des émetteurs</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 77pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                                    Circulation d&#39;eau claire jusqu&#39;à obtention d&#39;une eau limpide</p>
                            </li>
                            <li data-list-text="">
                                <p class="s12"
                                    style="padding-left: 77pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                                    Fermeture progressive des purges en commençant par les plus éloignées</p>
                            </li>
                        </ul>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Volume de
                            rinçage : Minimum 3 fois le volume de chaque réseau</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 5pt;padding-right: 71pt;text-indent: 18pt;line-height: 200%;text-align: left;">
                            Contrôle final : Test d&#39;absence de résidus et de mousse REMISE EN PRESSION</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Remplissage complet du circuit à la pression nominale</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Purge de
                            l&#39;air résiduel sur tous les émetteurs</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Vérification de l&#39;absence de fuites</p>
                    </li>
                </ul>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s11" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">C. VÉRIFICATION/INSTALLATION
                    FILTRE ET INJECTION INHIBITEUR</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">VERIFICATION DU SYSTEME DE
                    FILTRATION EXISTANT</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l9">
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Localisation des filtres à boues existants sur les circuits de retour</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Démontage
                            et nettoyage des filtres en place</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 5pt;padding-right: 39pt;text-indent: 18pt;line-height: 200%;text-align: left;">
                            Contrôle d&#39;efficacité : Vérification du maillage et de l&#39;état général INSTALLATION
                            DE FILTRES COMPLEMENTAIRES (SI NECESSAIRE)</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Positionnement : Sur chaque circuit de retour au générateur</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Type de
                            filtre : Filtre magnétique séparateur de boues haute performance</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Raccordement : Avec vannes d&#39;isolement pour maintenance future</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 5pt;padding-right: 67pt;text-indent: 18pt;line-height: 200%;text-align: left;">
                            Accessibilité : Installation permettant un entretien facile INJECTION DU REACTIF INHIBITEUR
                            SENTINEL X100</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Dosage :
                            1% du volume d&#39;eau de l&#39;installation</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Méthode
                            d&#39;injection : Via point d&#39;injection dédié</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">
                            Circulation : Mise en route de la circulation pendant 30 minutes minimum</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 5pt;padding-right: 27pt;text-indent: 18pt;line-height: 199%;text-align: left;">
                            Homogénéisation : Vérification de la répartition uniforme du produit CONTROLES FINAUX ET
                            MISE EN SERVICE</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Test de
                            fonctionnement complet de l&#39;installation</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Relevé des
                            paramètres : Température, pression, débit</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Réglages :
                            Ajustement des organes de régulation</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Formation
                            : Explication du fonctionnement au personnel technique</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">
                            Documentation : Remise du certificat de désembouage et planning de maintenance</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s13" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">PRODUITS UTILISÉS
                        </p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s11" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">
                            SENTINEL X800 DÉSEMBOUANT</p>
                        <p class="s12"
                            style="padding-left: 5pt;padding-right: 5pt;text-indent: 0pt;text-align: justify;">Sentinel
                            X800 Désembouant pour nettoyage d&#39;un réseau de chauffage, Sentinel X800 élimine tous
                            débris, particules de corrosion et dépôts de calcaire des installations de chauffage
                            central.</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;text-align: left;">Dosage :
                            1% du volume d&#39;eau de l&#39;installation, soit 1 litre pour 100 litres d&#39;eau</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Aspect :
                            Liquide clair, incolore à jaune pâle</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Odeur :
                            Légère</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Densité
                            (25°C) : 1,06 g/ml</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">pH
                            (concentré) : Environ 6,3</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;text-indent: -18pt;line-height: 10pt;text-align: left;">Point de
                            congélation : -8°C</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Agréé par le
                            ministère de la Santé</p>
                    </li>
                </ul>
            </td>
            <td
                style="width:57pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:34pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:5.125pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt" bgcolor="#003366">
                <p class="s10"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:57pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QUANTITE
                </p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 16pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TOTAL HT
                </p>
            </td>
            <td style="width:34pt" bgcolor="#003366">
                <p class="s10" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TVA</p>
            </td>
        </tr>
        <tr style="height:270pt">
            <td
                style="width:290pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p class="s11" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">SENTINEL
                    X100 INHIBITEUR</p>
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Sentinel X100 Inhibiteur
                    pour protection du réseau de chauffage avec solution aqueuse d&#39;agents inhibiteurs de corrosion
                    et anti-tartre.</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l10">
                    <li data-list-text="">
                        <p class="s12"
                            style="padding-left: 41pt;padding-right: 5pt;text-indent: -18pt;line-height: 108%;text-align: left;">
                            Dosage : 1% du volume d&#39;eau de l&#39;installation, soit 1 litre pour 100 litres
                            d&#39;eau</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Aspect : Liquide
                            clair, incolore à jaune pâle</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Densité (20°C) :
                            1,10 g/ml</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">pH (concentré) :
                            Environ 6,4</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Point de
                            congélation : -2,5°C</p>
                    </li>
                    <li data-list-text="">
                        <p class="s12" style="padding-left: 41pt;text-indent: -18pt;text-align: left;">Agréé par le
                            ministère de la Santé</p>
                    </li>
                </ul>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">MATÉRIEL ET ENTREPRISE</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s12" style="padding-left: 5pt;padding-right: 7pt;text-indent: 0pt;text-align: left;">
                    Matériel(s) fourni(s) et mis en place par <b>ENERGIE NOVA</b>, 60 RUE FRANCOIS IER, 75008 PARIS
                    ,SIRET 93348779500017, Code APE 7112B.</p>
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">
                    Représentée par <b>M. Tamoyan Hamlet </b><a href="mailto:direction@energie-nova.com" class="s15"
                        target="_blank">, 0767847049 direction@energie-nova.com</a></p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">
                    Qualification <b>Qualisav Spécialité Désembouage N° 31376 - ID N° S01810</b></p>
                <p class="s12" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">RC
                    Décennale <b>W4737408 contrat n° 25076156863</b></p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s14" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Durée
                    totale de l&#39;intervention <span class="s12">: 1 à 2 jours selon la complexité</span></p>
                <p class="s14" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Garantie
                    <span class="s12">: 2 ans sur l&#39;intervention de désembouage</span>
                </p>
                <p class="s14" style="padding-left: 5pt;text-indent: 0pt;line-height: 10pt;text-align: left;">Suivi
                    <span class="s12">: Contrôle recommandé à 6 mois puis annuellement</span>
                </p>
            </td>
            <td
                style="width:57pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
            <td
                style="width:34pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-top: 7pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">CONDITIONS DE PAIEMENT</h2>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">« Les travaux ou prestations objet du présent
        document donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333 118), versée par EBS ENERGIE
        dans le cadre de son rôle incitatif sous forme de prime, directement ou via son (ses) mandataire(s), sous
        réserve de l’engagement de fournir exclusivement à EBS Energie les documents nécessaires à la valorisation des
        opérations au titre du dispositif des Certificats d’Économies d’Énergie et sous réserve de la validation de
        l’éligibilité du dossier par EBS ENERGIE puis par l’autorité administrative compétente.</p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Le montant de cette contribution financière, hors
        champ d’application de la TVA, est susceptible de varier en fonction des travaux effectivement réalisés et du
        volume des CEE attribués à l’opération et est estimé à 12 259,80 euros ».</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Gestion des déchets</h2>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">Gestion, évacuation et traitements des déchets de
        chantier comprenant la main d’œuvre liée à la dépose et au tri, le transport des déchets de chantiers vers un ou
        plusieurs points de collecte et coûts de traitement.</p>
    <p style="text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <img alt="image" height="13" src="{{ public_path('assets/img/nova/Facture_files/Image_009.png') }}"
                width="42" />
        </span>
    </p>
    <h1 style="text-indent: 0pt;text-align: right;">
        RESTE A CHARGE
        <span>
            <img alt="image" height="15" src="{{ public_path('assets/img/nova/Facture_files/Image_010.png') }}"
                width="43" />
        </span>
    </h1>
</body>

</html>