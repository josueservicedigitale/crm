@extends('layouts.admin')

@section('titre', 'Vider la corbeille')

@section('contenu')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Vider la corbeille
                    </h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">
                            <i class="fas fa-skull-crossbones me-2"></i>
                            Attention ! Action irréversible
                        </h5>
                        <p class="mb-0">
                            Vous êtes sur le point de vider définitivement toute la corbeille.
                            <strong>{{ $nombreElements }} éléments</strong> seront supprimés de manière permanente.
                        </p>
                    </div>
                    
                    <div class="mb-4">
                        <h5>Conséquences :</h5>
                        <ul>
                            <li>Tous les éléments seront définitivement supprimés</li>
                            <li>Cette action ne peut pas être annulée</li>
                            <li>Les données ne pourront pas être restaurées</li>
                            <li>Les fichiers joints seront également supprimés</li>
                        </ul>
                    </div>
                    
                    <form action="{{ route('back.corbeille.vider') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="confirmation" class="form-label">
                                Pour confirmer, tapez : <code>JE_VEUX_VIDER_LA_CORBEILLE</code>
                            </label>
                            <input type="text" class="form-control" id="confirmation" name="confirmation" 
                                   placeholder="Tapez la phrase de confirmation" required>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('back.corbeille.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous ABSOLUMENT SÛR de vouloir vider la corbeille ?')">
                                <i class="fas fa-trash-alt me-2"></i>Vider définitivement la corbeille
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection