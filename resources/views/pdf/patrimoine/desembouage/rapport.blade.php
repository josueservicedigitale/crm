<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Attestation de désembouage</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            color: #333;
            font-size: 12px;
        }

        /* HEADER TOP INFO */
        .top-info {
            width: 100%;
            margin-bottom: 15px;
        }

        .top-info td {
            vertical-align: top;
            font-size: 12px;
        }

        .right-info {
            text-align: right;
        }

        /* TITLE */
        .title {
            text-align: center;
            color: #e30613;
            font-weight: bold;
            font-size: 20px;
            margin: 10px 0 5px 0;
        }

        .red-line {
            border-top: 3px solid #e30613;
            margin: 5px 0 15px 0;
        }

        /* DESCRIPTION */
        .description {
            text-align: center;
            margin-bottom: 15px;
        }

        /* GREY SIDE BOX */
        .side-box {
            width: 180px;
            background: #eee;
            padding: 10px;
            border-radius: 8px;
            font-size: 11px;
            text-align: center;
        }

        /* MAIN GRID */
        .main-table {
            width: 100%;
        }

        .main-table td {
            vertical-align: top;
            padding: 5px;
        }

        /* RED PANELS */
        .panel {
            border: 2px dashed #e30613;
            border-radius: 12px;
            padding: 10px;
            height: 200px;
        }

        .panel-title {
            background: #e30613;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 4px;
            border-radius: 8px;
            margin: -10px -10px 8px -10px;
            font-size: 12px;
        }

        /* CHECKBOX STYLE */
        input[type=checkbox] {
            transform: scale(0.9);
            margin-right: 4px;
        }

        /* SECTION TITLES */
        .section-title {
            color: #e30613;
            font-weight: bold;
            margin: 18px 0 6px 0;
        }

        /* PRODUCT BOXES */
        .product-box {
            border: 2px dashed #e30613;
            border-radius: 12px;
            padding: 8px;
            height: 200px;
            font-size: 11px;
        }

        .product-title {
            background: #e30613;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 4px;
            border-radius: 8px;
            margin: -8px -8px 8px -8px;
        }

        .product-box img {
            height: 50px;
            display: inline;
            margin: 5px auto;
        }

        /* FOOT LOGOS */
        .footer-logos {
            margin-top: 15px;
            text-align: center;
        }

        .footer-logos img {
            height: 100px;
            width: 200px;
        }

        /* LIGNE PRODUIT AVEC CHECKBOX + NOM + IMAGE */
        .product-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .product-left {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .product-item img {
            height: 38px;
            margin-left: 10px;
        }

        .choice {
            display: inline-block;
            margin-right: 14px;
            /* espace entre Oui et Non */
        }
    </style>
</head>

<body>

    <table class="top-info">
        <tr>
            <td>
                <strong>ADRESSE DE TRAVAUX:</strong><br>
                {{ $document->adresse_travaux }}<br><br>
            </td>
            <td class="right-info">
                <strong>N° SIRET :</strong> 93348779500017<br><br>
                <strong>DATE</strong> : {{ $document->date_facture }}<br>
                <strong>FACTURE N°</strong> : ENR-2025-29-F{{ $document->reference_facture }}
            </td>
        </tr>
    </table>

    <div style="text-align:left;">
        <img src="/assets/img/house/Rapport_files/image_001.jpg" height="50">
    </div>

    <div class="title">ATTESTATION DE DÉSEMBOUAGE</div>
    <div class="red-line"></div>

    <p class="description">
        La société <strong>PATRIMOINE</strong> reconnue certifie que l’ensemble du réseau hydraulique de chauffage du
        client a bien été désemboué et protégé conformément aux exigences éditées dans la fiche CEE désembouage
        <strong>BAR – SE – 109</strong>.
    </p>

    <table class="main-table">
        <tr>
            <td width="40%">
                <div class="side-box">
                    <strong>Bâtiment existant depuis plus de 2 ans à l'engagement de l'opération</strong><br><br>
                    <label class="choice"><input type="checkbox"> Oui</label>
                    <label class="choice"><input type="checkbox"> Non</label><br><br>

                    <strong>Type de logement</strong><br><br>
                    <label class="choice"><input type="checkbox"> Maison</label>
                    <label class="choice"><input type="checkbox"> Appartement</label><br><br>

                    <strong>L'opération concerne une installation globale de chauffage</strong><br><br>
                    <label class="choice"><input type="checkbox"> Oui</label>
                    <label class="choice"><input type="checkbox"> Non</label>
                </div>
            </td>


            <td width="40%">
                <div class="panel">
                    <div class="panel-title">Type de générateur</div>
                    <input type="checkbox"> Chaudière hors condensation<br><br>
                    <input type="checkbox"> Chaudière à condensation<br><br>
                    <input type="checkbox"> Réseau de chaleur<br><br>
                    Puissance nominale du générateur: <strong>{{ $document->puissance_chaudiere }} kW</strong>
                </div>
            </td>

            <td width="40%">
                <div class="panel">
                    <div class="panel-title">Nombre d’émetteurs désemboués</div>
                    Radiateurs : <strong>{{ $document->nombre_emetteurs }}</strong><br><br>
                    Plancher chauffant : <strong>m2</strong><br><br><br>
                    <div
                        style="margin-top:10px;border:2px dashed #e30613;padding:6px;border-radius:8px;text-align:center;">
                        Volume d’eau total du circuit<br>
                        <strong>{{ $document->volume_circuit }}</strong> litres
                    </div>
                </div>
            </td>

            <td width="40%">
                <div class="panel">
                    <div class="panel-title">Nature du réseau</div>
                    <input type="checkbox"> Cuivre<br><br>
                    <input type="checkbox"> Acier<br><br>
                    <input type="checkbox"> Multicouche<br><br>
                    <input type="checkbox"> Matériaux de synthèse<br><br>
                    <input type="checkbox"> Autre
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Etapes respectées de l'opération de désembouage</div>
    <p>
        <input type="checkbox"> Rinçage à l'eau du système de distribution par boucle d'eau<br>
        <input type="checkbox"> Injection d'un réactif désembouant et circulation<br>
        <input type="checkbox"> Rinçage des circuits à l'eau claire<br>
        <input type="checkbox"> Vérification du filtre et injection d’un réactif inhibiteur
    </p>

    <div class="section-title">Produits utilisés pour l'opération de désembouage</div>

    <table width="100%">
        <tr>

            <td width="25%">
                <div class="product-box">
                    <div class="product-title">Pompe à désembouer</div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Pompe
                            Jet Flush
                        </div>
                        <img src="/assets/img/nova/Rapport_files/JET.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> JetFlush
                            Filter
                        </div>
                        <img src="/assets/img/nova/Rapport_files/FILTER.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Autre
                        </div>
                    </div>
                </div>
            </td>

            <td width="25%">
                <div class="product-box">
                    <div class="product-title">Réactifs désembouant</div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel X400
                        </div>
                        <img src="/assets/img/nova/Rapport_files/senti400.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel X800
                        </div>
                        <img src="/assets/img/nova/Rapport_files/senti800.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Autre
                        </div>
                    </div>
                </div>
            </td>

            <td width="25%">
                <div class="product-box">
                    <div class="product-title">Réactif inhibiteur</div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel X100
                        </div>
                        <img src="/assets/img/nova/Rapport_files/senti100.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel X700
                        </div>
                        <img src="/assets/img/nova/Rapport_files/senti700.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Autre
                        </div>
                    </div>
                </div>
            </td>

            <td width="25%">
                <div class="product-box">
                    <div class="product-title">Installations filtre</div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel Vortex 300
                        </div>
                        <img src="/assets/img/nova/Rapport_files/vortex300.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Sentinel Vortex 500
                        </div>
                        <img src="/assets/img/nova/Rapport_files/vortex500.png">
                    </div>

                    <div class="product-item">
                        <div class="product-left">
                            <input type="checkbox"> Autre
                        </div>
                    </div>
                </div>
            </td>

        </tr>
    </table>


    <div class="footer-logos">
        <img src="/assets/img/nova/Rapport_files/Image_005.png">
    </div>

</body>

</html>