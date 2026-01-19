@extends('back.layouts.principal')

@section('title', 'Liste des ' . ucfirst($type))

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark">Liste des {{ $type }} – {{ strtoupper($society) }}</h4>

    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Référence</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documents as $doc)
            <tr>
                <td>{{ $doc->reference }}</td>
                <td>{{ $doc->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('back.document.show', [$activity, $society, $type, $doc->id]) }}" class="btn btn-primary btn-sm">Voir PDF</a>
                    <a href="{{ route('back.document.edit', [$activity, $society, $type, $doc->id]) }}" class="btn btn-warning btn-sm">Modifier</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('back.dashboard', [$activity, $society]) }}" class="btn btn-secondary mt-3">Retour au dashboard</a>
</div>
@endsection
