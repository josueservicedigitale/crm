<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Devis</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        .s1 {
            color: #FFF;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 11pt;
        }

        .s2 {
            color: #F9F9F9;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 12pt;
        }

        .s3 {
            color: #FFF;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 11pt;
        }

        .s4 {
            color: #0A0;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .p,
        p {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
            margin: 0pt;
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

        h2 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s6 {
            color: #036;
            font-family: Arial, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .h1 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s7 {
            color: #0F3F70;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
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
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s11 {
            color: #234289;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 8pt;
        }

        .s12 {
            color: #FFF;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s13 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        .s14 {
            color: #036;
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
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s16 {
            color: #FFF;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
            vertical-align: -1pt;
        }

        .s17 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
            vertical-align: 3pt;
        }

        .s18 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s19 {
            color: #036;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 10pt;
        }

        .s20 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 9pt;
        }

        .s21 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 9pt;
        }

        .s22 {
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
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
            content: counter(d1, decimal)" ";
            color: black;
            font-family: Calibri, sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 8pt;
        }

        #l2>li:first-child>*:first-child:before {
            counter-increment: d1 0;
        }

        li {
            display: block;
        }

        #l3 {
            padding-left: 0pt;
        }

        #l3>li>*:first-child:before {
            content: "▪ ";
            color: black;
            font-family: Calibri, sans-serif;
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
    <table style="border-collapse:collapse;margin-left:6.17489pt" cellspacing="0">
        <tr style="height:18pt">
            <td style="width:234pt" bgcolor="#000000">
                <p class="s1" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">REF DEVIS
                </p>
            </td>
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s2" style="padding-left: 6pt;text-indent: 0pt;text-align: left;">ENR-2025-D-RQ-016</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s1" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">DATE DEVIS
                </p>
            </td>
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s3" style="padding-top: 2pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">04/12/2025
                </p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="178" height="118" alt="image"
                src="Devis_files/Image_001.png" /></span></p>
    <p class="s4" style="padding-left: 8pt;text-indent: 0pt;text-align: left;">ENERGIE NOVA</p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">60 Rue FRANCOIS 1 ER</p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">75008 PARIS</p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">SIRET 933 487 795 00017</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">Représenté par <b>M. TAMOYANHamlet</b><a
            href="mailto:direction@energie-nova.com" class="a" target="_blank">, en qualité de Président 0767847049
        </a><a href="mailto:direction@energie-nova.com" target="_blank">direction@energie-nova.com</a></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">RC Décennale ERGO contrat n° 25076156863</p>
    <h2 style="padding-top: 4pt;padding-left: 8pt;text-indent: 0pt;text-align: left;">BENEFICIAIRE</h2>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-left: 8pt;text-indent: 0pt;text-align: justify;">SIRET MAIL TEL</h2>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-left: 8pt;text-indent: 0pt;text-align: left;">REPRESENTE PAR FONCTION</h2>
    <p class="s6" style="padding-top: 4pt;padding-left: 8pt;text-indent: 0pt;text-align: left;">RABATHERM HECS</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 10pt;text-indent: 0pt;line-height: 10pt;text-align: left;">21 RUE D&#39;ANJOU</p>
    <p style="padding-left: 10pt;text-indent: 0pt;line-height: 10pt;text-align: left;">92600 ASNIERES-SUR-SEINE</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 8pt;text-indent: 0pt;line-height: 10pt;text-align: left;">44261333700033</p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">contact@rabatherm-hecs.fr 01 84 80 90 08</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 8pt;text-indent: 0pt;text-align: left;">M. Offel De Villaucourt Charles</p>
    <p style="padding-top: 3pt;padding-left: 10pt;text-indent: 0pt;text-align: left;">Gérant</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-left: 9pt;text-indent: -1pt;text-align: left;">OBJET : <span class="p">Opération entrant dans le
            dispositif de prime C.E.E. (Certificat d&#39;Economie d&#39;Energie), conforme aux recommandations de la
            fiche technique N°BAR-SE-104 de C.E.E décrites par le ministère de la Transition énergétique.</span></h2>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <h2 style="padding-left: 2pt;text-indent: 0pt;text-align: left;">DESIGNATION</h2>
    <p style="padding-left: 2pt;text-indent: 0pt;text-align: left;">Réglage des organes d’équilibrage d’une installation
        de chauffage à eau chaude, opération entrant dans le dispositif de prime C.E.E. (Certificat d’Économie
        d’Énergie), conforme aux recommandations de la fiche BAR-SE-104.</p>
    <h2 style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;line-height: 11pt;text-align: left;">SITE DES TRAVAUX
        : <span class="h1">2,4,6,8,10,12 Rue Félix Bridault, 17000 La Rochelle</span></h2>
    <p class="s7" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">NUMÉRO IMMATRICULATION
        DE COPROPRIÉTÉ <span style=" color: #00006A;">: </span><span class="p">AB6220685 - RES LE JEAN BART</span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s7" style="padding-left: 2pt;text-indent: 0pt;text-align: left;">PARCELLE CADASTRALE :</p>
    <p class="s7" style="padding-top: 2pt;padding-left: 2pt;text-indent: 0pt;text-align: left;">1 <span
            class="p">Parcelle 0442 Feuille 000 HP 001</span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s7" style="padding-left: 2pt;text-indent: 0pt;line-height: 11pt;text-align: left;">DATE DES TRAVAUX <span
            class="s9">: </span><span class="s10">11/12/2025</span></p>
    <p class="s11" style="padding-left: 2pt;text-indent: 0pt;line-height: 10pt;text-align: left;">DATE DE DÉSEMBOUAGE :
        <span class="h1">Du 28/10/2025 au 29/10/2025</span></p>
    <h2 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">CONTACT SUR SITE : <a
            href="mailto:contact@rabatherm-hecs.fr" class="a" target="_blank">Gérant M. Offel De Villaucourt Charles,
            Tél : 01 84 80 90 08 - </a><a href="mailto:contact@rabatherm-hecs.fr"
            target="_blank">contact@rabatherm-hecs.fr</a></h2>
    <h2 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">SECTEUR : <span
            class="p">Résidentiel</span></h2>
    <h2 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">NOMBRE DE BATIMENTS : <span
            class="p">5 Batiments .</span></h2>
    <h2 style="padding-left: 2pt;text-indent: 0pt;line-height: 9pt;text-align: left;">DETAILS : <span class="p">Bat A (
            20 Logs) , Bat B ( 20 Logs ) , Bat C ( 21 Logs) , Bat D ( 21 Logs ) , Bat E ( 21 Logs)</span></h2>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:6.12007pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt" bgcolor="#003366">
                <p class="s12"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:57pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 6pt;text-indent: 0pt;line-height: 11pt;text-align: left;">QUANTITE
                </p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 16pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TOTAL HT
                </p>
            </td>
            <td style="width:34pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 8pt;text-indent: 0pt;line-height: 11pt;text-align: left;">TVA</p>
            </td>
        </tr>
        <tr style="height:127pt">
            <td
                style="width:290pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p class="s13" style="padding-top: 3pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">
                    CARACTÉRISTIQUES DE L’INSTALLATION</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13"
                    style="padding-top: 6pt;padding-left: 8pt;padding-right: 95pt;text-indent: 0pt;line-height: 92%;text-align: left;">
                    Type de chauffage : Chauffage collectif à combustible Zone climatique : H2</p>
                <p class="s13" style="padding-left: 8pt;text-indent: 0pt;line-height: 9pt;text-align: left;">Nombre de
                    logements : 103</p>
                <p class="s13" style="padding-left: 8pt;text-indent: 0pt;line-height: 9pt;text-align: left;">
                    Installation existante depuis plus de 2 ans : OUI</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l1">
                    <li data-list-text="">
                        <p class="s14"
                            style="padding-left: 31pt;text-indent: -18pt;line-height: 11pt;text-align: left;">KWH CUMAC
                            : <span class="s15">824 000</span></p>
                    </li>
                    <li data-list-text="">
                        <p class="s14"
                            style="padding-left: 31pt;text-indent: -18pt;line-height: 11pt;text-align: left;">PRIME CEE
                            : <span class="s15">5 768 ,00 €</span></p>
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
    <table style="border-collapse:collapse;margin-left:6.17454pt" cellspacing="0">
        <tr style="height:18pt">
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s1" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">REF DEVIS
                </p>
            </td>
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s2" style="padding-left: 5pt;text-indent: 0pt;line-height: 14pt;text-align: left;">
                    ENR-2025-D-RQ-016</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s1" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">DATE DEVIS
                </p>
            </td>
            <td style="width:234pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s3" style="padding-top: 2pt;padding-left: 6pt;text-indent: 0pt;text-align: left;">04/12/2025
                </p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:6.24999pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:290pt" bgcolor="#003366">
                <p class="s12"
                    style="padding-left: 130pt;padding-right: 129pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    DETAIL</p>
            </td>
            <td style="width:58pt" bgcolor="#003366">
                <p class="s12"
                    style="padding-left: 6pt;padding-right: 6pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    QUANTITE</p>
            </td>
            <td style="width:70pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 22pt;text-indent: 0pt;line-height: 11pt;text-align: left;">PU HT</p>
            </td>
            <td style="width:71pt" bgcolor="#003366">
                <p class="s12" style="padding-left: 10pt;text-indent: 0pt;line-height: 11pt;text-align: left;">Total
                    <span class="s16">HT</span></p>
            </td>
            <td style="width:34pt" bgcolor="#003366">
                <p class="s12"
                    style="padding-left: 8pt;padding-right: 7pt;text-indent: 0pt;line-height: 11pt;text-align: center;">
                    TVA</p>
            </td>
        </tr>
        <tr style="height:123pt">
            <td style="width:290pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366"
                rowspan="2">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13"
                    style="padding-left: 4pt;padding-right: 9pt;text-indent: 0pt;line-height: 164%;text-align: left;">
                    Matériel(s) fourni(s) et mis en place par notre société RABATHERM HECS, Représentée par : M. Offel
                    De Villaucourt Charles</p>
                <p class="s13" style="padding-left: 4pt;text-indent: 0pt;line-height: 10pt;text-align: left;">SIRET :
                    44261333700033</p>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ol id="l2">
                    <li data-list-text="1">
                        <p class="s13"
                            style="padding-left: 8pt;padding-right: 10pt;text-indent: 0pt;line-height: 164%;text-align: left;">
                            - Réglage des organes d’équilibrage d’une installation de chauffage à eau chaude, destiné à
                            assurer une température uniforme dans tous les locaux</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="2">
                        <p class="s13" style="padding-left: 11pt;text-indent: -5pt;text-align: left;">- Mise en place
                            matériel d’équilibrage :</p>
                    </li>
                </ol>
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <ul id="l3">
                    <li data-list-text="▪">
                        <p class="s13" style="padding-left: 13pt;text-indent: -4pt;text-align: left;">Relevé sur site de
                            l’installation</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-left: 13pt;text-indent: -4pt;text-align: left;">Réalisation d’un
                            plan du sous-sol des PDC</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-top: 3pt;padding-left: 13pt;text-indent: -4pt;text-align: left;">
                            Réalisation d’un synoptique des colonnes</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13"
                            style="padding-top: 3pt;padding-left: 13pt;padding-right: 81pt;text-indent: -3pt;line-height: 82%;text-align: left;">
                            Réalisation d’une note de calcul des puissances de débits et réglages théoriques par
                            logement</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-top: 3pt;padding-left: 14pt;text-indent: -4pt;text-align: left;">
                            Réglage du point de fonctionnement de la pompe chauffage</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-top: 3pt;padding-left: 14pt;text-indent: -4pt;text-align: left;">
                            Réalisation d’une mesure de débit sur les PDC et antennes</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13"
                            style="padding-top: 4pt;padding-left: 13pt;padding-right: 12pt;text-indent: -3pt;line-height: 82%;text-align: left;">
                            Un tableau d’enregistrement des températures moyennes sur un échantillon des logements,
                            après équilibrage</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13"
                            style="padding-left: 12pt;padding-right: 4pt;text-indent: -3pt;line-height: 82%;text-align: left;">
                            L’écart de température entre l’appartement le plus chauffé et le moins chauffé doit être
                            strictement inférieur à 2°C</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s13"
                            style="padding-left: 3pt;padding-right: 9pt;text-indent: 0pt;line-height: 204%;text-align: left;">
                            Note : Les quantités sont données à titre indicatif. Il appartient au maître d’ouvrage du
                            présent lot de les valider. Les prix des appareillages comprennent leur fourniture, fixation
                            et raccordement. Le marché est passé à prix global et forfaitaire.</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                        <p class="s13" style="padding-left: 5pt;text-indent: 0pt;text-align: left;">COMPRIS DANS LES
                            TRAVAUX :</p>
                        <p style="text-indent: 0pt;text-align: left;"><br /></p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-left: 16pt;text-indent: -4pt;text-align: left;">La dépose et
                            l’enlèvement de votre ancien appareil</p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-top: 1pt;padding-left: 16pt;text-indent: -4pt;text-align: left;">
                            La protection et le nettoyage du chantier <span class="s17">-</span></p>
                    </li>
                    <li data-list-text="▪">
                        <p class="s13" style="padding-top: 3pt;padding-left: 17pt;text-indent: -4pt;text-align: left;">
                            Le remplissage et la purge de votre installation</p>
                    </li>
                </ul>
            </td>
            <td
                style="width:58pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 5pt;padding-right: 7pt;text-indent: 0pt;text-align: center;">1</p>
            </td>
            <td
                style="width:70pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 6pt;padding-left: 17pt;text-indent: 0pt;text-align: left;">4 100,48
                </p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 6pt;padding-left: 19pt;text-indent: 0pt;text-align: left;">4 100,48
                </p>
            </td>
            <td
                style="width:34pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13"
                    style="padding-top: 7pt;padding-left: 8pt;padding-right: 5pt;text-indent: 0pt;text-align: center;">
                    5,5 %</p>
            </td>
        </tr>
        <tr style="height:377pt">
            <td
                style="width:58pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 7pt;padding-right: 5pt;text-indent: 0pt;text-align: center;">1</p>
            </td>
            <td
                style="width:70pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 7pt;padding-left: 23pt;text-indent: 0pt;text-align: left;">1 366,82
                </p>
            </td>
            <td
                style="width:71pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13" style="padding-top: 6pt;padding-left: 27pt;text-indent: 0pt;text-align: left;">1 366,82
                </p>
            </td>
            <td
                style="width:34pt;border-left-style:solid;border-left-width:1pt;border-left-color:#003366;border-bottom-style:solid;border-bottom-width:1pt;border-bottom-color:#003366;border-right-style:solid;border-right-width:1pt;border-right-color:#003366">
                <p style="text-indent: 0pt;text-align: left;"><br /></p>
                <p class="s13"
                    style="padding-top: 7pt;padding-left: 8pt;padding-right: 5pt;text-indent: 0pt;text-align: center;">
                    5,5 %</p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="183" height="121" alt="image"
                src="Devis_files/Image_002.png" /></span></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:16.1737pt" cellspacing="0">
        <tr style="height:18pt">
            <td style="width:234pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s1" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">REF DEVIS
                </p>
            </td>
            <td style="width:234pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s2"
                    style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;line-height: 14pt;text-align: left;">
                    ENR-2025-D-RQ-016</p>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="width:234pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s1" style="padding-top: 2pt;padding-left: 5pt;text-indent: 0pt;text-align: left;">DATE DEVIS
                </p>
            </td>
            <td style="width:234pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                bgcolor="#1A4D7E">
                <p class="s3" style="padding-top: 2pt;padding-left: 4pt;text-indent: 0pt;text-align: left;">04/12/2025
                </p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><span><img width="178" height="118" alt="image"
                src="Devis_files/Image_003.png" /></span></p>
    <p class="s18" style="padding-top: 5pt;padding-left: 16pt;text-indent: 0pt;text-align: left;">Termes et conditions
        CEE</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-top: 2pt;padding-left: 7pt;text-indent: 0pt;line-height: 82%;text-align: left;">Les travaux ou
        prestations objet du présent document donneront lieu à une contribution financière de EBS ENERGIE (SIREN 533 333
        118), versée par</p>
    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 82%;text-align: left;">EBS ENERGIE dans le cadre de son
        rôle incitatif sous forme de prime, directement au(x) mandataire(s), sous réserve de l’engagement de fournir
        exclusivement à EBS ENERGIE les documents nécessaires à la valorisation des opérations au titre du dispositif
        des Certificats d’Économies d’Énergie et sous réserve de la validation de l’éligibilité du dossier par EBS
        ENERGIE puis par l’autorité administrative compétente.</p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="padding-left: 7pt;text-indent: 0pt;line-height: 78%;text-align: left;">Le montant de cette contribution
        financière, hors champ d’application de la TVA, est susceptible de varier en fonction des travaux effectivement
        réalisés et du volume des CEE attribués à l’opération et est estimé à <span class="s10">5 768 ,00 €</span>.</p>
    <p style="padding-left: 18pt;text-indent: 0pt;text-align: left;" />
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <table style="border-collapse:collapse;margin-left:334.93pt" cellspacing="0">
        <tr style="height:13pt">
            <td style="width:113pt">
                <p class="s19" style="padding-right: 21pt;text-indent: 0pt;line-height: 10pt;text-align: right;">TOTAL
                    HT</p>
            </td>
            <td style="width:69pt">
                <p class="s20" style="padding-right: 3pt;text-indent: 0pt;line-height: 10pt;text-align: right;">5 467,30
                    <span class="s21">€</span></p>
            </td>
        </tr>
        <tr style="height:16pt">
            <td style="width:113pt">
                <p class="s21" style="padding-top: 1pt;padding-right: 22pt;text-indent: 0pt;text-align: right;">TVA à
                    5,5 %</p>
            </td>
            <td style="width:69pt">
                <p class="s21" style="padding-top: 1pt;padding-right: 3pt;text-indent: 0pt;text-align: right;">300,70 €
                </p>
            </td>
        </tr>
        <tr style="height:17pt">
            <td style="width:113pt">
                <p class="s19" style="padding-top: 1pt;padding-right: 21pt;text-indent: 0pt;text-align: right;">MONTANT
                    TOTAL TTC</p>
            </td>
            <td style="width:69pt">
                <p class="s20" style="padding-top: 2pt;padding-right: 2pt;text-indent: 0pt;text-align: right;">5 768 ,00
                    <span class="s21">€</span></p>
            </td>
        </tr>
        <tr style="height:16pt">
            <td style="width:113pt">
                <p class="s21" style="padding-top: 1pt;padding-right: 23pt;text-indent: 0pt;text-align: right;">PRIME
                    CEE</p>
            </td>
            <td style="width:69pt">
                <p class="s21" style="padding-top: 2pt;padding-right: 2pt;text-indent: 0pt;text-align: right;">- 5 768
                    ,00 €</p>
            </td>
        </tr>
        <tr style="height:14pt">
            <td style="width:113pt">
                <p class="s19" style="padding-right: 20pt;text-indent: 0pt;line-height: 12pt;text-align: right;">RESTE A
                    CHARGE</p>
            </td>
            <td style="width:69pt">
                <p class="s21"
                    style="padding-top: 2pt;padding-right: 2pt;text-indent: 0pt;line-height: 10pt;text-align: right;">
                    0,00 €</p>
            </td>
        </tr>
    </table>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p style="text-indent: 0pt;text-align: left;"><br /></p>
    <p class="s22" style="padding-left: 43pt;text-indent: 0pt;text-align: left;">Date et signature du bénéficiaire :</p>
</body>

</html>