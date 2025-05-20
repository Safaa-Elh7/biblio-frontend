<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Gestion des Paiements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles pour correspondre au design */
        .sidebar-gradient {
            background: linear-gradient(135deg, #8B2635 0%, #A53545 100%);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }
        .status-pending { background-color: #FEF3C7; color: #D97706; }
        .status-processing { background-color: #DBEAFE; color: #2563EB; }
        .status-completed { background-color: #D1FAE5; color: #059669; }
        .status-cancelled { background-color: #FEE2E2; color: #DC2626; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient text-white">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-full p-2">
                        <i class="fas fa-book text-red-600"></i>
                    </div>
                    <span class="text-xl font-bold">MyBookSpace</span>
                </div>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('bibliothecaire.dashboard.index') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="{{ route('bibliothecaire.article.index') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-book mr-3"></i>
                    <span>Livres</span>
                </a>
                <a href="{{ route('bibliothecaire.order.show') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Commandes</span>
                </a>
                <a href="{{ route('bibliothecaire.payment.show') }}" class="flex items-center px-6 py-3 bg-red-700 text-white transition-colors">
                    <i class="fas fa-credit-card mr-3"></i>
                    <span>Paiements</span>
                </a>
                <a href="{{ route('bibliothecaire.user.index') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-users mr-3"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="{{ route('bibliothecaire.livreur.index') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-truck mr-3"></i>
                    <span>Livreurs</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <header class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto py-4 px-6 flex justify-between items-center">
                    <h1 class="text-2xl font-semibold text-gray-800">Gestion des Paiements</h1>
                    <div class="flex items-center space-x-4">                    <form action="{{ route('bibliothecaire.payment.show') }}" method="get" class="relative">
                        <input type="text" name="search" placeholder="Rechercher..." value="{{ request('search') }}" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                        <button type="submit" class="absolute right-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                        <div class="flex items-center space-x-2">
                            <span class="text-gray-700">Admin</span>
                            <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="max-w-7xl mx-auto py-6 px-6">
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove();">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif
                
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <span>{{ session('error') }}</span>
                    <button class="text-red-700 hover:text-red-900" onclick="this.parentElement.remove();">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif
                
                @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4 flex justify-between items-center">
                    <span>{{ session('info') }}</span>
                    <button class="text-blue-700 hover:text-blue-900" onclick="this.parentElement.remove();">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                @endif                <!-- Filtres et actions -->
                <form action="{{ route('bibliothecaire.payment.show') }}" method="get" class="mb-6">
                    <div class="flex justify-between items-center">
                        <div class="flex space-x-3">
                            <select name="payment_method" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" onchange="this.form.submit()">
                                <option value="all" {{ request('payment_method') == 'all' ? 'selected' : '' }}>Tous les paiements</option>
                                <option value="card" {{ request('payment_method') == 'card' ? 'selected' : '' }}>Carte de crédit</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Espèces</option>
                            </select>
                            <select name="sort" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" onchange="this.form.submit()">
                                <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Trier par: Date (récent)</option>
                                <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Trier par: Date (ancien)</option>
                                <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Trier par: Montant (élevé-bas)</option>
                                <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Trier par: Montant (bas-élevé)</option>
                            </select>
                        </div>                        <a href="{{ route('bibliothecaire.payment.export') }}?{{ http_build_query(request()->all()) }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center">
                            <i class="fas fa-download mr-2"></i> Exporter
                        </a>
                    </div>
                </form><!-- Tableau des paiements -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="py-3 px-4 text-left font-semibold">ID Paiement</th>
                                <th class="py-3 px-4 text-left font-semibold">Date</th>
                                <th class="py-3 px-4 text-left font-semibold">Client</th>
                                <th class="py-3 px-4 text-left font-semibold">Méthode</th>
                                <th class="py-3 px-4 text-left font-semibold">Commande</th>
                                <th class="py-3 px-4 text-left font-semibold">Montant</th>
                                <th class="py-3 px-4 text-left font-semibold">Statut</th>
                                <th class="py-3 px-4 text-left font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-4 px-4 text-sm">PAY-{{ $order->id }}</td>
                                <td class="py-4 px-4 text-sm">{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="py-4 px-4 text-sm">
                                    @if($order->user_id && isset($users[$order->user_id]))
                                        {{ $users[$order->user_id]->name ?? 'Client #' . $order->user_id }}
                                    @else
                                        {{ $order->full_name ?? 'Client anonyme' }}
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    @if($order->payment_method == 'card')
                                        <span class="flex items-center">
                                            <i class="far fa-credit-card mr-1"></i> 
                                            Carte ({{ $order->card_last_four }})
                                        </span>
                                    @else
                                        {{ ucfirst($order->payment_method ?? 'Inconnu') }}
                                    @endif
                                </td>                                <td class="py-4 px-4 text-sm">
                                    <a href="{{ route('bibliothecaire.order.details', $order->id) }}" class="text-blue-600 hover:underline">
                                        {{ $order->order_number }}
                                    </a>
                                </td>
                                <td class="py-4 px-4 text-sm font-semibold">
                                    {{ number_format($order->total, 2) }} Dh
                                </td>
                                <td class="py-4 px-4 text-sm">
                                    @if($order->status == 'completed')
                                        <span class="status-badge status-completed">Réussi</span>
                                    @elseif($order->status == 'processing')
                                        <span class="status-badge status-processing">En traitement</span>
                                    @elseif($order->status == 'cancelled')
                                        <span class="status-badge status-cancelled">Annulé</span>
                                    @else
                                        <span class="status-badge status-pending">En attente</span>
                                    @endif
                                </td>                                <td class="py-4 px-4 text-sm">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('bibliothecaire.order.details', $order->id) }}" class="text-gray-600 hover:text-blue-600">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="text-gray-600 hover:text-red-600">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr class="border-t">
                                <td colspan="8" class="py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-money-check-alt text-3xl mb-3"></i>
                                        <p>Aucun paiement trouvé</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>                <!-- Pagination -->
                <div class="mt-6 flex justify-between items-center">
                    <p class="text-sm text-gray-600">
                        Affichage de {{ $orders->count() }} {{ $orders->count() > 1 ? 'paiements' : 'paiement' }} sur {{ $orders->total() }}
                    </p>
                    
                    @if($orders->hasPages())
                    <div class="flex space-x-1">
                        <a href="{{ $orders->previousPageUrl() }}" class="px-3 py-1 border rounded bg-gray-100 text-gray-600 hover:bg-gray-200 {{ !$orders->onFirstPage() ?: 'opacity-50 cursor-not-allowed' }}">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        
                        @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 2), min($orders->lastPage(), $orders->currentPage() + 2)) as $page => $url)
                            <a href="{{ $url }}" class="px-3 py-1 border rounded {{ $page == $orders->currentPage() ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                        
                        <a href="{{ $orders->nextPageUrl() }}" class="px-3 py-1 border rounded bg-gray-100 text-gray-600 hover:bg-gray-200 {{ $orders->hasMorePages() ?: 'opacity-50 cursor-not-allowed' }}">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>
</body>
</html>
