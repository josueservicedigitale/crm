@extends('back.layouts.principal')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-0 text-white">
                    <i class="fas fa-user-plus me-2 text-success"></i>➕ Créer un utilisateur
                </h4>
            </div>
            <a href="{{ route('back.users.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left me-2"></i>Retour
            </a>
        </div>

        <form action="{{ route('back.users.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label text-white">Nom complet <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label text-white">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label text-white">Mot de passe <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label text-white">Confirmation <span class="text-danger">*</span></label>
                    <input type="password" class="form-control"
                           id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label text-white">Téléphone</label>
                    <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                           id="telephone" name="telephone" value="{{ old('telephone') }}">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="role" class="form-label text-white">Rôle <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="est_actif" id="est_actif" value="1" checked>
                        <label class="form-check-label text-white" for="est_actif">
                            Actif (peut se connecter)
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection