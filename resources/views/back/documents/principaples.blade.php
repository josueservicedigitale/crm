@extends('back.layouts.principal')

@section('title', ucfirst($type) . ' - ' . strtoupper($society))

@section('content')
<div class="container-fluid pt-4 px-4">
    <form method="POST"
        action="{{ isset($document) && $document->id
            ? route('back.document.update', [$activity, $society, $type, $document->id])
            : route('back.document.store', [$activity, $society, $type]) }}"
        class="needs-validation" novalidate>
        @csrf
        @if(isset($document) && $document->id && $type !== 'rapport')
            @method('PUT')
        @endif

        {{-- Include spécifique selon le type --}}
        @includeIf("back.documents.forms.$type")

        <div class="mb-4 d-flex justify-content-between">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">Retour</a>
            <button type="submit" class="btn btn-primary btn-lg">
                {{ isset($document->id) ? 'Mettre à jour le ' : 'Créer le ' }}{{ str_replace('_', ' ', $type) }}
            </button>
        </div>
    </form>
</div>
@endsection