@extends('back.layouts.principal')

@section('title', 'Liste des ' . ucfirst($type) . 's')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark">
        <i class="fa fa-list me-2"></i>
        Liste des {{ $type }}s – {{ strtoupper($society) }}
    </h4>

    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Date</th>
                            <th>Client/Description</th>
                            <th>Montant TTC</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($documents as $doc)
                        <tr>
                            <td>
                                <strong>{{ $doc->reference }}</strong>
                                @if($doc->reference_devis)
                                <br><small class="text-muted">Devis: {{ $doc->reference_devis }}</small>
                                @endif
                            </td>
                            <td>{{ $doc->date_devis_formatted }}</td>
                            <td>
                                {{ $doc->title }}
                                @if($doc->nom_residence)
                                <br><small>{{ $doc->nom_residence }}</small>
                                @endif
                            </td>
                            <td>{{ $doc->montant_formatted }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('back.document.create', [$activity, $society, $type, 'reference' => $doc->reference]) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    @if($doc->hasPdf())
                                    <a href="{{ $doc->pdf_url }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Aucun {{ $type }} trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('back.document.edit', [$activity, $society, $type]) }}" 
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>
@endsection