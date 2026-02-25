@extends('back.layouts.principal')

@section('title', 'Détails corbeille')

@section('content')
<div class="container-fluid pt-4 px-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="mb-0">
                <i class="fas fa-eye me-2 text-primary"></i>Détails
            </h4>
            <small class="text-muted">Élément supprimé : <strong>{{ $element->nom_type }}</strong></small>
        </div>

        <a href="{{ route('back.corbeille.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Type</div>
                        <div class="fw-bold">{{ $element->nom_type }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Supprimé par</div>
                        <div class="fw-bold">{{ $element->supprimePar->name ?? 'Système' }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 bg-light rounded">
                        <div class="text-muted small">Date suppression</div>
                        <div class="fw-bold">{{ $element->supprime_le?->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <hr>

            <h6 class="fw-bold mb-2">
                <i class="fas fa-database me-2 text-info"></i>Données sauvegardées
            </h6>

            @if(!empty($donnees))
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 30%">Clé</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donnees as $key => $value)
                                <tr>
                                    <td class="text-muted">{{ $key }}</td>
                                    <td>
                                        @if(is_array($value))
                                            <pre class="mb-0">{{ json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                        @else
                                            {{ $value }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Aucune donnée sauvegardée.
                </div>
            @endif

            <hr>

            <div class="d-flex gap-2">
                <form action="{{ route('back.corbeille.restaurer', $element->id) }}" method="POST"
                      onsubmit="return confirm('Restaurer cet élément ?')">
                    @csrf
                    <button class="btn btn-success">
                        <i class="fas fa-undo me-2"></i>Restaurer
                    </button>
                </form>

                <form action="{{ route('back.corbeille.supprimer-definitivement', $element->id) }}" method="POST"
                      onsubmit="return confirm('Supprimer définitivement ? Action irréversible !')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Supprimer définitivement
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
@endsection