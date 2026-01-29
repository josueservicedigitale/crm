
@extends('back.layouts.principal')

@section('title', ucfirst($type) . ' - ' . strtoupper($society))

@section('content')
<div class="container-fluid pt-4 px-4">
    @include('back.documents.partials.debug-info')
    @include('back.documents.partials.header')
    
    <form method="POST"
          action="{{ isset($document) && $document->id
            ? route('back.document.update', [$activity, $society, $type, $document->id])
            : route('back.document.store', [$activity, $society, $type]) }}"
          class="needs-validation"
          novalidate>
        @csrf
        
        @if(isset($document) && $document->id && $type !== 'rapport')
            @method('PUT')
        @endif
        
        {{-- Inclure le formulaire spécifique au type de document --}}
        @switch($type)
            @case('devis')
                @include('back.documents.forms.devis')
                @break
            @case('facture')
                @include('back.documents.forms.facture')
                @break
            @case('attestation_realisation')
                @include('back.documents.forms.attestation_realisation')
                @break
            @case('attestation_signataire')
                @include('back.documents.forms.attestation-signataire')
                @break
            @case('cahier_des_charges')
                @include('back.documents.forms.cahier-des-charges')
                @break
            @case('rapport')
                @include('back.documents.forms.rapport')
                @break
        @endswitch
        
        @include('back.documents.partials.form-actions')
    </form>
</div>
@endsection