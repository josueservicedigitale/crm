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
        p { margin: 6px 0; }
        .bloc-signataire {
            border: 2px dotted #000;
            padding: 15px;
            margin-top: 40px;
            text-align: center;
            height: 180px; /* hauteur réduite */
            position: relative;
        }
        .bloc-signataire img {
            max-height: 120px;
            width: 300px;
            padding-top: 10px;
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

    <p>Je soussigné <b>M. Offel De Villaucourt Charles</b>, agissant en qualité de <b>Gérant</b>, atteste que :</p>
    <p>Le bâtiment <b>{{ $document->nom_residence ?? 'Inconnu' }}</b>, situé à <b>{{ $document->adresse_travaux ?? 'Adresse inconnue' }}</b>,</p>
    <p>immatriculé sous le numéro <b>{{ $document->numero_immatriculation ?? 'Numéro inconnu' }}</b>, est géré par <b>RABATHERM HECS</b>,</p>
    <p>dont le siège est au <b>21 Rue d’Anjou, 92600 Asnières-sur-Seine</b>, SIRET <b>44261333700033</b>.</p>

    <p>Fait le : <b>{{ $document->date_signature ?? 'Date inconnue' }}</b> à <b>ASNIERES-SUR-SEINE</b></p>

    <p><b>Nom et prénom du signataire :</b> Offel De Villaucourt Charles</p>
    <p><b>Qualité du signataire :</b> Gérant</p>

    <div class="bloc-signataire">
        <!-- Image signature + cachet -->
        <img src="{{ public_path('assets/img/nova/attestation_signataire_files/Image_001.png') }}" alt="Signature et cachet">
        <span>Signature et cachet obligatoires</span>
    </div>

</body>
</html>
