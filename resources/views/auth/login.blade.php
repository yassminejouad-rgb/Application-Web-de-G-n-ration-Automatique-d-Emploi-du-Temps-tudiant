@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center mt-5">
    <div class="col-md-5">
        <div class="card card-custom p-4 bg-white border-0">
            <div class="text-center mb-4">
                <img src="{{ asset('logo.png') }}" alt="Logo EPG" style="max-height: 80px; max-width: 100%; object-fit: contain; margin-bottom: 15px;">
                <h3 class="text-epg-blue fw-bold">Connexion</h3>
                <p class="text-muted">Générez et gérez les emplois du temps facilement.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
             @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Adresse Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-envelope"></i></span>
                        <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email')
                        <div class="text-danger small mt-1 fw-bold"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-bold">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa-solid fa-lock"></i></span>
                        <input type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" id="password" name="password" required>
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1 fw-bold"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-epg-blue w-100 py-2 fw-bold rounded-pill">Se connecter</button>
                
                <div class="text-center mt-3">
                    <span class="text-muted">Pas encore de compte ?</span> <a href="{{ route('register') }}" class="text-epg-orange text-decoration-none fw-bold">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
