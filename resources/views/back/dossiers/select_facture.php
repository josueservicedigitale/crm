@extends('back.layouts.principal')

@section('title', 'Sélectionner une facture pour rapport')

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark">
        <i class="fa fa-file-invoice me-2"></i>
        Sélectionner une facture pour créer un rapport – {{ strtoupper($society) }}
    </h4>

    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Date</th>
                            <th>Réf. Devis</th>
                            <th>Client</th>
                            <th>Montant TTC</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($factures as $facture)
                        <tr>
                            <td><strong>{{ $facture->reference }}</strong></td>
                            <td>{{ $facture->date_devis_formatted }}</td>
                            <td>{{ $facture->reference_devis ?? '-' }}</td>
                            <td>
                                {{ $facture->title }}
                                @if($facture->nom_residence)
                                <br><small>{{ $facture->nom_residence }}</small>
                                @endif
                            </td>
                            <td>{{ $facture->montant_formatted }}</td>
                            <td>
                                <a href="{{ route('back.document.create', [
                                    'activity' => $activity,
                                    'society' => $society,
                                    'type' => 'rapport',
                                    'facture_ref' => $facture->reference
                                ]) }}" 
                                   class="btn btn-sm btn-success">
                                    <i class="fa fa-plus me-1"></i> Créer rapport
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Aucune facture disponible
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('back.document.choose', [$activity, $society, 'rapport']) }}" 
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>
@endsection