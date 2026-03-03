@extends('back.layouts.principal')

@section('title', 'Sélectionner un devis')

@section('content')
<div class="container-fluid pt-4 px-4">

    <h4 class="fw-bold text-dark mb-4">
        Sélectionnez un devis pour créer un cahier des charges
    </h4>

    {{-- 🔎 Barre de recherche sticky --}}
    <div class="sticky-search-wrapper mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-center">

                    <div class="col-md-8">
                        <div class="input-group input-group-lg">

                            <span class="input-group-text bg-white border-end-0">
                                <i class="fas fa-search text-primary"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control border-start-0"
                                   placeholder="Entrez la référence du devis"
                                   value="{{ request('search') }}">

                            @if(request('search'))
                                <a href="{{ url()->current() }}"
                                   class="btn btn-outline-secondary"
                                   title="Réinitialiser">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif

                        </div>
                    </div>

                    <div class="col-md-4 text-md-end">
                        <button type="submit" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-search me-2"></i>Rechercher
                        </button>
                    </div>

                </form>

                @if(request('search'))
                    <div class="mt-3">
                        <span class="badge bg-light text-dark">
                            Résultats pour :
                            <strong>"{{ request('search') }}"</strong>
                        </span>

                        <span class="ms-2 text-muted">
                            {{ $devisList->count() }} résultat(s) trouvé(s)
                        </span>
                    </div>
                @endif

            </div>
        </div>
    </div>

    {{-- 📄 Liste des devis --}}
    <div class="row">
        @foreach($devisList as $devis)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100 border-0 hover-shadow">
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title fw-bold text-primary">
                            {{ $devis->reference_devis ?? $devis->reference }}
                        </h5>

                        <p class="card-text text-muted">
                            {{ $devis->nom_residence }} <br>
                            {{ $devis->adresse_travaux }}
                        </p>

                        <div class="mt-auto">
                            <a href="{{ route('back.document.cahier-des-charges.create', [$activity, $society, $devis->id]) }}"
                               class="btn btn-success w-100">
                                <i class="fas fa-book me-2"></i>
                                Créer le cahier des charges
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endforeach

        @if($devisList->isEmpty())
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    Aucun devis trouvé.
                </div>
            </div>
        @endif
    </div>

    {{-- Bouton retour --}}
    <div class="mt-4">
        <a href="{{ route('back.document.list', [$activity, $society, 'cahier_des_charges']) }}"
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-1"></i> Retour
        </a>
    </div>

</div>

<style>
.sticky-search-wrapper {
    position: sticky;
    top: 15px;
    z-index: 1020;
}

.hover-shadow:hover {
    transform: translateY(-3px);
    transition: 0.2s ease;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
}
</style>

@endsection