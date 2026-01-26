{{-- resources/views/back/documents/show.blade.php --}}
@extends('back.layouts.principal')

@section('title', 'Document ' . $document->reference)

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="alert alert-success">
        <h4><i class="fa fa-check-circle"></i> Document créé avec succès !</h4>
        <p>Le document a été généré et sauvegardé.</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Détails du document</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Référence:</th>
                    <td>{{ $document->reference }}</td>
                </tr>
                <tr>
                    <th>Société:</th>
                    <td>{{ $document->society_name }}</td>
                </tr>
                <tr>
                    <th>Activité:</th>
                    <td>{{ $document->activity_name }}</td>
                </tr>
                <tr>
                    <th>Type:</th>
                    <td>{{ $document->type_name }}</td>
                </tr>
                <tr>
                    <th>Créé le:</th>
                    <td>{{ $document->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @if($document->file_path)
                <tr>
                    <th>Fichier PDF:</th>
                    <td>
                        <a href="{{ asset($document->file_path) }}" target="_blank" class="btn btn-primary">
                            <i class="fa fa-eye"></i> Voir le PDF
                        </a>
                        <a href="{{ route('back.document.preview', [$activity, $society, $type, $document->id]) }}" 
                           target="_blank" class="btn btn-info">
                            <i class="fa fa-search"></i> Prévisualiser
                        </a>
                    </td>
                </tr>
                @endif
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('back.document.list', [$activity, $society, $type]) }}" class="btn btn-secondary">
                <i class="fa fa-list"></i> Voir tous les documents
            </a>
            <a href="{{ route('back.activity.dashboard', [$activity, $society]) }}" class="btn btn-primary">
                <i class="fa fa-dashboard"></i> Retour au dashboard
            </a>
        </div>
    </div>
</div>
@endsection