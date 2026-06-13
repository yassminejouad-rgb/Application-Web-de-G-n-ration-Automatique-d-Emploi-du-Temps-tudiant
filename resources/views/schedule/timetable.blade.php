@extends('layouts.app')

@section('content')
<div class="row mb-3 d-print-none">
    <div class="col-md-8">
        <h2 class="fw-bold text-epg-blue">
            <i class="fa-solid fa-table me-2" style="color: var(--epg-orange-main)"></i> Emploi du Temps
        </h2>
        <p class="text-muted">Consultez l'emploi du temps global généré par classe.</p>
    </div>
    <div class="col-md-4 text-end d-flex align-items-center justify-content-end">
        <button onclick="window.print()" class="btn btn-epg-orange fw-bold shadow-sm rounded-pill px-4">
            <i class="fa-solid fa-print me-2"></i> Imprimer PDF (A4)
        </button>
    </div>
</div>

@php
    $days = ['Monday' => 'LUNDI', 'Tuesday' => 'MARDI', 'Wednesday' => 'MERCREDI', 'Thursday' => 'JEUDI', 'Friday' => 'VENDREDI'];
    $times = [
        ['09:30', '11:30', '09:30 à 11:30'], 
        ['11:45', '13:45', '11:45 à 13:45'], 
        ['14:30', '16:30', '14:30 à 16:30'], 
        ['16:45', '18:45', '16:45 à 18:45']
    ];
@endphp

@forelse($groups as $group)
    @php
        $groupSchedules = collect($groupedSchedules->get($group->id, []));
    @endphp
    <div class="card card-custom bg-white shadow-sm border-0 section-to-print mb-5 page-break-after">
        <div class="print-header text-center pt-4 pb-2 px-4 position-relative">
            <div class="d-flex justify-content-between align-items-center w-100 mb-3 px-3">
                <div class="text-start" style="width: 25%;">
                    <img src="{{ asset('logo.png') }}" alt="Logo EPG" style="height: 70px; object-fit: contain;">
                </div>
                <div class="text-center" style="width: 50%;">
                    <h2 class="fw-bold mb-0 text-epg-blue" style="letter-spacing: 1px;">ECOLE POLYTECHNIQUE DES GENIES</h2>
                    <h5 class="mt-2 text-epg-blue">Année scolaire {{ date('Y') }} - {{ date('Y') + 1 }}</h5>
                    <div class="d-inline-block bg-epg-blue text-white rounded-pill px-4 py-2 mt-2 fw-bold" style="background-color: var(--epg-blue-main);">
                        <span style="color: var(--epg-orange-main); margin-right: 15px;"><i class="fa-solid fa-chevron-left"></i></span> 
                        EMPLOI DU TEMPS 
                        <span style="color: var(--epg-orange-main); margin-left: 15px;"><i class="fa-solid fa-chevron-right"></i></span>
                    </div>
                </div>
                <div class="text-end" style="width: 25%;">
                    <i class="fa-solid fa-clipboard-list" style="color: var(--epg-orange-main); font-size: 3.5rem;"></i>
                </div>
            </div>

            <div class="text-center mt-3 mb-4">
                <h5 class="text-epg-blue">Du {{ date('Y-m-01') }} au {{ date('Y-m-t') }}</h5>
            </div>

            <div class="text-start px-3 mb-4" style="line-height: 1.8;">
                <h5 class="m-0"><strong class="text-epg-blue">Niveau :</strong> <span class="text-epg-orange fw-bold">{{ $group->name }}</span></h5>
                <h5 class="m-0 mt-2"><strong class="text-epg-blue">Filière :</strong> <span class="text-epg-orange fw-bold">{{ $group->name }} (Développement / Techniques)</span></h5>
            </div>
            
            <div class="text-center my-3 mx-auto" style="width: fit-content;">
                <h4 class="fw-bold border border-2 py-2 px-5 rounded bg-epg-blue-pale text-epg-blue" style="border-color: var(--epg-blue-main) !important;">
                    HORAIRES ET MATIERES
                </h4>
            </div>
        </div>
        
        <div class="card-body p-0 border-top border-2" style="border-top-color: var(--epg-blue-main) !important;">
            <table class="table table-bordered text-center align-middle mb-0 custom-timetable">
                <thead>
                    <tr>
                        <th class="py-3 bg-white" style="width: 15%;">
                            <i class="fa-regular fa-calendar-days fa-2x text-epg-orange"></i>
                        </th>
                        @foreach($times as $time)
                            <th class="py-3 fw-bold bg-light-orange text-dark" style="width: 21.25%;">
                                {{ $time[2] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $enDay => $frDay)
                    <tr>
                        <td class="fw-bold bg-white text-dark py-4" style="font-size: 1.1rem;">
                            {{ $frDay }}
                        </td>
                        @foreach($times as $time)
                            @php
                                $cellSchedule = $groupSchedules->first(function($s) use ($enDay, $time) {
                                    $sStart = \Carbon\Carbon::parse($s->start_time)->format('H:i');
                                    // Match exact hour, or fall in range roughly
                                    return $s->day_of_week === $enDay && $sStart === $time[0];
                                });
                            @endphp
                            <td class="timetable-cell p-3">
                                @if($cellSchedule)
                                    <div class="fw-bold mb-1" style="font-size: 0.95rem; color: #111;">
                                        {{ optional($cellSchedule->subject)->name }}
                                    </div>
                                    @if(optional($cellSchedule->teacher)->name)
                                        <div class="small text-secondary mt-2">
                                            <i class="fa-solid fa-user-tie me-1 text-epg-blue"></i> {{ $cellSchedule->teacher->name }}
                                        </div>
                                    @endif
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@empty
    <div class="alert alert-info shadow-sm d-print-none text-center py-5">
        <i class="fa-solid fa-folder-open mb-3 fa-3x text-muted"></i>
        <h5>Aucune classe disponible.</h5>
        <p>Veuillez d'abord configurer vos classes et générer des emplois du temps.</p>
    </div>
@endforelse

<style>
    /* Printing styles */
    .bg-light-orange {
        background-color: #fdf3eb !important;
    }
    .custom-timetable th, .custom-timetable td {
        border: 2px solid var(--epg-blue-main) !important;
        vertical-align: middle;
    }
    .timetable-cell {
        height: 100px;
    }
    
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        body { background-color: white !important; color: black !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .navbar-custom, .d-print-none, .main-content > .alert { display: none !important; }
        .section-to-print { 
            box-shadow: none !important; 
            border: none !important; 
            margin-bottom: 0 !important;
            padding: 0 !important;
        }
        .page-break-after {
            page-break-after: always;
        }
        .custom-timetable th, .custom-timetable td {
            border: 2px solid #0c2b5e !important;
        }
        .bg-light-orange {
            background-color: #fdf3eb !important;
        }
        .bg-epg-blue {
            background-color: #0c2b5e !important;
            color: white !important;
        }
        .text-epg-blue { color: #0c2b5e !important; }
        .text-epg-orange { color: #F28C28 !important; }
    }
</style>
@endsection
