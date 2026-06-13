<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EPG - Gestion des Emplois du Temps</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            /* Palette basée sur EPG (Bleu marine & Orange) */
            --epg-blue-dark: #071933;
            --epg-blue-main: #0c2b5e;
            --epg-blue-light: #164085;
            --epg-blue-pale: #e8eef7;
            --epg-orange-main: #F28C28;
            --epg-orange-hover: #e07b1d;
        }

        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f6fa;
        }

        /* --- Layout --- */
        .admin-layout {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Sidebar */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: -280px;
            height: 100vh;
            width: 280px;
            background: linear-gradient(180deg, var(--epg-blue-dark) 0%, var(--epg-blue-main) 100%);
            color: white;
            z-index: 1050;
            transition: all 0.3s ease;
            box-shadow: 4px 0 10px rgba(0,0,0,0.2);
            overflow-y: auto;
        }

        .admin-sidebar.show {
            left: 0;
        }

        .admin-header {
            height: 70px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
        }

        .admin-main {
            padding: 2rem 1.5rem;
            flex-grow: 1;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            backdrop-filter: blur(2px);
        }
        
        .sidebar-overlay.show {
            display: block;
        }

        /* Styling Sidebar Links */
        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-nav {
            padding: 1.5rem 0;
            list-style: none;
            margin: 0;
        }

        .sidebar-nav .nav-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 0.8rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s;
            border-left: 4px solid transparent;
            font-weight: 500;
        }

        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active {
            color: #ffffff;
            background-color: rgba(255,255,255,0.1);
            border-left-color: var(--epg-orange-main);
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Utilities */
        .btn-epg-orange {
            background-color: var(--epg-orange-main);
            color: white;
            border: none;
            font-weight: 600;
        }
        .btn-epg-orange:hover {
            background-color: var(--epg-orange-hover);
            color: white;
        }

        .btn-epg-blue {
            background-color: var(--epg-blue-light);
            color: white;
            border: none;
        }
        .btn-epg-blue:hover {
            background-color: var(--epg-blue-main);
            color: white;
        }

        .card-custom { 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            border: none; 
            margin-bottom: 20px;
        }

        .card-header-epg {
            background-color: var(--epg-blue-pale);
            border-bottom: 2px solid var(--epg-blue-light);
            color: var(--epg-blue-main);
            font-weight: bold;
            border-radius: 12px 12px 0 0 !important;
        }

        .text-epg-orange { color: var(--epg-orange-main); }
        .text-epg-blue { color: var(--epg-blue-main); }
        .bg-epg-blue-pale { background-color: var(--epg-blue-pale); }
    </style>
</head>
<body>

@auth
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h5 class="fw-bold mb-0 text-white">Menu Principal</h5>
            <small class="text-white-50">Gestion des emplois</small>
        </div>

        <ul class="sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('schedule.create') }}" class="nav-link {{ request()->routeIs('schedule.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-calendar-plus"></i> Gérer l'emploi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('schedule.timetable') }}" class="nav-link {{ request()->routeIs('schedule.timetable') ? 'active' : '' }}">
                    <i class="fa-solid fa-table"></i> Consulter l'emploi
                </a>
            </li>
            
            <li class="nav-item mt-4">
                <div class="px-3 text-uppercase text-white-50 small fw-bold mb-2">Personnel</div>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear"></i> Gestion Utilisateurs
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-edit"></i> Mon Profil
                </a>
            </li>
        </ul>
    </aside>

    <!-- Header -->
    <header class="admin-header">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light shadow-sm" id="sidebarToggle">
                <i class="fa-solid fa-bars fs-5"></i>
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-light shadow-sm text-epg-blue" title="Accueil">
                <i class="fa-solid fa-house"></i>
            </a>
            <h5 class="mb-0 text-epg-blue fw-bold d-none d-md-block ms-2">Système de Planification</h5>
        </div>
        
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-sm-block text-end me-2">
                <div class="fw-bold text-dark">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
                <div class="small text-muted">Administrateur</div>
            </div>
            
            <div class="d-flex align-items-center mx-2">
                <img src="{{ asset('logo.png') }}" alt="Logo EPG" style="height: 55px; max-width: 160px; object-fit: contain; transform: translateY(-3px);">
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="m-0 ms-1">
                @csrf
                <button type="submit" class="btn btn-sm btn-epg-orange rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;" title="Déconnexion">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="container-fluid p-0">
            @if(session('success')) 
                <div class="alert alert-success fw-bold shadow-sm border-0 bg-success text-white alert-dismissible fade show">
                    <i class="fa-solid fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
            @endif
            @if(session('error')) 
                <div class="alert alert-danger fw-bold shadow-sm border-0 alert-dismissible fade show">
                    <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
            @endif

            @yield('content')
        </div>
    </main>
</div>
@else
    <div class="container main-content mt-5">
        @yield('content')
    </div>
@endauth

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.css"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle && sidebar && overlay) {
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.add('show');
                overlay.classList.add('show');
            });

            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });
        }
    });
</script>
</body>
</html>
