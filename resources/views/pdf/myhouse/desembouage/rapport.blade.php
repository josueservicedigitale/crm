<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Attestation de désembouage</title>

<style>
  /* DOMPDF SAFE */
  @page { size: A4; margin: 5mm 5mm; }

  body{
    font-family: Arial, sans-serif;
    margin:0;
    color:#333;
    font-size:13px;
  }
  *{ box-sizing:border-box; }

  /* Anti coupure dompdf */
  .no-break{
    page-break-inside: avoid;
    break-inside: avoid;
    -webkit-column-break-inside: avoid;
  }

  /* HEADER TOP INFO */
  .top-info{
    width:100%;
    margin-bottom:20px;
    border-collapse:collapse;
    table-layout:fixed;
  }
  .top-info td{ vertical-align:top; font-size:11px; }
  .right-info{ text-align:right; }

  /* TITLE */
  .title{
    text-align:center;
    color:#e30613;
    font-weight:bold;
    font-size:18px;
    margin:8px 0 4px 0;
  }
  .red-line{
    border-top:3px solid #e30613;
    margin:5px 0 10px 0;
  }

  /* DESCRIPTION + icons row like capture */
  .desc-row{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    margin-bottom:6px;
  }
  .desc-row td{ vertical-align:middle; }
  .desc-left{ width:72%; }
  .desc-right{ width:28%; text-align:right; }

  .description{
    text-align:left;
    line-height:1.25;
    margin:0;
  }
  .desc-icons img{
    height: 40px;
    margin-left:6px;
    vertical-align:middle;
  }

  /* Logo CEE */
  .cee-logo{ height:45px; }

  /* GREY SIDE BOX */
  .side-box{
    background:#eee;
    padding:8px;
    border-radius:8px;
    font-size:10.5px;
    text-align:center;
    line-height:1.2;
  }

  /* MAIN GRID */
  .main-table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    margin-top:4px;
  }
  .main-table td{ vertical-align:top; padding:4px; }

  /* RED PANELS */
  .panel{
    border:2px dashed #e30613;
    border-radius:12px;
    padding:8px;
    height:178px; /* ajusté pour tenir */
  }
  .panel-title{
    background:#e30613;
    color:white;
    font-weight:bold;
    text-align:center;
    padding:4px;
    border-radius:8px;
    margin:-8px -8px 8px -8px;
    font-size:11px;
  }

  /* Checkbox fake (dompdf fiable) */
  .cb{
    display:inline-block;
    width:11px;
    height:11px;
    border:1px solid #b1afaf;
    margin-right:5px;
    vertical-align:middle;
    background:#fff;
  }
  .cb.on{ background:#111; }
  .choice{
    display:inline-block;
    margin-right:12px;
    white-space:nowrap;
  }
  .line{ margin:5px 0; white-space:nowrap; }

  /* SECTION TITLES */
  .section-title{
    color:#e30613;
    font-weight:bold;
    margin:10px 0 6px 0;
  }

  /* STEPS */
  .steps .step{ margin:4px 0; line-height:1.2; }

  /* PRODUCTS ROW -> 5 columns like capture */
  .products-table{
    width:100%;
    border-collapse:collapse;
    table-layout:fixed;
    margin-top:4px;
  }
  .products-table td{ vertical-align:top; padding-right:6px; }
  .products-table td:last-child{ padding-right:0; }

  .product-box{
    border:2px dashed #e30613;
    border-radius:12px;
    padding:6px;
    height:180px; /* réduit pour garder 1 page */
    font-size:10.3px;
  }
  .product-title{
    background:#e30613;
    color:#fff;
    text-align:center;
    font-weight:bold;
    padding:4px;
    border-radius:8px;
    margin:-6px -6px 8px -6px;
    font-size:11px;
  }

  .product-item{ width:100%; margin-bottom:6px; white-space:nowrap; }
  .product-left{ display:inline-block; vertical-align:middle; width:70%; }
  .product-img{ display:inline-block; vertical-align:middle; width:40%; text-align:right; }
  .product-img img{ height:40px; }

  /* RIGHT SIDE (stamp + 3 icons + sentinel) */
  .right-side{
    height:160px;
    text-align:center;
  }
  .stamp img{ height:72px; }
  .sig img{ height:auto; margin-top:4px; } /* signature image */
  .icons-red img{ height:30px; margin:4px 4px 0 4px; }
  .sentinel-logo img{ height:140px;}

.dots-bar{
  width:100%;
  border-collapse:collapse;
  table-layout:fixed;
  margin-top:6mm; /* espace avant le footer dots */
}
.dots-bar td{
  height:6px;
  width:2.5%;
  text-align:center;
  vertical-align:middle;
  padding:0;
}

.dots-bar td:before{
  content:"";
  display:inline-block;
  width:4px;
  height:4px;
  background:#111;
  border-radius:50%;
}
</style>
</head>

<body>

<table class="top-info">
  <tr>
    <td style="width:60%;">
      <strong>ADRESSE DE TRAVAUX:</strong><br>
      27 Rue Pierre Benoit<br>
      12 Rue Toulouse Lautrec<br>
      33500 Libourne
    </td>
    <td class="right-info" style="width:40%;">
      <strong>N° SIRET :</strong> 93348779500017<br><br>
      <strong>DATE</strong> : 16/10/2025<br>
      <strong>FACTURE N°</strong> : ENR-2025-29-F873
    </td>
  </tr>
</table>

<!-- Logo CEE à gauche comme capture -->
<div style="text-align:left; margin-bottom:5px;">
  <img class="cee-logo" src="{{ public_path('assets/img/nova/Rapport_files/Image_001.jpg') }}" alt="CEE">
</div>

<div class="title">ATTESTATION DE DÉSEMBOUAGE</div>
<div class="red-line"></div>

<!-- ✅ Texte + logos de reconnaissance (en haut à droite) -->
<table class="desc-row">
  <tr>
    <td class="desc-left">
      <p class="description">
        La société <strong>M'Y HOUSE</strong> reconnue<br>
        certifie que l’ensemble du réseau hydraulique de chauffage du client a bien été désemboué et protégé
        conformément aux exigences éditées dans la fiche CEE désembouage <strong>BAR – SE – 109</strong>.
      </p>
    </td>
    <td class="desc-right">
      <div class="desc-icons">
        
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1.jpg">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1.jpg">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1.jpg">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1.jpg">
      </div>
    </td>
  </tr>
</table>


<div class="no-break">
  <table class="main-table">
    <tr>
      <td style="width:25%;">
        <div class="side-box">
          <strong>Bâtiment existant depuis plus de 2 ans à l'engagement de l'opération</strong><br><br>
          <span class="choice"><span class="cb on"></span>Oui</span>
          <span class="choice"><span class="cb"></span>Non</span><br><br>

          <strong>Type de logement</strong><br><br>
          <span class="choice"><span class="cb on"></span>Maison</span>
          <span class="choice"><span class="cb"></span>Appartement</span><br><br>

          <strong>L'opération concerne une installation collective de chauffage</strong><br><br>
          <span class="choice"><span class="cb on"></span>Oui</span>
          <span class="choice"><span class="cb"></span>Non</span>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Type de générateur</div>
          <div class="line"><span class="cb"></span>Chaudière hors condensation</div>
          <div class="line"><span class="cb on"></span>Chaudière à condensation</div>
          <div class="line"><span class="cb"></span>Réseau de chaleur</div>
          <div style="margin-top:10px;">
            Puissance nominale du générateur : <strong>720 kW</strong>
          </div>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Nombre d’émetteurs désemboués</div>
          Radiateurs : <strong>504</strong><br><br>
          Plancher chauffant : <strong>m²</strong><br><br>

          <div style="margin-top:10px;border:2px dashed #e30613;padding:6px;border-radius:8px;text-align:center;">
            Volume d’eau total du circuit<br>
            <strong>5 583</strong> litres
          </div>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Nature du réseau</div>
          <div class="line"><span class="cb"></span>Cuivre</div>
          <div class="line"><span class="cb on"></span>Acier</div>
          <div class="line"><span class="cb"></span>Multicouche</div>
          <div class="line"><span class="cb"></span>Matériaux de synthèse</div>
          <div class="line"><span class="cb"></span>Autre</div>
        </div>
      </td>
    </tr>
  </table>
</div>

<div class="section-title">Etapes respectées de l'opération de désembouage</div>
<div class="steps">
  <div class="step"><span class="cb on"></span>Rinçage à l’eau du système de distribution par boucle d’eau (général puis réseau par réseau)</div>
  <div class="step"><span class="cb on"></span>Injection d’un réactif désembouant et circulation (général puis réseau par réseau), dans les deux sens de circulation</div>
  <div class="step"><span class="cb on"></span>Rinçage des circuits à l’eau claire (général puis réseau par réseau)</div>
  <div class="step"><span class="cb on"></span>Vérification du filtre/pot à boues et/ou installation d’un filtre + injection d’un réactif inhibiteur au dosage préconisé</div>
</div>

<div class="section-title">Produits utilisés pour l'opération de désembouage</div>

<!-- ✅ Produits + colonne cachet/signature/icônes/sentinel -->
<div class="no-break">
  <table class="products-table">
    <tr>
      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Pompe à désembouer</div>

          <div class="product-item">
            <span class="product-left"><span class="cb on"></span>Pompe Jet Flush</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/001.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>JetFlush Filter</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/002.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Autre</span>
            <span class="product-img"></span>
          </div>
        </div>
      </td>

      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Réactif désembouant</div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Sentinel X400</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/003.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb on"></span>Sentinel X800</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/004.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Autre</span>
            <span class="product-img"></span>
          </div>
        </div>
      </td>

      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Réactif inhibiteur</div>

          <div class="product-item">
            <span class="product-left"><span class="cb on"></span>Sentinel X100</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/005.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Sentinel X700</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/006.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Autre</span>
            <span class="product-img"></span>
          </div>
        </div>
      </td>

      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Installation filtre</div>

          <div class="product-item">
            <span class="product-left"><span class="cb"></span>Sentinel Vortex300</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/007.png') }}" alt=""></span>
          </div>

          <div class="product-item">
            <span class="product-left"><span class="cb on"></span>Sentinel Vortex500</span>
            <span class="product-img"><img src="{{ public_path('assets/img/nova/Rapport_files/008.png') }}" alt=""></span>
          </div>
        </div>
      </td>

      <!-- ✅ COLONNE DROITE comme capture -->
      <td style="width:20%;">
        <div class="right-side">
          <!-- Cachet -->
          <div class="stamp">
            <img src="{{ public_path('assets/img/nova/Rapport_files/cachet.png') }}" alt="Cachet">
          </div>

          <!-- Signature (image)
          <div class="sig">
            <img src="{{ public_path('assets/img/nova/Rapport_files/signature.png') }}" alt="Signature Energie Nova">
          </div> -->

          <!-- 3 icônes rouges -->
          <div class="icons-red">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic01.png') }}" alt="ic01">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic02.png') }}" alt="ic02">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic03.png') }}" alt="ic03">
          </div>

          <!-- Sentinel -->
          <div class="sentinel-logo">
            <img src="{{ public_path('assets/img/nova/Rapport_files/sent.png') }}" alt="SENTINEL">
          </div>
        </div>
      </td>
    </tr>
  </table>
</div>

<!-- ✅ 3 lignes de points en bas comme footer -->
<!-- FOOTER DOTS -->
<table class="dots-bar">
  <tr>
    <!-- répète autant de <td> que tu veux -->
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
  </tr>
  <tr>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
  </tr>
  <tr>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
  </tr>
</table>
</body>
</html>