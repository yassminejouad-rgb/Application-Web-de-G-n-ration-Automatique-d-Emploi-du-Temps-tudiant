@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h2 class="fw-bold text-epg-blue">
            <i class="fa-solid fa-calendar-plus me-2" style="color: var(--epg-orange-main)"></i> Gestion d'Emploi
        </h2>
        <p class="text-muted">Administrer les cours, vérifier les conflits, et lier les professeurs aux groupes.</p>
    </div>
</div>

<div class="card card-custom p-4 bg-white shadow-sm border-0 mb-4 border-top border-4" style="border-top-color: var(--epg-blue-main) !important;">
    <h5 class="mb-4 fw-bold text-epg-blue"><i class="fa-solid fa-square-plus me-2"></i> Ajouter une nouvelle séance</h5>
    
    <form action="{{ route('schedule.store') }}" method="POST">
        @csrf
        <div class="row align-items-end">
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold text-muted small">Classe / Groupe</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-users-rectangle"></i></span>
                    <select class="form-select bg-light" name="group_id" required>
                        <option value="" disabled selected>Sélectionner...</option>
                        @foreach($groups ?? [] as $g) <option value="{{ $g->id }}">{{ $g->name }}</option> @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold text-muted small">Professeur</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-person-chalkboard"></i></span>
                    <select class="form-select bg-light" name="teacher_id" required>
                        <option value="" disabled selected>Sélectionner...</option>
                        @foreach($teachers ?? [] as $t) <option value="{{ $t->id }}">{{ $t->name }}</option> @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold text-muted small">Matière</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-solid fa-book"></i></span>
                    <select class="form-select bg-light" name="subject_id" required>
                        <option value="" disabled selected>Sélectionner...</option>
                        @foreach($subjects ?? [] as $s) <option value="{{ $s->id }}">{{ $s->name }}</option> @endforeach
                    </select>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <label class="form-label fw-bold text-muted small">Jour</label>
                <div class="input-group">
                <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-calendar"></i></span>
                    <select class="form-select bg-light" name="day_of_week" required>
                        <option value="" disabled selected>Sélectionner...</option>
                        <option value="Monday">Lundi</option>
                        <option value="Tuesday">Mardi</option>
                        <option value="Wednesday">Mercredi</option>
                        <option value="Thursday">Jeudi</option>
                        <option value="Friday">Vendredi</option>
                        <option value="Saturday">Samedi</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-muted small">Heure de début</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-clock"></i></span>
                    <input type="time" name="start_time" class="form-control bg-light" required>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold text-muted small">Heure de fin</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="fa-regular fa-clock"></i></span>
                    <input type="time" name="end_time" class="form-control bg-light" required>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <button type="submit" class="btn btn-epg-blue w-100 py-2 fw-bold"><i class="fa-solid fa-plus me-1"></i> Ajouter la séance</button>
            </div>
        </div>
    </form>
</div>

<div class="card card-custom p-4 bg-white shadow-sm border-0 border-top border-4 mb-4" style="border-top-color: var(--epg-orange-main) !important;">
    <div class="d-flex justify-content-between align-items-center mb-0">
        <div>
            <h5 class="fw-bold text-epg-blue mb-1"><i class="fa-solid fa-robot me-2"></i> Génération Automatique</h5>
            <p class="text-muted small mb-0">Remplir les cases vides automatiquement pour toutes les filières en évitant les conflits.</p>
        </div>
        <form action="{{ route('schedule.generate') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-epg-orange fw-bold py-2 px-4 shadow-sm text-white rounded-pill">
                <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Lancer la génération 
            </button>
        </form>
    </div>
</div>

<div class="card card-custom p-4 bg-white shadow-sm border-0 border-top border-4" style="border-top-color: #dc3545 !important;">
    <div class="d-flex justify-content-between align-items-center mb-0">
        <div>
            <h5 class="fw-bold text-danger mb-1"><i class="fa-solid fa-trash-can me-2"></i> Réinitialiser l'emploi du temps</h5>
            <p class="text-muted small mb-0">Supprimer toutes les séances existantes de l'emploi du temps pour recommencer à zéro.</p>
        </div>
        <form action="{{ route('schedule.clear') }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir vider entièrement l\'emploi du temps actuel ? Cette action est définitive et irréversible.');">
            @csrf
            <button type="submit" class="btn btn-danger fw-bold py-2 px-4 shadow-sm rounded-pill">
                <i class="fa-solid fa-trash me-2"></i> Vider l'emploi du temps
            </button>
        </form>
    </div>
</div>
@endsection
