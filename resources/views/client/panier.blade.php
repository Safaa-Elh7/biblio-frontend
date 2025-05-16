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
                        'sidebar-light': '#8e3a3a',
                        'accent': '#c17a0f',
                        'text-dark': '#2d2d2d',
                        'text-medium': '#4a4a4a',
                        'text-light': '#6e6e6e',
                    },
                    boxShadow: {
                        'custom': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'input': '0 2px 5px rgba(0, 0, 0, 0.05)',
                        'card': '0 8px 30px rgba(0, 0, 0, 0.12)',
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
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            z-index: 10;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .profile-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 2px solid #e6c998;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }
        
        .sidebar-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 12px;
        }
        
        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }
        
        .sidebar-icon.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .subscribe-text {
            color: white;
            transform: rotate(90deg);
            transform-origin: center;
            white-space: nowrap;
            margin-top: auto;
            font-size: 0.875rem;
            letter-spacing: 1px;
            background-color: #4ade80;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .subscribe-text:hover {
            transform: rotate(90deg) scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        
        /* Style du contenu principal */
        .main-container {
            margin-left: 80px;
            min-height: 100vh;
            background-color: #e6c998;
            background-image: linear-gradient(to bottom right, #e9d0a3, #e6c998, #d4b785);
        }
        
        .header {
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: transparent;
            border-bottom: 1px solid rgba(124, 45, 45, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }
        
        .logo:hover {
            transform: scale(1.05);
        }
        
        .logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #7c2d2d;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .search-container {
            position: relative;
            width: 28rem;
            transition: all 0.3s ease;
        }
        
        .search-container:focus-within {
            transform: translateY(-2px);
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border-radius: 9999px;
            border: none;
            background-color: #f8e7c9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .search-input:focus {
            outline: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        
        .search-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #7c2d2d;
            font-size: 1rem;
            pointer-events: none;
        }
        
        .search-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }
        
        .search-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }
        
        .search-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(124, 45, 45, 0.3);
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
        
        .cart-items {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 1.5rem;
            flex: 1;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .cart-items:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .cart-item {
            display: flex;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid #e2d3af;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 0.5rem;
            transform: translateX(5px);
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 80px;
            height: 100px;
            object-fit: cover;
            margin-right: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .cart-item:hover .item-image {
            transform: scale(1.05) rotate(2deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d2d2d;
            margin-bottom: 0.25rem;
            transition: color 0.3s ease;
        }
        
        .cart-item:hover .item-title {
            color: #7c2d2d;
        }
        
        .item-author {
            font-size: 0.875rem;
            color: #6e6e6e;
        }
        
        .quantity-control {
            display: flex;
            align-items: center;
            margin-right: 1.5rem;
            background-color: white;
            border-radius: 0.5rem;
            padding: 0.25rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
            transition: all 0.2s ease;
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
            text-align: right;
            width: 100px;
        }
        
        .remove-btn {
            color: #8b2121;
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            opacity: 0.5;
        }
        
        .remove-btn:hover {
            background-color: rgba(139, 33, 33, 0.1);
            transform: rotate(90deg);
            opacity: 1;
        }
        
        /* Styles pour le résumé de commande */
        .order-summary {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 2rem;
            width: 300px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .order-summary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .summary-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
        }
        
        .summary-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
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
        }
        
        .summary-label {
            color: #4a4a4a;
        }
        
        .summary-value {
            font-weight: 600;
            color: #2d2d2d;
        }
        
        .summary-divider {
            height: 1px;
            background-color: #e2d3af;
            margin: 1.5rem 0;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
        }
        
        .total-label {
            font-weight: 600;
            color: #2d2d2d;
        }
        
        .total-value {
            font-weight: 700;
            color: #7c2d2d;
        }
        
        .checkout-btn {
            background-color: #7c2d2d;
            color: white;
            width: 100%;
            padding: 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .checkout-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }
        
        .checkout-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(124, 45, 45, 0.3);
        }
        
        .checkout-btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 5px;
            height: 5px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 0;
            border-radius: 100%;
            transform: scale(1, 1) translate(-50%);
            transform-origin: 50% 50%;
        }
        
        .checkout-btn:focus:not(:active)::after {
            animation: ripple 1s ease-out;
        }
        
        @keyframes ripple {
            0% {
                transform: scale(0, 0);
                opacity: 0.5;
            }
            20% {
                transform: scale(25, 25);
                opacity: 0.5;
            }
            100% {
                opacity: 0;
                transform: scale(40, 40);
            }
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
            padding: 3rem;
            font-size: 1.25rem;
            color: #6e6e6e;
        }
        
        .empty-cart-icon {
            font-size: 4rem;
            color: #d4b785;
            margin-bottom: 1rem;
        }
        
        .add-book-form {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 1.5rem;
            width: 300px;
            margin-top: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .add-book-form:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 1rem;
            text-align: center;
            position: relative;
        }
        
        .form-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 2px;
            background-color: #7c2d2d;
            border-radius: 1px;
        }
        
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #e2d3af;
            background-color: white;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .form-input:focus {
            outline: none;
            border-color: #7c2d2d;
            box-shadow: 0 0 0 3px rgba(124, 45, 45, 0.15);
        }
        
        .add-book-btn {
            background-color: #7c2d2d;
            color: white;
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
        }
        
        .add-book-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }
        
        .add-book-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(124, 45, 45, 0.3);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-icon">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Profile" class="w-full h-full object-cover">
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-bars"></i>
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-home"></i>
        </div>
        
        <div class="sidebar-icon active">
            <i class="fas fa-shopping-cart"></i>
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-camera"></i>
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-envelope"></i>
        </div>
        
        <div class="subscribe-text">
            Subscribe
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="mr-3 text-sidebar text-3xl">
                    <i class="fas fa-book-open"></i>
                </div>
                <h1 class="text-2xl font-bold logo-text">MyBookSpace</h1>
            </div>
            
            <div class="flex items-center">
                <div class="search-container mr-4">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Search for books, authors, genres..." class="search-input">
                </div>
                <button id="searchButton" class="search-btn">
                    Search
                </button>
            </div>
        </header>
        
        <!-- Shopping Cart Title -->
        <h1 class="cart-title">Shopping Cart</h1>
        
        <!-- Shopping Cart Content -->
        <div class="cart-container">
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
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}" alt="{{ $item['name'] }}" class="item-image">
                            <div class="item-details">
                                <h3 class="item-title">{{ $item['name'] }}</h3>
                            </div>
                            <form method="POST" action="{{ route('client.panier.update') }}" class="quantity-control flex items-center">
                                @csrf
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" name="action" value="decrement" class="quantity-btn">-</button>
                                <input type="text" value="{{ $item['quantity'] }}" class="quantity-input" readonly style="width:40px;">
                                <button type="submit" name="action" value="increment" class="quantity-btn">+</button>
                            </form>
                            <div class="item-price">{{ $item['price'] * $item['quantity'] }} Dh</div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <!-- Right Side - Order Summary -->
            <div class="right-column">
                <div class="order-summary">
                    <h2 class="summary-title">Order Summary</h2>
                    
                    <div class="summary-row">
                        <span class="summary-label">Subtotal</span>
                        <span class="summary-value" id="subtotalValue">
                            {{ array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) }} Dh
                        </span>
                    </div>
                    
                    <div class="summary-row">
                        <span class="summary-label">Estimated tax (4%)</span>
                        <span class="summary-value" id="taxValue">
                            {{ round(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) * 0.04) }} Dh
                        </span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="total-row">
                        <span class="total-label">Total</span>
                        <span class="total-value" id="totalValue">
                            {{ round(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart)) * 1.04) }} Dh
                        </span>
                    </div>
                    
                    <a href="{{route('client.card.index')}}" class="checkout-btn" id="checkoutBtn">
                        Proceed to Checkout
                    </a>
                    
                    <div class="secure-badge">
                        <i class="fas fa-lock"></i> Secure checkout
                    </div>
                </div>
                
                <!-- Add Book Form -->
                <div class="add-book-form mt-4">
                   
                </div>
            </div>
        </div>
    </div>

    <script>
        // Supprimer tout le code JavaScript lié aux livres statiques et à cartBooks
        // Les livres du panier sont désormais affichés dynamiquement côté serveur avec Laravel
    </script>
</body>
</html>