@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold text-epg-blue mb-0"><i class="fa-solid fa-users me-2"></i>Gestion des Utilisateurs</h2>
            <p class="text-muted">Gérez les administrateurs et le personnel de la plateforme.</p>
        </div>
        <div class="col-auto">
            <a href="{{ route('users.create') }}" class="btn btn-epg-orange rounded-pill px-4">
                <i class="fa-solid fa-user-plus me-1"></i> Ajouter un Utilisateur
            </a>
        </div>
    </div>

    <div class="card card-custom border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-epg-blue-pale text-epg-blue">
                        <tr>
                            <th class="py-3 px-4 border-0 rounded-top-start">Nom & Prénom</th>
                            <th class="py-3 border-0">Email</th>
                            <th class="py-3 border-0">Téléphone</th>
                            <th class="py-3 border-0">Date d'ajout</th>
                            <th class="py-3 px-4 border-0 rounded-top-end text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-epg-blue-pale text-epg-blue rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                        {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->first_name }} {{ $user->last_name }}</div>
                                        @if(auth()->id() === $user->id)
                                            <span class="badge bg-success small">Moi</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 text-muted">{{ $user->email }}</td>
                            <td class="py-3 text-muted">{{ $user->phone ?? '-' }}</td>
                            <td class="py-3 text-muted">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-end">
                                @if(auth()->id() !== $user->id)
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Aucun utilisateur trouvé.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
