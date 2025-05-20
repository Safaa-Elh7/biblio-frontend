<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - MyBookSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            background: linear-gradient(135deg, #8B2635 0%, #A53545 100%);
            min-height: calc(100vh - 56px);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0;
            margin-bottom: 2px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .content {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .badge-status {
            font-size: 0.75rem;
            padding: 0.25em 0.6em;
        }
        .table th {
            background-color: #f2f2f2;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('bibliothecaire.dashboard.index') }}">
                <i class="fas fa-book me-2"></i>
                MyBookSpace
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            {{ Auth::user()->name ?? 'Administrateur' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog me-2"></i>Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar p-0">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.dashboard.*') ? 'active' : '' }}" 
                               href="{{ route('bibliothecaire.dashboard.index') }}">
                                <i class="fas fa-tachometer-alt"></i> Tableau de bord
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.article.*') ? 'active' : '' }}"
                               href="{{ route('bibliothecaire.article.index') }}">
                                <i class="fas fa-book"></i> Articles/Livres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.user.*') ? 'active' : '' }}"
                               href="{{ route('bibliothecaire.user.index') }}">
                                <i class="fas fa-users"></i> Utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.livreur.*') ? 'active' : '' }}"
                               href="{{ route('bibliothecaire.livreur.index') }}">
                                <i class="fas fa-truck"></i> Livreurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.order.*') ? 'active' : '' }}"
                               href="{{ route('bibliothecaire.order.show') }}">
                                <i class="fas fa-shopping-cart"></i> Commandes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('bibliothecaire.payment.*') ? 'active' : '' }}"
                               href="{{ route('bibliothecaire.payment.show') }}">
                                <i class="fas fa-credit-card"></i> Paiements
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 content">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
