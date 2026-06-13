@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-epg-blue">Tableau de Bord</h2>
        <p class="text-muted">Aperçu général de l'établissement</p>
    </div>
</div>

<div class="row text-center mb-4">
    <div class="col-md-4 mb-3">
        <div class="card card-custom p-4 bg-epg-blue-pale text-epg-blue border-start border-4" style="border-left-color: var(--epg-orange-main) !important;">
            <i class="fa-solid fa-users fa-2x mb-3 text-epg-orange"></i>
            <h5 class="fw-bold">Total des Étudiants</h5>
            <h2 class="display-5 fw-bold">{{ $stats['students_count'] ?? 0 }}</h2>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card card-custom p-4 bg-white text-epg-blue shadow-sm border-start border-4" style="border-left-color: var(--epg-blue-main) !important;">
            <i class="fa-solid fa-chalkboard-user fa-2x mb-3" style="color: var(--epg-blue-main);"></i>
            <h5 class="fw-bold">Classes / Groupes</h5>
            <h2 class="display-5 fw-bold">{{ $stats['classes_count'] ?? 0 }}</h2>
        </div>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card card-custom p-4 text-white border-0 shadow-sm" style="background: linear-gradient(135deg, var(--epg-blue-main), var(--epg-blue-light));">
            <i class="fa-solid fa-person-chalkboard fa-2x mb-3 text-white"></i>
            <h5 class="fw-bold">Corps Enseignant</h5>
            <h2 class="display-5 fw-bold">{{ $stats['teachers_count'] ?? 0 }}</h2>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card card-custom border-0 shadow-sm h-100">
            <div class="card-header card-header-epg py-3">
                <i class="fa-solid fa-plus-circle me-2"></i> Allocation de Séances
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-5 text-center">
                <i class="fa-solid fa-calendar-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">Créez de nouvelles sessions de cours manuellement ou générez un emploi du temps automatiquement.</p>
                <a href="{{ route('schedule.create') }}" class="btn btn-epg-blue mt-2 rounded-pill px-4 py-2">
                    Gérer l'emploi
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card card-custom border-0 shadow-sm h-100">
            <div class="card-header card-header-epg py-3">
                <i class="fa-solid fa-list me-2"></i> Vue d'ensemble
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center p-5 text-center">
                <i class="fa-solid fa-table-list fa-3x text-muted mb-3"></i>
                <p class="text-muted">Consultez l'emploi du temps détaillé avec toutes les répartitions créées pour vos professeurs.</p>
                <a href="{{ route('schedule.timetable') }}" class="btn btn-epg-orange mt-2 rounded-pill px-4 py-2 text-white">
                    Voir la table
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
