<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Détails de la Commande</title>
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
                <a href="{{ route('bibliothecaire.order.show') }}" class="flex items-center px-6 py-3 bg-red-700 text-white transition-colors">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Commandes</span>
                </a>
                <a href="{{ route('bibliothecaire.payment.show') }}" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
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
                    <h1 class="text-2xl font-semibold text-gray-800">Détails de la Commande #{{ $order->order_number }}</h1>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('bibliothecaire.order.show') }}" class="flex items-center text-gray-600 hover:text-red-600">
                            <i class="fas fa-arrow-left mr-2"></i> Retour aux commandes
                        </a>
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
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <div class="flex justify-between mb-6">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Informations de la commande</h2>
                            <p class="text-sm text-gray-600">Créée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div>
                            @if($order->status == 'completed')
                                <span class="status-badge status-completed">Complétée</span>
                            @elseif($order->status == 'processing')
                                <span class="status-badge status-processing">En traitement</span>
                            @elseif($order->status == 'cancelled')
                                <span class="status-badge status-cancelled">Annulée</span>
                            @else
                                <span class="status-badge status-pending">En attente</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informations client -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="text-md font-semibold text-gray-700 mb-3">Client</h3>
                            <div class="space-y-2 text-sm">
                                <p><span class="font-medium">Nom:</span> {{ $order->full_name }}</p>
                                @if($user)
                                    <p><span class="font-medium">Email:</span> {{ $user->email ?? 'Non renseigné' }}</p>
                                    <p><span class="font-medium">Téléphone:</span> {{ $user->telephone ?? 'Non renseigné' }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Adresse de livraison -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="text-md font-semibold text-gray-700 mb-3">Adresse de livraison</h3>
                            <div class="space-y-2 text-sm">
                                <p>{{ $order->full_name }}</p>
                                <p>{{ $order->address }}</p>
                                <p>{{ $order->city }}, {{ $order->zip_code }}</p>
                            </div>
                        </div>
                        
                        <!-- Informations de paiement -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="text-md font-semibold text-gray-700 mb-3">Paiement</h3>
                            <div class="space-y-2 text-sm">
                                <p>
                                    <span class="font-medium">Méthode:</span>
                                    @if($order->payment_method == 'card')
                                        <span class="inline-flex items-center">
                                            <i class="far fa-credit-card mr-1"></i>
                                            Carte de crédit (se terminant par {{ $order->card_last_four }})
                                        </span>
                                    @else
                                        {{ ucfirst($order->payment_method ?? 'Non spécifié') }}
                                    @endif
                                </p>
                                <p><span class="font-medium">Date:</span> {{ $order->created_at->format('d/m/Y') }}</p>
                                <p><span class="font-medium">Statut:</span>
                                    @if($order->status == 'completed')
                                        <span class="text-green-600">Payé</span>
                                    @else
                                        <span class="text-yellow-600">En attente</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="border rounded-lg p-4 bg-gray-50">
                            <h3 class="text-md font-semibold text-gray-700 mb-3">Actions</h3>
                            <div class="flex space-x-2">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm flex items-center">
                                    <i class="fas fa-print mr-1"></i> Imprimer
                                </button>
                                <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm flex items-center">
                                    <i class="fas fa-file-pdf mr-1"></i> Générer PDF
                                </button>
                                @if($order->status != 'completed')
                                <button class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm flex items-center">
                                    <i class="fas fa-check mr-1"></i> Marquer comme complétée
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Articles commandés -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="p-4 border-b">
                        <h2 class="text-lg font-semibold text-gray-800">Articles commandés</h2>
                    </div>
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 text-sm">
                                <th class="py-3 px-4 text-left font-semibold">Produit</th>
                                <th class="py-3 px-4 text-center font-semibold">Quantité</th>
                                <th class="py-3 px-4 text-right font-semibold">Prix unitaire</th>
                                <th class="py-3 px-4 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="flex items-center">
                                        @if(!empty($item->image))
                                        <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-12 h-16 object-cover mr-3">
                                        @else
                                        <div class="w-12 h-16 bg-gray-200 flex items-center justify-center mr-3">
                                            <i class="fas fa-book text-gray-500"></i>
                                        </div>
                                        @endif
                                        <div>
                                            <p class="font-medium">{{ $item->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->author ?? 'Auteur non spécifié' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">{{ $item->quantity }}</td>
                                <td class="py-4 px-4 text-right">{{ number_format($item->price, 2) }} Dh</td>
                                <td class="py-4 px-4 text-right font-medium">{{ number_format($item->price * $item->quantity, 2) }} Dh</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-8 text-center text-gray-500">Aucun article trouvé pour cette commande</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="p-4"></td>
                                <td class="py-4 px-4 text-right font-medium">Sous-total:</td>
                                <td class="py-4 px-4 text-right">{{ number_format($order->subtotal, 2) }} Dh</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-4"></td>
                                <td class="py-2 px-4 text-right font-medium">TVA (4%):</td>
                                <td class="py-2 px-4 text-right">{{ number_format($order->tax, 2) }} Dh</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="p-4"></td>
                                <td class="py-2 px-4 text-right font-medium">Frais de livraison:</td>
                                <td class="py-2 px-4 text-right">{{ number_format($order->shipping ?? 20, 2) }} Dh</td>
                            </tr>
                            <tr class="border-t">
                                <td colspan="2" class="p-4"></td>
                                <td class="py-4 px-4 text-right font-semibold">Total:</td>
                                <td class="py-4 px-4 text-right font-bold text-lg">{{ number_format($order->subtotal + $order->tax + ($order->shipping ?? 20), 2) }} Dh</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
