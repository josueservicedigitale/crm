@extends('back.layouts.principal')

@section('title', 'Modifier - ' . ucfirst($type))

@section('content')
<div class="container-fluid pt-4 px-4">
    <h4 class="fw-bold text-dark">
        <i class="fa fa-search me-2"></i>
        Modifier un {{ $type }} – {{ strtoupper($society) }}
    </h4>

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('back.document.search', [$activity, $society, $type]) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="reference" class="form-label">Entrer la référence du document</label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="reference" 
                                   name="reference" 
                                   placeholder="Ex: NOVA-DEV-123456789" 
                                   required>
                            <div class="form-text">La référence se trouve sur le document PDF</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa fa-search me-2"></i> Rechercher
                            </button>
                            <a href="{{ route('back.document.choose', [$activity, $society, $type]) }}" 
                               class="btn btn-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('back.document.list', [$activity, $society, $type]) }}" 
                   class="btn btn-info">
                    <i class="fa fa-list me-1"></i> Voir la liste des {{ $type }}s
                </a>
            </div>
        </div>
    </div>
</div>
@endsection