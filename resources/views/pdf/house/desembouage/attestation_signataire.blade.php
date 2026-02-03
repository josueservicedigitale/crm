<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation Signataire</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            margin: 30px;
        }

        h1 {
            text-align: center;
            font-size: 16pt;
            color: #333;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        p {
            margin: 6px 0;
        }

        .bloc-signataire {
            border: 2px dotted #000;
            padding: 15px;
            margin-top: 40px;
            text-align: center;
            height: 180px;
            /* pas trop haut */
            position: relative;
        }

        .bloc-signataire img {
            max-height: 120px;
            width: 300px;
            margin-top: 20px;
        }

        .bloc-signataire span {
            position: absolute;
            bottom: 8px;
            left: 0;
            right: 0;
            font-size: 10pt;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <h1>ATTESTATION DE QUALITÉ DE SIGNATAIRE</h1>

    <p>Je soussigné <b>M.Poulin Thomas</b>, agissant en qualité de Directeur des Services Techniques, atteste que :</p>
    le bâtiment « <b>{{ $document->nom_residence }}</b> » situé à <b>{{ $document->adresse_travaux }}</b>,
    <p>dont le numéro d'immatriculation est <b>{{ $document->numero_immatriculation }}</b>,</p>
    <p>est géré par la société <b>BBR MAINTENANCE</b>, situé au <b>78 AVENUE DES CHAMPS ELYSEES, 75008 PARIS</b> SIRET
        <b>93146162800030.</b></p>


    <br>
    <p>Fait le : <b>{{ $document->date_signature }}</b> à <b>PARIS</b></p>

    <p><b>Nom et prénom du signataire :</b> {{ $document->society }}</p>
    <p><b>Qualité du signataire :</b> {{ $document->activity }}</p>

    <div class="bloc-signataire">
       
        <img src="{{ public_path('assets/img/house/Attestation_signataire_files/Image_001.png') }}"
            alt="Signature et cachet">
        <span>Signature et cachet obligatoires</span>
    </div>

</body>

</html>