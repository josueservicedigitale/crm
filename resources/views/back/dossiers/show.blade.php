@extends('back.layouts.principal')

@section('title', 'Document')

@section('content')
<div class="container-fluid pt-4 px-4">

    <h4 class="fw-bold mb-4">
        {{ strtoupper($document->type) }} – {{ $document->reference }}
    </h4>

    {{-- Boutons d’actions --}}
    <div class="mb-4 d-flex gap-2">

        {{-- Télécharger le PDF --}}
        <a href="{{ route('back.document.show', [$activity, $society, $type, $document->id]) }}"
           class="btn btn-primary">
            Télécharger PDF
        </a>


        @if($document->type === 'devis')
            <a href="{{ route(
                'back.document.facture.create',
                [$activity, $society, 'facture', $document->id]
            ) }}" class="btn btn-success">
                <i class="fa fa-file-invoice"></i> Créer la facture
            </a>
        @endif

    </div>

</div>
@endsection
