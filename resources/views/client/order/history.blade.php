<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique de commandes - MyBookSpace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'beige': '#e6c998',
                        'beige-light': '#f8e7c9',
                        'beige-dark': '#d4b785',
                        'sidebar': '#7c2d2d',
                        'sidebar-dark': '#6a2424',
                        'sidebar-light': '#8e3a3a',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', system-ui, sans-serif;
            background-color: #e6c998;
            color: #2d2d2d;
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        
        .sidebar {
            width: 80px;
            background-color: #7c2d2d;
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            z-index: 10;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        
        .main-container {
            margin-left: 80px;
            min-height: 100vh;
            padding: 2rem;
        }
        
        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #7c2d2d;
            margin-bottom: 2rem;
            position: relative;
            display: inline-block;
        }
        
        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: #7c2d2d;
            border-radius: 2px;
        }
        
        .order-card {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2d3af;
        }
        
        .order-number {
            font-weight: 700;
            font-size: 1.25rem;
            color: #7c2d2d;
        }
        
        .order-date {
            font-size: 0.875rem;
            color: #666;
        }
        
        .order-items {
            margin-bottom: 1.5rem;
            padding: 0.5rem;
            background-color: #f0e1c0;
            border-radius: 0.5rem;
        }
        
        .order-item {
            display: flex;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .order-item-quantity {
            background-color: #7c2d2d;
            color: white;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 0.875rem;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .order-item-name {
            flex: 1;
            font-weight: 500;
        }
        
        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e2d3af;
        }
        
        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        
        .status-processing {
            background-color: #dbeafe;
            color: #2563eb;
        }
        
        .status-completed {
            background-color: #d1fae5;
            color: #059669;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #dc2626;
        }
        
        .order-total {
            font-weight: 700;
            font-size: 1.25rem;
            color: #7c2d2d;
        }
        
        .view-details-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .item-image {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .view-details-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background-color: #f8e7c9;
            border-radius: 1rem;
            margin-top: 2rem;
        }
        
        .empty-icon {
            font-size: 4rem;
            color: #d4b785;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="w-12 h-12 rounded-full overflow-hidden mb-6 border-2 border-beige">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile" class="w-full h-full object-cover">
        </div>
        
        <a href="#" class="text-white text-xl mb-6"><i class="fas fa-bars"></i></a>
        <a href="{{ route('client.home') }}" class="text-white text-xl mb-6"><i class="fas fa-home"></i></a>
        <a href="{{ route('client.panier.index') }}" class="text-white text-xl mb-6"><i class="fas fa-shopping-cart"></i></a>
        <a href="#" class="text-white text-xl mb-6"><i class="fas fa-history"></i></a>
        <a href="#" class="text-white text-xl mb-6"><i class="fas fa-envelope"></i></a>
        
        <div class="mt-auto">
            <div class="bg-green-500 px-2 py-1 rounded text-white text-xs rotate-90 transform origin-center">Subscribe</div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <i class="fas fa-book-open text-2xl text-sidebar mr-2"></i>
                <h1 class="text-2xl font-bold text-sidebar">MyBookSpace</h1>
            </div>
            
            <form action="{{ route('client.order.search') }}" method="GET" class="flex w-1/2">
                <div class="relative flex-1 mr-2">
                    <input type="text" name="search" placeholder="Rechercher une commande..." value="{{ $searchTerm ?? '' }}" class="w-full px-4 py-2 pl-10 rounded-full border-none focus:outline-none bg-beige-light">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-sidebar"></i>
                </div>
                <button type="submit" class="bg-sidebar text-white px-4 py-2 rounded-full">Rechercher</button>
            </form>
        </header>
        
        <h1 class="page-title">Mes commandes</h1>
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        @if(count($orders) > 0)
            <div class="orders-container">
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <div>
                                <div class="order-number">Commande #{{ $order->order_number }}</div>
                                <div class="order-date">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>
                            <div>
                                @if($order->status == 'pending')
                                    <span class="order-status status-pending">En attente</span>
                                @elseif($order->status == 'processing')
                                    <span class="order-status status-processing">En traitement</span>
                                @elseif($order->status == 'completed')
                                    <span class="order-status status-completed">Terminée</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="order-status status-cancelled">Annulée</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="order-items">
                            @php
                                // Limiter l'affichage à 3 éléments et afficher +X pour les autres
                                $items = $order->items;
                                $displayItems = $items->take(3);
                                $remainingCount = $items->count() - 3;
                            @endphp
                            
                            @foreach($displayItems as $item)
                                @php
                                    $book = $books->firstWhere('id_article', $item->book_id);
                                    $bookImage = $book && !empty($book->image) ? (filter_var($book->image, FILTER_VALIDATE_URL) ? $book->image : asset('storage/' . $book->image)) : 'https://via.placeholder.com/80x100?text=Livre';
                                @endphp
                                <div class="order-item flex items-center gap-4 mb-3 bg-white p-2 rounded-lg">
                                    <img src="{{ $bookImage }}" alt="{{ $item->name }}" class="item-image">
                                    <div class="flex-1">
                                        <div class="order-item-name font-medium">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $book->auteur ?? 'Auteur inconnu' }}</div>
                                    </div>
                                    <div class="order-item-quantity">{{ $item->quantity }}</div>
                                </div>
                            @endforeach
                            
                            @if($remainingCount > 0)
                                <div class="text-sm text-gray-600 mt-1">+ {{ $remainingCount }} autre(s) article(s)</div>
                            @endif
                        </div>
                        
                        <div class="order-footer">
                            <div class="order-total">{{ $order->total }} Dh</div>
                            <a href="{{ route('client.order.show', $order->id) }}" class="view-details-btn">
                                <i class="fas fa-eye"></i> Voir les détails
                            </a>
                        </div>
                    </div>
                @endforeach
                
                {{ $orders->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h2 class="text-xl font-semibold mb-2">Aucune commande trouvée</h2>
                <p class="text-gray-600 mb-4">Vous n'avez pas encore passé de commande.</p>
                <a href="{{ route('client.home') }}" class="bg-sidebar text-white px-4 py-2 rounded-full inline-block">
                    Parcourir la bibliothèque
                </a>
            </div>
        @endif
    </div>
</body>
</html>