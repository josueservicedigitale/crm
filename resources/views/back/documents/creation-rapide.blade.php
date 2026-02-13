@extends('back.layouts.principal')

@section('title', 'Création rapide de document')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bg-light rounded p-5 shadow-lg">
                
                <!-- En-tête -->
                <div class="text-center mb-5">
                    <i class="fa fa-bolt fa-4x text-warning mb-3"></i>
                    <h2 class="fw-bold">Création rapide</h2>
                    <p class="text-muted">Sélectionnez le type de document à créer</p>
                </div>

                <!-- Formulaire -->
                <form action="#" method="GET" id="quickCreateForm">
                    
                    <!-- Ligne 1: Société + Activité -->
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fa fa-building me-2 text-primary"></i>Société
                            </label>
                            <select class="form-select form-select-lg" name="society" id="societySelect" required>
                                <option value="" selected disabled>Choisir une société</option>
                                @foreach($societes as $code => $nom)
                                    <option value="{{ $code }}" 
                                        data-icon="fa-building"
                                        data-color="primary">
                                        {{ $nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">
                                <i class="fa fa-tasks me-2 text-success"></i>Activité
                            </label>
                            <select class="form-select form-select-lg" name="activity" id="activitySelect" required>
                                <option value="" selected disabled>Choisir une activité</option>
                                @foreach($activites as $code => $nom)
                                    <option value="{{ $code }}">{{ $nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Ligne 2: Type de document -->
                    <div class="row mb-5">
                        <div class="col-12">
                            <label class="form-label fw-bold">
                                <i class="fa fa-file-alt me-2 text-info"></i>Type de document
                            </label>
                            <div class="row g-3">
                                @foreach($types as $code => $nom)
                                <div class="col-md-4 col-sm-6">
                                    <div class="form-check card-type p-3 rounded border" 
                                         data-type="{{ $code }}"
                                         style="cursor: pointer; transition: all 0.2s;">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="type" 
                                               id="type_{{ $code }}" 
                                               value="{{ $code }}"
                                               required>
                                        <label class="form-check-label w-100" for="type_{{ $code }}">
                                            <div class="d-flex align-items-center">
                                                <i class="fa {{ $this->getTypeIcon($code) }} fa-lg me-2"></i>
                                                <span>{{ $nom }}</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Bouton de soumission -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-warning btn-lg px-5 py-3" id="submitBtn" disabled>
                            <i class="fa fa-arrow-right me-2"></i>
                            Continuer vers la création
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!-- Styles personnalisés -->
<style>
.card-type {
    transition: all 0.2s ease;
    border: 2px solid transparent;
}
.card-type:hover {
    background-color: #f8f9fa;
    border-color: #ffc107;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.card-type.selected {
    background-color: #fff3cd;
    border-color: #ffc107;
}
.form-check-input:checked + label {
    font-weight: 600;
}
</style>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $society = $('#societySelect');
    const $activity = $('#activitySelect');
    const $type = $('input[name="type"]');
    const $submitBtn = $('#submitBtn');
    
    // Activer le bouton quand tout est sélectionné
    function checkFormComplete() {
        if ($society.val() && $activity.val() && $('input[name="type"]:checked').val()) {
            $submitBtn.prop('disabled', false);
        } else {
            $submitBtn.prop('disabled', true);
        }
    }
    
    $society.change(checkFormComplete);
    $activity.change(checkFormComplete);
    $type.change(checkFormComplete);
    
    // Style des cartes type
    $('.card-type').click(function() {
        const radio = $(this).find('input[type="radio"]');
        radio.prop('checked', true);
        $('.card-type').removeClass('selected');
        $(this).addClass('selected');
        checkFormComplete();
    });
    
    // Soumission du formulaire
    $('#quickCreateForm').submit(function(e) {
        e.preventDefault();
        
        const society = $society.val();
        const activity = $activity.val();
        const type = $('input[name="type"]:checked').val();
        
        if (society && activity && type) {
            const url = "{{ route('back.document.choose', ['', '', '']) }}/" + 
                        activity + '/' + society + '/' + type;
            window.location.href = url;
        }
    });
});
</script>
@endpush