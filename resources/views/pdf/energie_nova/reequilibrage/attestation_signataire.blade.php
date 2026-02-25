<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation de qualité de signataire</title>

    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #111;
            margin: 0;
            padding: 0;
        }

        .page {
            width: 100%;
            min-height: 100vh;
            position: relative;
        }

        /* Titre encadré */
        .title-box {
            width: 420px;
            margin: 80px auto 60px auto;
            border: 2px solid #333;
            text-align: center;
            padding: 12px 10px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        /* Texte principal */
        .content {
            width: 85%;
            margin: 0 auto;
            line-height: 1.8;
            text-align: justify;
        }

        /* Bloc date */
        .date-block {
            width: 85%;
            margin: 60px auto 20px auto;
        }

        /* Bloc signature */
        .signature-box {
            width: 420px;
            margin-left: 100px;
            border: 1px solid #333;
            padding: 15px;
        }

        .signature-box p {
            margin: 6px 0;
        }

        .signature-box .label {
            font-size: 11px;
        }

        .stamp {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
            line-height: 1.5;
        }

        .stamp-image {
            margin-top: 15px;
            text-align: center;
        }

        .stamp-image img {
            max-width: 200px;
            max-height: 120px;
        }

        .stamp-text {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
            line-height: 1.4;
        }
    </style>
</head>

<body>

    <div class="page">

        <!-- Titre -->
        <div class="title-box">
            ATTESTATION DE QUALITE DE SIGNATAIRE
        </div>

        <!-- Texte -->
        <div class="content">
            Je soussigné <strong>{{ strtoupper('Mr. Offel De Villaucourt Charles') }}</strong>, agissant en qualité de
            gérant,
            atteste que le bâtiment <strong>« RES {{ strtoupper($document->nom_residence) }} »</strong>, situé à
            <strong>{{ strtoupper($document->adresse_travaux) }}</strong>,
            dont le numéro d'immatriculation est le
            <strong>{{ strtoupper($document->numero_immatriculation) }}</strong>,
            est géré par <strong>{{ strtoupper('RABATHERM HECS') }}</strong>, situé au
            <strong>{{ strtoupper('21 RUE D\'ANJOU 92600 ASNIERES-SUR-SEINE') }}</strong>
            dont le numéro de SIRET est le <strong>{{ strtoupper('44261333700033') }}.</strong>
        </div>


        <!-- Date -->
        <div class="date-block">
            Fait le : {{ $document->date_signature ?? 'BIEN RENSEIGNER' }}<br><br>
            à ASNIERES-SUR-SEINE
        </div>

        <!-- Bloc signature -->
        <div class="signature-box">

            <p class="label"><strong>*Nom et prénom du signataire :</strong> Offel De Villaucourt Charles</p>
            <p class="label"><strong>*Qualité du signataire :</strong> GERANT</p>
            <p class="label"><strong>*Signature et tampon obligatoire</strong></p>

            <!-- IMAGE CACHET / SIGNATURE -->
            <div class="stamp-image">
                <img src="{{ public_path('assets/img/nova/attestation_signataire_files/Image_001.png') }}">

            </div>


        </div>


    </div>

</body>

</html>