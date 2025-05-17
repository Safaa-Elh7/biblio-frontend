<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Panier d'achat</title>
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
                        'accent': '#c17a0f',
                        'text-dark': '#2d2d2d',
                        'text-medium': '#4a4a4a',
                        'text-light': '#6e6e6e',
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
            margin: 0;
            padding: 0;
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
        }
        
        .profile-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 2rem;
            border: 2px solid #e6c998;
        }
        
        .sidebar-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
            cursor: pointer;
        }
        
        .sidebar-icon.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
        }
        
        .cart-container {
            margin-left: 80px;
            padding: 2rem;
        }
        
        .cart-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 2rem;
            padding-bottom: 0.5rem;
            border-bottom: 4px solid #7c2d2d;
            display: inline-block;
        }
        
        .cart-items {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e2d3af;
            position: relative;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 100px;
            height: 130px;
            object-fit: cover;
            margin-right: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.25rem;
        }
        
        .item-author {
            font-size: 0.875rem;
            color: #6e6e6e;
            margin-bottom: 0.5rem;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            background-color: white;
            border-radius: 0.5rem;
            padding: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-right: 2rem;
        }
        
        .quantity-btn {
            background-color: #e2d3af;
            border: none;
            width: 30px;
            height: 30px;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 0.25rem;
            color: #7c2d2d;
        }
        
        .quantity-btn:hover {
            background-color: #7c2d2d;
            color: white;
        }
        
        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: none;
            background-color: transparent;
            margin: 0 0.5rem;
            font-weight: 600;
            color: #2d2d2d;
        }
        
        .item-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: #7c2d2d;
            width: 120px;
            text-align: right;
        }
        
        .remove-btn {
            color: #7c2d2d;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 1rem;
            opacity: 0.7;
        }
        
        .remove-btn:hover {
            background-color: rgba(124, 45, 45, 0.1);
            opacity: 1;
        }
        
        .order-summary {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 1.5rem;
            max-width: 400px;
            margin-left: auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        
        .summary-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            padding-bottom: 0.5rem;
        }
        
        .summary-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background-color: #7c2d2d;
            border-radius: 1.5px;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            font-size: 1rem;
            padding: 0.5rem 0;
        }
        
        .summary-divider {
            height: 1px;
            background-color: #e2d3af;
            margin: 1rem 0;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d2d2d;
            padding: 0.5rem 0;
        }
        
        .checkout-btn {
            background-color: #7c2d2d;
            color: white;
            width: 100%;
            padding: 0.75rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .checkout-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 45, 45, 0.3);
        }
        
        .secure-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 1rem;
            color: #6e6e6e;
            font-size: 0.875rem;
        }
        
        .secure-badge i {
            margin-right: 0.5rem;
            color: #7c2d2d;
        }
        
        .empty-cart-message {
            text-align: center;
            padding: 4rem 2rem;
            font-size: 1.25rem;
            color: #6e6e6e;
        }
        
        .empty-cart-icon {
            font-size: 4rem;
            color: #d4b785;
            margin-bottom: 1rem;
        }
        
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #7c2d2d;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .notification.show {
            opacity: 1;
            transform: translateY(0);
        }
        
        .notification-icon {
            margin-right: 12px;
            font-size: 24px;
            color: #e6c998;
        }
        
        .notification-content {
            flex: 1;
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 3px;
        }
        
        .notification-message {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .notification-close {
            background: none;
            border: none;
            color: white;
            margin-left: 15px;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }
        
        .notification-close:hover {
            opacity: 1;
        }
        
        .notification-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: rgba(255, 255, 255, 0.2);
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            overflow: hidden;
        }
        
        .notification-progress-bar {
            height: 100%;
            background-color: #e6c998;
            width: 100%;
            transform-origin: left;
            animation: progress 3s linear forwards;
        }
        
        @keyframes progress {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }
        
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 1.5rem;
        }
        
        @media (max-width: 768px) {
            .grid-container {
                grid-template-columns: 1fr;
            }
            
            .order-summary {
                margin-left: 0;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-icon">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile" class="w-full h-full object-cover">
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-bars"></i>
        </div>
        
        <a href="{{ route('client.home') }}" class="sidebar-icon">
            <i class="fas fa-home"></i>
        </a>
        
        <a href="{{ route('client.panier.index') }}" class="sidebar-icon active">
            <i class="fas fa-shopping-cart"></i>
        </a>
        
        <div class="sidebar-icon">
                    <a href="{{route('order.history')}}" class="text-white text-xl mb-6"><i class="fas fa-history"></i></a>
</i>
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-envelope"></i>
        </div>
        
        <div class="sidebar-icon mt-auto bg-green-500 rounded">
            <span class="rotate-90 whitespace-nowrap text-xs font-medium">Subscribe</span>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="cart-container">
        <header class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <i class="fas fa-book text-2xl text-sidebar mr-2"></i>
                <h1 class="text-2xl font-bold text-sidebar">MyBookSpace</h1>
            </div>
            
            <div class="flex items-center">
                <div class="relative mr-4">
                    <input type="text" placeholder="Search for books, authors, genres..." class="px-4 py-2 pl-10 rounded-full bg-beige-light border-none w-80 focus:outline-none">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-sidebar"></i>
                </div>
                <button class="bg-sidebar text-white px-4 py-2 rounded-full font-medium hover:bg-sidebar-dark transition-colors">
                    Search
                </button>
            </div>
        </header>
        
        <!-- Shopping Cart Title -->
        <h1 class="cart-title">Shopping Cart</h1>
        
        <!-- Shopping Cart Content -->
        <div class="grid-container">
            <!-- Left Side - Cart Items -->
            <div class="cart-items" id="cartItems">
                @if(session('success'))
                    <div class="p-4 mb-4 text-green-800 rounded bg-green-200">{{ session('success') }}</div>
                @endif
                @php
                    $cart = session('cart', []);
                @endphp
                @if(empty($cart))
                    <div class="empty-cart-message">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <p>Your cart is empty</p>
                        <p class="text-sm mt-2 text-gray-500">Browse our collection to find your next favorite book!</p>
                    </div>
                @else
                    @foreach($cart as $id => $item)
                        <div class="cart-item">
                            <img src=" {{ $item['image'] }} " alt="{{ $item['name'] }}" class="item-image">
                            <div class="item-details">
                                <h3 class="item-title">{{ $item['name'] }}</h3>
                                <p class="item-author">{{ $item['author'] }}</p>
                            </div>
                            <form method="POST" action="{{ route('client.panier.update') }}" class="quantity-control flex items-center">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" name="action" value="decrement" class="quantity-btn">-</button>
                                <input type="text" value="{{ $item['quantity'] }}" class="quantity-input" readonly style="width:40px;">
                                <button type="submit" name="action" value="increment" class="quantity-btn">+</button>
                            </form>
                            <div class="item-price">{{ $item['price'] * $item['quantity'] }} Dh</div>
                            <form method="POST" action="{{ route('client.panier.remove') }}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="remove-btn" title="Supprimer">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Right Side - Order Summary -->
            <div class="order-summary">
                <h2 class="summary-title">Order Summary</h2>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotalValue">
                        {{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) }} Dh
                    </span>
                </div>
                
                <div class="summary-row">
                    <span>Estimated tax (4%)</span>
                    <span id="taxValue">
                        {{ round(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) * 0.04) }} Dh
                    </span>
                </div>
                
                <div class="summary-divider"></div>
                
                <div class="total-row">
                    <span>Total</span>
                    <span id="totalValue">
                        {{ round(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) * 1.04) }} Dh
                    </span>
                </div>
                
                <a href="{{ route('client.card.index') }}" class="checkout-btn block text-center no-underline">
                    Proceed to Checkout
                </a>
                
                <div class="secure-badge">
                    <i class="fas fa-lock"></i> Secure checkout
                </div>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification">
        <div class="notification-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-content">
            <div class="notification-title">Action réussie</div>
            <div class="notification-message" id="notification-message">
                @if(session('success'))
                    {{ session('success') }}
                @endif
            </div>
        </div>
        <button class="notification-close" id="notification-close"><i class="fas fa-times"></i></button>
        <div class="notification-progress">
            <div class="notification-progress-bar"></div>
        </div>
    </div>

    <script>
         document.addEventListener("DOMContentLoaded", function() {
        fetch("http://localhost:8080/api/articles") // Ton API Spring Boot
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById("cartItems");
                container.innerHTML = ''; // Clear current items

                if (data.length === 0) {
                    container.innerHTML = `
                        <div class="empty-cart-message">
                            <div class="empty-cart-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <p>Your cart is empty</p>
                            <p class="text-sm mt-2 text-gray-500">Browse our collection to find your next favorite book!</p>
                        </div>
                    `;
                } else {
                    // Fonction pour gérer les URLs d'images de manière cohérente
                    function getImageUrl(imagePath, defaultUrl = 'https://via.placeholder.com/100x130?text=Image') {
                        if (!imagePath) return defaultUrl;
                        if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
                            return imagePath;
                        }
                        return `/storage/${imagePath.replace(/^\/+/, '')}`;
                    }
                    
                    data.forEach(item => {
                        const imageUrl = getImageUrl(item.image);

                        container.innerHTML += `
                            <div class="cart-item">
                                <img src="${imageUrl}" alt="${item.titre}" class="item-image">
                                <div class="item-details">
                                    <h3 class="item-title">${item.titre}</h3>
                                    <p class="item-author">${item.auteur}</p>
                                </div>
                                <div class="item-price">${item.prix_emprunt ?? '0'} Dh</div>
                            </div>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error("Erreur lors du chargement des articles :", error);
            });
    });
    </script>
</body>
</html>