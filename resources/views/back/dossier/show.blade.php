@extends('back.layouts.principal')

@section('title', $dossier->nom)

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('back.dossiers.index') }}" class="text-decoration-none">Dossiers</a>
                        </li>
                        @foreach($dossier->getAncestors() as $ancetre)
                            <li class="breadcrumb-item">
                                <a href="{{ route('back.dossiers.show', $ancetre->slug) }}" class="text-decoration-none">
                                    {{ $ancetre->nom }}
                                </a>
                            </li>
                        @endforeach
                        <li class="breadcrumb-item active" aria-current="page">{{ $dossier->nom }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white rounded shadow-sm p-4">
                    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar avatar-xl rounded-circle d-flex align-items-center justify-content-center"
                                style="
                                        --dossier-color: {{ $dossier->couleur }};
                                        background-color: var(--dossier-color)20;
                                        width: 80px;
                                        height: 80px;
                                    ">
                                <i class="fas {{ $dossier->icone_classe }} fa-3x" style="color: var(--dossier-color);"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-2">{{ $dossier->nom }}</h4>

                                <div class="d-flex gap-2 mb-2 flex-wrap">
                                    @if($dossier->est_visible)
                                        <span class="badge bg-success">
                                            <i class="fas fa-globe me-1"></i>Public
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-lock me-1"></i>Privé
                                        </span>
                                    @endif

                                    <span id="statut-badge" class="badge bg-{{ $dossier->statut_badge_class }}">
                                        <i class="fas fa-flag me-1"></i>
                                        <span id="statut-badge-text">{{ ucfirst($dossier->statut) }}</span>
                                    </span>

                                    @if($dossier->societe)
                                        <span class="badge bg-primary bg-opacity-10 text-dark">
                                            <i class="fas fa-building me-1"></i>{{ $dossier->societe->nom }}
                                        </span>
                                    @endif

                                    @if($dossier->activite)
                                        <span class="badge bg-info bg-opacity-10 text-dark">
                                            <i class="fas fa-tasks me-1"></i>{{ $dossier->activite->nom }}
                                        </span>
                                    @endif
                                </div>

                                @if($dossier->description)
                                    <p class="text-muted mb-0">{{ $dossier->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 align-items-start">
                            @if($dossier->user_id == auth()->id() || auth()->user()?->role === 'admin')
                                <a href="{{ route('back.dossiers.edit', $dossier->id) }}" class="btn btn-outline-warning"
                                    data-bs-toggle="tooltip" title="Modifier">
                                    <i class="fas fa-edit me-1"></i>Modifier
                                </a>
                            @endif

                            @if($dossier->user_id == auth()->id())
                                <button type="button"
                                    class="btn btn-outline-{{ $dossier->est_visible ? 'warning' : 'success' }} toggle-visibilite"
                                    data-id="{{ $dossier->id }}" data-visible="{{ $dossier->est_visible }}"
                                    data-bs-toggle="tooltip"
                                    title="{{ $dossier->est_visible ? 'Rendre privé' : 'Rendre public' }}">
                                    <i class="fas fa-{{ $dossier->est_visible ? 'lock' : 'globe' }} me-1"></i>
                                    {{ $dossier->est_visible ? 'Rendre privé' : 'Rendre public' }}
                                </button>
                            @endif

                            @if(auth()->user()?->role === 'admin')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-flag me-1"></i>
                                        <span id="statut-btn-label">{{ ucfirst($dossier->statut) }}</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item change-statut" href="#" data-id="{{ $dossier->id }}"
                                                data-statut="brouillon">
                                                Brouillon
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item change-statut" href="#" data-id="{{ $dossier->id }}"
                                                data-statut="valide">
                                                Validé
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item change-statut" href="#" data-id="{{ $dossier->id }}"
                                                data-statut="ferme">
                                                Fermé
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif

                            <span id="delete-dossier-wrapper">
                                @if(auth()->user()?->role === 'admin' && $dossier->statut === 'ferme')
                                    <form action="{{ route('back.dossiers.destroy', $dossier->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer le dossier « {{ addslashes($dossier->nom) }} » et tout son contenu ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash me-1"></i>Supprimer
                                        </button>
                                    </form>
                                @endif
                            </span>

                            <a href="{{ route('back.dossiers.download', $dossier->id) }}" class="btn btn-outline-success"
                                data-bs-toggle="tooltip" title="Télécharger en ZIP">
                                <i class="fas fa-download me-1"></i>ZIP
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4 g-3">
                        <div class="col-md-3 col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <h5 class="fw-bold text-primary mb-0">{{ $dossier->enfants_count }}</h5>
                                <small class="text-muted">Sous-dossiers</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <h5 class="fw-bold text-success mb-0">{{ $dossier->fichiers_count }}</h5>
                                <small class="text-muted">Fichiers</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <h5 class="fw-bold text-info mb-0">{{ formatBytes($dossier->taille_totale) }}</h5>
                                <small class="text-muted">Taille totale</small>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="bg-light rounded p-3 text-center">
                                <h5 class="fw-bold text-warning mb-0">{{ $dossier->created_at->format('d/m/Y') }}</h5>
                                <small class="text-muted">Créé le</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($dossier->peutEcrire(auth()->id()) && $dossier->statut !== 'ferme')
            <div class="row mb-4">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-upload me-2 text-primary"></i>
                            Upload de fichiers
                        </h5>
                        <div class="upload-area" id="uploadArea">
                            <form id="uploadForm" action="{{ route('back.dossiers.upload', $dossier->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="file" name="fichiers[]" id="fichiers" class="form-control" multiple
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.gif">
                                </div>
                                <div class="progress mb-3 d-none" id="uploadProgress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                        role="progressbar" style="width: 0%">0%</div>
                                </div>
                                <button type="submit" class="btn btn-primary" id="uploadBtn">
                                    <i class="fas fa-cloud-upload-alt me-2"></i>Uploader
                                </button>
                            </form>
                            <div class="mt-3" id="uploadResult"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($enfants->count() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-folder me-2 text-primary"></i>
                            Sous-dossiers ({{ $enfants->count() }})
                        </h5>
                        <div class="row g-3">
                            @foreach($enfants as $enfant)
                                <div class="col-md-4 col-lg-3">
                                    <a href="{{ route('back.dossiers.show', $enfant->slug) }}" class="text-decoration-none">
                                        <div class="card border-0 bg-light hover-shadow">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-folder fa-3x mb-2"
                                                    style="--folder-color: {{ $enfant->couleur }}; color: var(--folder-color);">
                                                </i>
                                                <h6 class="fw-bold text-dark mb-1">{{ $enfant->nom }}</h6>
                                                <small class="text-muted">
                                                    {{ $enfant->enfants_count }} dossiers • {{ $enfant->fichiers_count }} fichiers
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($fichiers->count() > 0)
            <div class="row">
                <div class="col-12">
                    <div class="bg-white rounded shadow-sm p-4">
                        <h5 class="fw-bold mb-3">
                            <i class="fas fa-file me-2 text-primary"></i>
                            Fichiers ({{ $fichiers->total() }})
                        </h5>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fichier</th>
                                        <th>Taille</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fichiers as $fichier)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="fas {{ $fichier->icone }} fa-lg me-2 text-primary"></i>
                                                    <div>
                                                        <span class="fw-bold">{{ $fichier->nom_original }}</span>
                                                        @if($fichier->document)
                                                            <br>
                                                            <small class="text-muted">Document #{{ $fichier->document->id }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ formatBytes($fichier->taille) }}</td>
                                            <td>
                                                <span class="badge bg-secondary">{{ $fichier->extension }}</span>
                                            </td>
                                            <td>{{ $fichier->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('back.fichiers.download', $fichier->id) }}"
                                                        class="btn btn-outline-success" data-bs-toggle="tooltip"
                                                        title="Télécharger">
                                                        <i class="fas fa-download"></i>
                                                    </a>

                                                    @if($fichier->est_image)
                                                        <button type="button" class="btn btn-outline-info preview-image"
                                                            data-url="{{ $fichier->url }}" data-bs-toggle="modal"
                                                            data-bs-target="#previewModal" title="Aperçu">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                    @endif

                                                    @if($dossier->peutEcrire(auth()->id()) && $dossier->statut !== 'ferme')
                                                        <form action="{{ route('back.fichiers.destroy', $fichier->id) }}" method="POST"
                                                            class="d-inline"
                                                            onsubmit="return confirm('Retirer ce fichier : {{ addslashes($fichier->nom_original) }} ?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger" title="Retirer">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $fichiers->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($enfants->count() == 0 && $fichiers->count() == 0)
            <div class="row">
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded shadow-sm">
                        <div class="empty-state">
                            <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">Dossier vide</h5>
                            <p class="text-muted mb-4">Ce dossier ne contient encore aucun élément</p>
                            @if($dossier->peutEcrire(auth()->id()) && $dossier->statut !== 'ferme')
                                <button type="button" class="btn btn-primary" onclick="document.getElementById('fichiers').click()">
                                    <i class="fas fa-upload me-2"></i>Uploader des fichiers
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aperçu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="previewImage" class="img-fluid" style="max-height: 500px;">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $('.toggle-visibilite').click(function () {
                const dossierId = $(this).data('id');

                $.ajax({
                    url: `/back/dossiers/${dossierId}/toggle-visibilite`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert('Erreur: ' + (xhr.responseJSON?.message || 'Action impossible'));
                    }
                });
            });

            $('#uploadForm').submit(function (e) {
                e.preventDefault();

                let input = document.getElementById('fichiers');
                if (!input || !input.files.length) {
                    alert('Aucun fichier sélectionné !');
                    return;
                }

                let formData = new FormData();
                for (let i = 0; i < input.files.length; i++) {
                    formData.append('fichiers[]', input.files[i]);
                }
                formData.append('_token', '{{ csrf_token() }}');

                $('#uploadProgress').removeClass('d-none');
                $('#uploadProgress .progress-bar').css('width', '0%').text('0%');
                $('#uploadBtn').prop('disabled', true);

                $.ajax({
                    url: '{{ route("back.dossiers.upload", $dossier->id) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    xhr: function () {
                        let xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function (e) {
                            if (e.lengthComputable) {
                                let percent = Math.round((e.loaded / e.total) * 100);
                                $('#uploadProgress .progress-bar').css('width', percent + '%').text(percent + '%');
                            }
                        });
                        return xhr;
                    },
                    success: function (response) {
                        $('#uploadResult').html(`
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>${response.message}
                        </div>
                    `);
                        setTimeout(() => location.reload(), 1200);
                    },
                    error: function (xhr) {
                        $('#uploadResult').html(`
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle me-2"></i>Erreur: ${xhr.responseJSON?.message || 'Upload échoué'}
                        </div>
                    `);
                        $('#uploadProgress').addClass('d-none');
                        $('#uploadBtn').prop('disabled', false);
                    }
                });
            });

            $('.preview-image').click(function () {
                let url = $(this).data('url');
                $('#previewImage').attr('src', url);
            });

            $(document).on('click', '.change-statut', function (e) {
                e.preventDefault();

                const dossierId = $(this).data('id');
                const statut = $(this).data('statut');

                $.ajax({
                    url: `/back/dossiers/${dossierId}/changer-statut`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        statut: statut
                    },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'Erreur lors du changement de statut');
                    }
                });
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .upload-area {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .upload-area:hover {
            border-color: #0d6efd;
            background-color: #f8f9fa;
        }
    </style>
@endpush