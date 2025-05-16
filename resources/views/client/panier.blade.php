<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Panier d'achat Premium</title>
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
                        'sidebar-light': '#8e3a3a'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000;
            color: #2d2d2d;
        }
        
        h1, h2, h3 {
            font-family: 'Playfair Display', serif;
        }
        
        /* Styles de la sidebar */
        .sidebar {
            width: 80px;
            background-color: #7c2d2d;
            background-image: linear-gradient(to bottom, #8e3a3a, #7c2d2d, #6a2424);
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 2rem;
            padding-bottom: 1rem;
            z-index: 10;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Autres styles existants */
        /* ... */
        
        /* Style du contenu principal */
        .main-container {
            background-color: #e6c998;
            margin-left: 80px;
            min-height: 100vh;
            padding: 2rem;
            position: relative;
        }
        
        /* Styles pour le panier */
        .cart-title {
            font-size: 3rem;
            font-weight: 700;
            color: #2d2d2d;
            margin: 2rem 0;
            padding-left: 2rem;
            position: relative;
            display: inline-block;
        }
        
        .cart-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 2rem;
            width: 80px;
            height: 4px;
            background-color: #7c2d2d;
            border-radius: 2px;
        }
        
        .cart-container {
            padding: 1rem 2rem 3rem;
            display: flex;
            gap: 2rem;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-icon w-14 h-14 bg-beige rounded-full overflow-hidden mb-10 shadow-lg">
            <img src="https://via.placeholder.com/100" alt="Profile" class="w-full h-full object-cover">
        </div>
        
        <a href="{{ route('client.home') }}" class="sidebar-icon w-10 h-10 flex items-center justify-center text-white text-xl mb-8 hover:bg-sidebar-light rounded-full transition-colors">
            <i class="fas fa-home"></i>
        </a>
        
        <a href="#" class="sidebar-icon w-10 h-10 flex items-center justify-center text-white text-xl mb-8 hover:bg-sidebar-light rounded-full transition-colors">
            <i class="fas fa-book"></i>
        </a>
        
        <a href="{{ route('client.panier.index') }}" class="sidebar-icon active w-10 h-10 flex items-center justify-center text-beige text-xl mb-8 bg-sidebar-light rounded-full">
            <i class="fas fa-shopping-cart"></i>
        </a>
        
        <a href="#" class="sidebar-icon w-10 h-10 flex items-center justify-center text-white text-xl mb-8 hover:bg-sidebar-light rounded-full transition-colors">
            <i class="fas fa-heart"></i>
        </a>
        
        <a href="#" class="sidebar-icon w-10 h-10 flex items-center justify-center text-white text-xl mb-8 hover:bg-sidebar-light rounded-full transition-colors">
            <i class="fas fa-cog"></i>
        </a>
        
        <div class="subscribe-text mt-auto text-beige text-sm font-medium px-3 py-2 bg-sidebar-dark rounded-full transform rotate-90 origin-left translate-x-5 hover:bg-sidebar-light transition-colors cursor-pointer">
            Premium
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Header -->
        <header class="header mb-8 flex justify-between items-center">
            <div class="logo flex items-center">
                <i class="fas fa-book-open text-4xl text-sidebar mr-3"></i>
                <span class="logo-text text-3xl font-bold text-sidebar">MyBookSpace</span>
            </div>
            
            <div class="search-container flex bg-white rounded-full shadow-md w-1/3 px-4 py-2">
                <i class="fas fa-search text-sidebar my-auto"></i>
                <input type="text" class="search-input ml-2 flex-1 border-none focus:outline-none" placeholder="Rechercher un livre...">
                <button class="search-btn bg-sidebar text-white rounded-full px-4 py-1">
                    <i class="fas fa-search mr-1"></i> Rechercher
                </button>
            </div>
        </header>
        
        <!-- Shopping Cart Title -->
        <h1 class="cart-title">Mon Panier</h1>
        
        <!-- Shopping Cart Content -->
        <div class="cart-container">
            <div class="cart-items">
                @php
                $cart = session()->get('cart', []);
                $total = 0;
                @endphp
                
                @if(count($cart) > 0)
                    @foreach($cart as $id => $details)
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <div class="cart-item" data-id="{{ $id }}">
                            <img src="{{ $details['image'] }}" alt="{{ $details['name'] }}" class="item-image">
                            <div class="item-details">
                                <h3 class="item-title">{{ $details['name'] }}</h3>
                                <p class="item-author">Auteur: {{ $details['author'] ?? 'Non spécifié' }}</p>
                            </div>
                            <div class="quantity-control">
                                <form action="{{ route('client.panier.update') }}" method="POST" class="increment-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="action" value="decrement">
                                    <button type="submit" class="quantity-btn decrement">-</button>
                                </form>
                                <input type="text" class="quantity-input" value="{{ $details['quantity'] }}" readonly>
                                <form action="{{ route('client.panier.update') }}" method="POST" class="increment-form">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="hidden" name="action" value="increment">
                                    <button type="submit" class="quantity-btn increment">+</button>
                                </form>
                            </div>
                            <div class="item-price">{{ $details['price'] * $details['quantity'] }} Dh</div>
                            <button class="remove-btn" data-id="{{ $id }}"><i class="fas fa-times"></i></button>
                        </div>
                    @endforeach
                @else
                    <div class="empty-cart-message p-10 text-center">
                        <div class="empty-cart-icon text-6xl text-gray-400 mb-4"><i class="fas fa-shopping-cart"></i></div>
                        <h3 class="text-2xl font-semibold mb-2">Votre panier est vide</h3>
                        <p class="text-gray-600 mb-6">Explorez notre bibliothèque et ajoutez des livres à votre panier</p>
                        <a href="{{ route('client.home') }}" class="bg-sidebar text-white rounded-full px-6 py-3 text-lg font-medium inline-flex items-center">
                            <i class="fas fa-book-open mr-2"></i> Découvrir des livres
                        </a>
                    </div>
                @endif
            </div>
            
            <div class="order-summary">
                <h2 class="summary-title text-2xl font-bold mb-6">Résumé de commande</h2>
                
                <div class="summary-row flex justify-between mb-3">
                    <span class="summary-label">Total des articles:</span>
                    <span class="summary-value">{{ array_sum(array_map(function($item) { return $item['quantity']; }, $cart)) }}</span>
                </div>
                
                <div class="summary-row flex justify-between mb-3">
                    <span class="summary-label">Sous-total:</span>
                    <span class="summary-value">{{ $total }} Dh</span>
                </div>
                
                <div class="summary-row flex justify-between mb-3">
                    <span class="summary-label">Frais de service:</span>
                    <span class="summary-value">{{ $total > 0 ? 25 : 0 }} Dh</span>
                </div>
                
                <div class="summary-divider h-px bg-beige-dark my-4"></div>
                
                <div class="total-row flex justify-between mb-6">
                    <span class="total-label font-bold text-lg">Total:</span>
                    <span class="total-value font-bold text-2xl text-sidebar">{{ $total > 0 ? $total + 25 : 0 }} Dh</span>
                </div>
                
                <a href="{{ route('client.card.index') }}" class="checkout-btn bg-sidebar text-white py-3 px-6 rounded-full w-full block text-center font-semibold text-lg {{ count($cart) == 0 ? 'opacity-50 cursor-not-allowed' : '' }}" {{ count($cart) == 0 ? 'disabled' : '' }}>
                    Procéder au paiement
                </a>
                
                <div class="secure-badge flex items-center justify-center mt-4 text-sm text-gray-600">
                    <i class="fas fa-lock mr-2"></i> Paiement 100% sécurisé
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Gestion de la suppression des articles
            $('.remove-btn').click(function() {
                const id = $(this).data('id');
                
                if (confirm('Êtes-vous sûr de vouloir retirer ce livre du panier?')) {
                    $.ajax({
                        url: '{{ route("client.panier.remove") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: id
                        },
                        success: function() {
                            location.reload();
                        }
                    });
                }
            });
            
            // Gestion des formulaires d'incrémentation/décrémentation avec AJAX
            $('.increment-form').submit(function(e) {
                e.preventDefault();
                
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function() {
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>