@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center mt-4">
    <div class="col-md-5">
        <div class="card card-custom p-4 bg-white border-0">
            <div class="text-center mb-4">
                <img src="{{ asset('logo.png') }}" alt="Logo EPG" style="max-height: 80px; max-width: 100%; object-fit: contain; margin-bottom: 15px;">
                <h3 class="text-epg-blue fw-bold">Créer un compte</h3>
                <p class="text-muted">Enregistrez-vous pour planifier les emplois du temps.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label fw-bold">Prénom</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required autofocus>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label fw-bold">Nom</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Adresse Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-bold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-bold">Confirmer le mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-check"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-epg-orange w-100 py-2 fw-bold rounded-pill">S'inscrire</button>
                
                <div class="text-center mt-3">
                    <span class="text-muted">Déjà un compte ?</span> <a href="{{ route('login') }}" class="text-epg-blue text-decoration-none fw-bold">Se connecter</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
