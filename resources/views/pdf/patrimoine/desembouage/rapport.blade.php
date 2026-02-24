<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Attestation de désembouage - {{ $document->reference ?? '' }}</title>

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
    height:178px;
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
    height:200px;
    font-size:10.3px;
    position: relative;
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

  .product-item{ 
    width:100%; 
    margin-bottom:8px; 
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .product-left{ 
    display: flex;
    align-items: center;
    width: 55%;
  }
  .product-img{ 
    width: 40%;
    text-align:right; 
  }
  .product-img img{ 
    height: 35px; 
    max-width: 100%;
    object-fit: contain;
  }

  .product-other {
    margin-top: 8px;
    padding-top: 4px;
    border-top: 1px dashed #e30613;
    font-style: italic;
    color: #333;
  }

  /* RIGHT SIDE (stamp + 3 icons + sentinel) */
  .right-side{
    height:200px;
    text-align:center;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  .stamp img{ 
    height: 60px; 
    max-width: 100%;
    object-fit: contain;
  }
  .icons-red{ 
    display: flex;
    justify-content: center;
    gap: 8px;
    margin: 8px 0;
  }
  .icons-red img{ 
    height: 30px; 
    width: auto;
  }
  .sentinel-logo img{ 
    height: 50px;
    max-width: 100%;
    object-fit: contain;
  }

.dots-bar{
  width:100%;
  border-collapse:collapse;
  table-layout:fixed;
  margin-top:6mm;
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

.product-other-text {
  font-size: 9px;
  padding: 2px 4px;
  background: #f9f9f9;
  border-radius: 4px;
  margin-top: 4px;
  text-align: center;
  word-break: break-word;
}
</style>
</head>

<body>

{{-- =========================================== --}}
{{-- EN-TÊTE AVEC DONNÉES DYNAMIQUES --}}
{{-- =========================================== --}}
<table class="top-info">
  <tr>
    <td style="width:60%;">
      <strong>ADRESSE DE TRAVAUX:</strong><br>
      {{ $document->adresse_travaux ?? 'Non renseignée' }}<br>
      @if($document->code_postal ?? false)
        {{ $document->code_postal }} {{ $document->ville ?? '' }}
      @endif
    </td>
    <td class="right-info" style="width:40%;">
      <strong>N° SIRET :</strong> 93348779500017<br><br>
      <strong>DATE</strong> : {{ $document->date_facture ? \Carbon\Carbon::parse($document->date_facture)->format('d/m/Y') : now()->format('d/m/Y') }}<br>
      <strong>FACTURE N°</strong> : ENR-2025-29-F{{ $document->reference_facture ?? $document->id }}
    </td>
  </tr>
</table>

{{-- Logo CEE (statique) --}}
<div style="text-align:left; margin-bottom:5px;">
  <img class="cee-logo" src="{{ public_path('assets/img/nova/Rapport_files/Image_001.jpg') }}" alt="CEE">
</div>

<div class="title">ATTESTATION DE DÉSEMBOUAGE</div>
<div class="red-line"></div>

{{-- Texte + logos de reconnaissance (STATIQUES) --}}
<table class="desc-row">
  <tr>
    <td class="desc-left">
      <p class="description">
        La société <strong>ENERGIE NOVA</strong> reconnue<br>
        certifie que l’ensemble du réseau hydraulique de chauffage du client a bien été désemboué et protégé
        conformément aux exigences éditées dans la fiche CEE désembouage <strong>BAR – SE – 109</strong>.
      </p>
    </td>
    <td class="desc-right">
      <div class="desc-icons">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1">
        <img src="{{ public_path('assets/img/nova/Rapport_files/ic1.jpg') }}" alt="ic1">
      </div>
    </td>
  </tr>
</table>

{{-- =========================================== --}}
{{-- CRITÈRES D'INSTALLATION (DYNAMIQUES) --}}
{{-- =========================================== --}}
<div class="no-break">
  <table class="main-table">
    <tr>
      <td style="width:25%;">
        <div class="side-box">
          <strong>Bâtiment existant depuis plus de 2 ans à l'engagement de l'opération</strong><br><br>
          @php $batiment = $document->batiment_existant ?? 'oui'; @endphp
          <span class="choice"><span class="cb {{ $batiment == 'oui' ? 'on' : '' }}"></span>Oui</span>
          <span class="choice"><span class="cb {{ $batiment == 'non' ? 'on' : '' }}"></span>Non</span><br><br>

          <strong>Type de logement</strong><br><br>
          @php $logement = $document->type_logement ?? 'maison'; @endphp
          <span class="choice"><span class="cb {{ $logement == 'maison' ? 'on' : '' }}"></span>Maison</span>
          <span class="choice"><span class="cb {{ $logement == 'appartement' ? 'on' : '' }}"></span>Appartement</span><br><br>

          <strong>L'opération concerne une installation collective de chauffage</strong><br><br>
          @php $collective = $document->installation_collective ?? 'oui'; @endphp
          <span class="choice"><span class="cb {{ $collective == 'oui' ? 'on' : '' }}"></span>Oui</span>
          <span class="choice"><span class="cb {{ $collective == 'non' ? 'on' : '' }}"></span>Non</span>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Type de générateur</div>
          @php $generateur = $document->type_generateur ?? 'chaudiere_condensation'; @endphp
          <div class="line"><span class="cb {{ $generateur == 'chaudiere_hors_condensation' ? 'on' : '' }}"></span>Chaudière hors condensation</div>
          <div class="line"><span class="cb {{ $generateur == 'chaudiere_condensation' ? 'on' : '' }}"></span>Chaudière à condensation</div>
          <div class="line"><span class="cb {{ $generateur == 'reseau_chaleur' ? 'on' : '' }}"></span>Réseau de chaleur</div>
          
          @if($generateur == 'autre' && $document->autre_type_generateur)
          <div class="product-other-text">{{ $document->autre_type_generateur }}</div>
          @endif
          
          <div style="margin-top:10px;">
            Puissance nominale du générateur : <strong>{{ $document->puissance_chaudiere ?? '0' }} kW</strong>
          </div>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Nombre d’émetteurs désemboués</div>
          Radiateurs : <strong>{{ $document->nombre_emetteurs ?? '0' }}</strong><br><br>
          Plancher chauffant : <strong>{{ $document->surface_plancher_chauffant ?? '0' }} m²</strong><br><br>

          <div style="margin-top:10px;border:2px dashed #e30613;padding:6px;border-radius:8px;text-align:center;">
            Volume d’eau total du circuit<br>
            <strong>{{ $document->volume_circuit ?? '0' }}</strong> litres
          </div>
        </div>
      </td>

      <td style="width:25%;">
        <div class="panel">
          <div class="panel-title">Nature du réseau</div>
          @php $nature = $document->nature_reseau ?? 'acier'; @endphp
          <div class="line"><span class="cb {{ $nature == 'cuivre' ? 'on' : '' }}"></span>Cuivre</div>
          <div class="line"><span class="cb {{ $nature == 'acier' ? 'on' : '' }}"></span>Acier</div>
          <div class="line"><span class="cb {{ $nature == 'multicouche' ? 'on' : '' }}"></span>Multicouche</div>
          <div class="line"><span class="cb {{ $nature == 'synthese' ? 'on' : '' }}"></span>Matériaux de synthèse</div>
          
          @if($nature == 'autre' && $document->autre_nature_reseau)
          <div class="product-other-text">{{ $document->autre_nature_reseau }}</div>
          @endif
        </div>
      </td>
    </tr>
  </table>
</div>

{{-- =========================================== --}}
{{-- ÉTAPES RÉALISÉES (DYNAMIQUES) --}}
{{-- =========================================== --}}
<div class="section-title">Etapes respectées de l'opération de désembouage</div>
<div class="steps">
  @php
    $etapes = [
      'Rinçage à l’eau du système de distribution par boucle d’eau (général puis réseau par réseau)',
      'Injection d’un réactif désembouant et circulation (général puis réseau par réseau), dans les deux sens de circulation',
      'Rinçage des circuits à l’eau claire (général puis réseau par réseau)',
      'Vérification du filtre/pot à boues et/ou installation d’un filtre + injection d’un réactif inhibiteur au dosage préconisé'
    ];
    $etapesRealisees = $document->etapes_realisees ?? [1,2,3,4];
  @endphp
  
  @foreach($etapes as $index => $etape)
    <div class="step">
      <span class="cb {{ in_array($loop->index + 1, (array)$etapesRealisees) ? 'on' : '' }}"></span>
      {{ $etape }}
    </div>
  @endforeach
</div>

<div class="section-title">Produits utilisés pour l'opération de désembouage</div>

{{-- =========================================== --}}
{{-- PRODUITS DYNAMIQUES --}}
{{-- =========================================== --}}
<div class="no-break">
  <table class="products-table">
    <tr>
      {{-- POMPE À DÉSEMBOUER (DYNAMIQUE) --}}
      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Pompe à désembouer</div>
          
          @php
            $pompe = $document->pompe_type ?? 'Pompe Jet Flush';
            $pompeTexte = $document->pompe_autre_texte ?? '';
          @endphp
          
          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $pompe == 'Pompe Jet Flush' ? 'on' : '' }}"></span>
              Pompe Jet Flush
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/001.png') }}" alt="Pompe Jet Flush">
            </span>
          </div>

          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $pompe == 'JetFlush Filter' ? 'on' : '' }}"></span>
              JetFlush Filter
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/002.png') }}" alt="JetFlush Filter">
            </span>
          </div>

          <!-- {{-- MARQUES SUPPLÉMENTAIRES --}}
          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $pompe == 'Kiloutou' ? 'on' : '' }}"></span>
              Kiloutou
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/001.png') }}" alt="Kiloutou">
            </span>
          </div>

          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $pompe == 'Vixax' ? 'on' : '' }}"></span>
              Vixax
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/002.png') }}" alt="Vixax">
            </span>
          </div> -->

          @if($pompe == 'autre' && $pompeTexte)
          <div class="product-other">
            <span class="cb on"></span> Autre : {{ $pompeTexte }}
          </div>
          @endif
        </div>
      </td>

      {{-- RÉACTIF DÉSEMBOUANT (DYNAMIQUE) --}}
      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Réactif désembouant</div>
          
          @php
            $reactif = $document->reactif_desembouant ?? 'Sentinel X800';
            $autreReactif = $document->autre_produit_desembouant ?? '';
          @endphp
          
          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $reactif == 'Sentinel X400' ? 'on' : '' }}"></span>
              Sentinel X400
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/003.png') }}" alt="Sentinel X400">
            </span>
          </div>

          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $reactif == 'Sentinel X800' ? 'on' : '' }}"></span>
              Sentinel X800
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/004.png') }}" alt="Sentinel X800">
            </span>
          </div>

          @if($reactif == 'autre' && $autreReactif)
          <div class="product-other">
            <span class="cb on"></span> Autre : {{ $autreReactif }}
          </div>
          @endif
        </div>
      </td>

      {{-- RÉACTIF INHIBITEUR (DYNAMIQUE) --}}
      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Réactif inhibiteur</div>
          
          @php
            $inhibiteur = $document->reactif_inhibiteur ?? 'Sentinel X100';
            $autreInhibiteur = $document->autre_produit_inhibiteur ?? '';
          @endphp
          
          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $inhibiteur == 'Sentinel X100' ? 'on' : '' }}"></span>
              Sentinel X100
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/005.png') }}" alt="Sentinel X100">
            </span>
          </div>

          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $inhibiteur == 'Sentinel X700' ? 'on' : '' }}"></span>
              Sentinel X700
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/006.png') }}" alt="Sentinel X700">
            </span>
          </div>

          @if($inhibiteur == 'autre' && $autreInhibiteur)
          <div class="product-other">
            <span class="cb on"></span> Autre : {{ $autreInhibiteur }}
          </div>
          @endif
        </div>
      </td>

      {{-- FILTRE (DYNAMIQUE) --}}
      <td style="width:16%;">
        <div class="product-box">
          <div class="product-title">Installation filtre</div>
          
          @php
            $filtre = $document->filtre_type ?? 'Sentinel Vortex500';
            $autreFiltre = $document->filtre_autre_texte ?? '';
          @endphp
          
          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $filtre == 'Sentinel Vortex300' ? 'on' : '' }}"></span>
              Sentinel Vortex300
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/007.png') }}" alt="Vortex300">
            </span>
          </div>

          <div class="product-item">
            <span class="product-left">
              <span class="cb {{ $filtre == 'Sentinel Vortex500' ? 'on' : '' }}"></span>
              Sentinel Vortex500
            </span>
            <span class="product-img">
              <img src="{{ public_path('assets/img/nova/Rapport_files/008.png') }}" alt="Vortex500">
            </span>
          </div>

          @if($filtre == 'autre' && $autreFiltre)
          <div class="product-other">
            <span class="cb on"></span> Autre : {{ $autreFiltre }}
          </div>
          @endif
        </div>
      </td>

      {{-- COLONNE DROITE (STATIQUE SAUF CACHET) --}}
      <td style="width:20%;">
        <div class="right-side">
          {{-- Cachet (DYNAMIQUE - PEUT CHANGER) --}}
          <div class="stamp">
            @if($document->cachet_image ?? false)
              @php $cachetPath = Storage::path($document->cachet_image); @endphp
              <img src="{{ file_exists($cachetPath) ? $cachetPath : public_path('assets/img/nova/Rapport_files/cachet.png') }}" alt="Cachet">
            @else
              <img src="{{ public_path('assets/img/nova/Rapport_files/cachet.png') }}" alt="Cachet">
            @endif
          </div>

          {{-- 3 icônes rouges (STATIQUES) --}}
          <div class="icons-red">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic01.png') }}" alt="ic01">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic02.png') }}" alt="ic02">
            <img src="{{ public_path('assets/img/nova/Rapport_files/ic03.png') }}" alt="ic03">
          </div>

          {{-- Logo Sentinel (STATIQUE) --}}
          <div class="sentinel-logo">
            <img src="{{ public_path('assets/img/nova/Rapport_files/sent.png') }}" alt="SENTINEL">
          </div>
        </div>
      </td>
    </tr>
  </table>
</div>

{{-- =========================================== --}}
{{-- FOOTER DOTS (STATIQUE) --}}
{{-- =========================================== --}}
<table class="dots-bar">
  @for($l = 0; $l < 3; $l++)
  <tr>
    @for($i = 0; $i < 40; $i++)
      <td></td>
    @endfor
  </tr>
  @endfor
</table>
</body>
</html>