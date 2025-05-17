<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Checkout Premium</title>
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
        
        h1, h2, h3, .logo-text {
            font-family: 'Playfair Display', serif;
        }
        
        /* Styles de la sidebar */
        .sidebar {
            width: 270px;
            background-color: #7c2d2d;
            background-image: linear-gradient(to bottom, #8e3a3a, #7c2d2d, #6a2424);
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 3rem;
            padding-bottom: 1.5rem;
            z-index: 10;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 3rem;
            transition: transform 0.3s ease;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .logo-icon {
            font-size: 3rem;
            color: #e6c998;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .logo-text {
            color: #e6c998;
            font-size: 1.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        
        .profile-container {
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .profile-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 3px solid #e6c998;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }
        
        .nav-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .nav-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7c2d2d;
            font-size: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .nav-icon:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            background-color: #f8f8f8;
        }
        
        /* Style du contenu principal */
        .main-container {
            margin-left: 270px;
            min-height: 100vh;
            background-color: #e6c998;
            background-image: linear-gradient(to bottom right, #e9d0a3, #e6c998, #d4b785);
            padding: 3rem;
            position: relative;
        }
        
        .checkout-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: #2d2d2d;
            margin-bottom: 2.5rem;
            position: relative;
            display: inline-block;
        }
        
        .checkout-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background-color: #7c2d2d;
            border-radius: 2px;
        }
        
        .checkout-container {
            display: flex;
            gap: 3rem;
            margin-bottom: 2rem;
        }
        
        .checkout-section {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            flex: 1;
        }
        
        .checkout-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .section-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
        
        .section-title i {
            margin-right: 0.75rem;
            font-size: 1.5rem;
        }
        
        .input-group {
            margin-bottom: 1.5rem;
            position: relative;
        }
        
        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #4a4a4a;
            margin-bottom: 0.5rem;
        }
        
        .input-field {
            width: 100%;
            padding: 0.875rem 1rem;
            border-radius: 0.5rem;
            border: 1px solid #d4d4d4;
            background-color: white;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .input-field:focus {
            outline: none;
            border-color: #7c2d2d;
            box-shadow: 0 0 0 3px rgba(124, 45, 45, 0.15);
        }
        
        .input-field::placeholder {
            color: #aaa;
        }
        
        .input-icon {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: #7c2d2d;
        }
        
        .card-icons {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }
        
        .card-icon {
            width: 60px;
            height: 40px;
            background-color: #1a1a1a;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
            cursor: pointer;
        }
        
        .card-icon:hover {
            transform: translateY(-2px);
        }
        
        .card-icon.active {
            border: 2px solid #7c2d2d;
        }
        
        .card-row {
            display: flex;
            gap: 1rem;
        }
        
        /* Styles pour le résumé de commande */
        .order-summary {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 2rem;
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
        
        .order-items {
            margin-bottom: 1.5rem;
        }
        
        .order-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2d3af;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 50px;
            height: 70px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-right: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-title {
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }
        
        .item-author {
            font-size: 0.75rem;
            color: #6e6e6e;
        }
        
        .item-price {
            font-weight: 600;
            font-size: 0.875rem;
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 1rem;
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
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d2d2d;
        }
        
        .place-order-btn {
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
        
        .place-order-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }
        
        .place-order-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(124, 45, 45, 0.3);
        }
        
        .place-order-btn::after {
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
        
        .place-order-btn:focus:not(:active)::after {
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
        
        /* Animation de chargement */
        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        
        .loading.active {
            opacity: 1;
            visibility: visible;
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #7c2d2d;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: help;
        }
        
        .tooltip .tooltip-text {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }
        
        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }
        .focused {
            position: relative;
        }
        .focused::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 100%;
            height: 2px;
            background: #7c2d2d;
            border-radius: 1px;
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        .focused.active::after {
            transform: scaleX(1);
        }
        .border-red-500 {
            border-color: #ef4444 !important;
        }
        
        .error-message {
            display: block;
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.25rem;
            transition: all 0.2s ease;
        }
        
        input:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo-container">
            <div class="logo-icon">
                <i class="fas fa-book-open"></i>
            </div>
            <div class="logo-text">MyBookSpace</div>
        </div>
        
        <div class="profile-container">
            <div class="profile-icon">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Profile" class="w-full h-full object-cover">
            </div>
            
            <div class="nav-icons">
                <div class="nav-icon">
                    <i class="fas fa-home"></i>
                </div>
                <div class="nav-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="nav-icon">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container">
        <!-- Checkout Title -->
        <h1 class="checkout-title">Checkout</h1>
        
        <!-- Flash Messages -->
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif
        
        <!-- Checkout Content -->
        <form id="checkoutForm" method="POST" action="{{ route('client.card.processPayment') }}" onsubmit="return validateAllFields()">
            @csrf
            <div class="checkout-container">
                <!-- Left Side - Shipping Address -->
                <div class="checkout-section">
                    <h2 class="section-title">
                        <i class="fas fa-shipping-fast"></i>
                        Shipping address
                    </h2>
                    <div class="input-group">
                        <label class="input-label">Full name</label>
                        <input type="text" placeholder="Enter your full name" class="input-field" id="fullName" name="fullName">
                        <i class="fas fa-user input-icon"></i>
                        <span class="error-message text-red-500 text-xs mt-1" id="fullName-error"></span>
                    </div>
                    <div class="input-group">
                        <label class="input-label">Address</label>
                        <input type="text" placeholder="Enter your address" class="input-field" id="address" name="address">
                        <i class="fas fa-home input-icon"></i>
                        <span class="error-message text-red-500 text-xs mt-1" id="address-error"></span>
                    </div>
                    <div class="input-group">
                        <label class="input-label">City</label>
                        <input type="text" placeholder="Enter your city" class="input-field" id="city" name="city">
                        <i class="fas fa-city input-icon"></i>
                        <span class="error-message text-red-500 text-xs mt-1" id="city-error"></span>
                    </div>
                    <div class="input-group">
                        <label class="input-label">Zip code</label>
                        <input type="text" placeholder="Enter your zip code" class="input-field" id="zipCode" name="zipCode">
                        <i class="fas fa-map-marker-alt input-icon"></i>
                        <span class="error-message text-red-500 text-xs mt-1" id="zipCode-error"></span>
                    </div>
                </div>
                <!-- Right Side - Payment Information -->
                <div class="checkout-section">
                    <h2 class="section-title">
                        <i class="fas fa-credit-card"></i>
                        Payment
                    </h2>
                    <div class="card-icons">
                        <div class="card-icon active" data-card="visa">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="h-full">
                        </div>
                        <div class="card-icon" data-card="mastercard">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="h-full">
                        </div>
                    </div>
                    <div class="card-details">
                        <div class="input-group">
                            <label class="input-label">Card number</label>
                            <input type="text" placeholder="1234 5678 9565 5555" class="input-field" id="cardNumber" name="cardNumber">
                            <i class="fas fa-credit-card input-icon"></i>
                            <span class="error-message text-red-500 text-xs mt-1" id="cardNumber-error"></span>
                        </div>
                        <div class="input-group">
                            <label class="input-label">Card holder</label>
                            <input type="text" placeholder="Enter card holder name" class="input-field" id="cardHolder" name="cardHolder">
                            <i class="fas fa-user input-icon"></i>
                            <span class="error-message text-red-500 text-xs mt-1" id="cardHolder-error"></span>
                        </div>
                        <div class="card-row">
                            <div class="input-group w-1/2 pr-2">
                                <label class="input-label">Expiry date</label>
                                <input type="text" placeholder="MM/YY" class="input-field" id="expiryDate" name="expiryDate" maxlength="5">
                                <i class="fas fa-calendar input-icon"></i>
                                <span class="error-message text-red-500 text-xs mt-1" id="expiryDate-error"></span>
                            </div>
                            <div class="input-group w-1/2 pl-2">
                                <label class="input-label">CVV</label>
                                <input type="text" placeholder="CVV" class="input-field" id="cvv" name="cvv" maxlength="4">
                                <i class="fas fa-lock input-icon"></i>
                                <span class="error-message text-red-500 text-xs mt-1" id="cvv-error"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Order Summary -->
            <div class="order-summary">
                <h2 class="summary-title">Order Summary</h2>
                <div class="order-items">
                    @if(empty($cart))
                        <div class="text-center text-gray-500">Your cart is empty.</div>
                    @else
                        @foreach($cart as $item)
                        <div class="order-item">
                            <img src="{{$item['image']}}" alt="{{ $item['name'] }}" class="item-image">
                            <div class="item-details">
                                <div class="item-title">{{ $item['name'] }}</div>
                                <div class="item-author">{{ $item['author'] }}</div>
                            </div>
                            <div class="item-price">{{ $item['price'] * $item['quantity'] }} Dh</div>
                        </div>
                        @endforeach
                    @endif
                </div>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>{{ $subtotal }} Dh</span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>{{ $shipping }} Dh</span>
                </div>
                <div class="summary-row">
                    <span>Estimated tax (4%)</span>
                    <span>{{ $tax }} Dh</span>
                </div>
                <div class="summary-divider"></div>
                <div class="total-row">
                    <span>Total</span>
                    <span>{{ $total + $shipping }} Dh</span>
                </div>
                <button type="submit" class="place-order-btn" id="placeOrderBtn" onclick="showLoading()">
                    Place Order
                </button>
                <div class="secure-badge">
                    <i class="fas fa-lock"></i> Secure checkout
                </div>
            </div>
        </form>
    </div>
    <!-- Loading Overlay -->
    <div class="loading" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <script>
        // Function to show loading screen
        function showLoading() {
            if (validateAllFields()) {
                document.getElementById('loadingOverlay').classList.add('active');
                return true;
            }
            return false;
        }
        
        // Function to validate all fields quickly
        function validateAllFields() {
            let isValid = true;
            const requiredFields = document.querySelectorAll('.input-field');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500');
                    isValid = false;
                    
                    // Show error message if exists
                    const errorElement = document.getElementById(`${field.id}-error`);
                    if (errorElement) {
                        errorElement.textContent = 'This field is required';
                    }
                }
            });
            
            if (!isValid) {
                // Scroll to first error
                const firstError = document.querySelector('.input-field.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
                return false;
            }
            
            return true;
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Sélection des éléments
            const cardIcons = document.querySelectorAll('.card-icon');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const inputFields = document.querySelectorAll('.input-field');
            
            // Formatage automatique du numéro de carte
            const cardNumberInput = document.getElementById('cardNumber');
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 16) value = value.slice(0, 16);
                
                // Ajouter des espaces tous les 4 chiffres
                let formattedValue = '';
                for (let i = 0; i < value.length; i++) {
                    if (i > 0 && i % 4 === 0) {
                        formattedValue += ' ';
                    }
                    formattedValue += value[i];
                }
                
                e.target.value = formattedValue;
            });
            
            // Formatage automatique de la date d'expiration
            const expiryDateInput = document.getElementById('expiryDate');
            expiryDateInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) value = value.slice(0, 4);
                
                if (value.length > 2) {
                    e.target.value = value.slice(0, 2) + '/' + value.slice(2);
                } else {
                    e.target.value = value;
                }
            });

            // Gestion de la soumission du formulaire
            const checkoutForm = document.getElementById('checkoutForm');
            checkoutForm.addEventListener('submit', function(e) {
                // Empêcher la soumission par défaut
                e.preventDefault();
                
                // Ne soumettre le formulaire que si la validation passe
                if (!validateFields()) {
                    // Faire défiler jusqu'au premier champ avec une erreur
                    const firstError = document.querySelector('.input-field.border-red-500');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                } else {
                    // Afficher l'animation de chargement
                    loadingOverlay.classList.add('active');
                    
                    // Soumettre le formulaire directement (sans délai)
                    this.submit();
                }
            });
            
            // Sélection de la carte de crédit
            cardIcons.forEach(icon => {
                icon.addEventListener('click', function() {
                    // Supprimer la classe active de toutes les icônes
                    cardIcons.forEach(i => i.classList.remove('active'));
                    // Ajouter la classe active à l'icône cliquée
                    this.classList.add('active');
                });
            });
            
            // Effet de focus sur les champs de saisie
            inputFields.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Réinitialiser les messages d'erreur
            function clearErrors() {
                document.querySelectorAll('.error-message').forEach(error => {
                    error.textContent = '';
                });
                document.querySelectorAll('.input-field').forEach(input => {
                    input.classList.remove('border-red-500');
                    input.classList.remove('shake');
                });
            }
            
            // Validation avancée des champs
            function validateFields() {
                clearErrors();
                let isValid = true;
                const errorMessages = {
                    fullName: 'Please enter your full name',
                    address: 'Please enter your address',
                    city: 'Please enter your city',
                    zipCode: 'Please enter a valid zip code',
                    cardNumber: 'Please enter a valid card number',
                    cardHolder: 'Please enter the card holder name',
                    expiryDate: 'Please enter a valid expiry date (MM/YY)',
                    cvv: 'Please enter a valid security code'
                };
                
                // Validation de chaque champ
                inputFields.forEach(input => {
                    const fieldId = input.id;
                    const errorElement = document.getElementById(`${fieldId}-error`);
                    
                    if (!input.value.trim()) {
                        isValid = false;
                        input.classList.add('border-red-500');
                        input.classList.add('shake');
                        
                        if (errorElement) {
                            errorElement.textContent = errorMessages[fieldId] || 'This field is required';
                        }
                        
                        setTimeout(() => {
                            input.classList.remove('shake');
                        }, 500);
                    } else {
                        // Validations spécifiques
                        if (fieldId === 'cardNumber') {
                            // Valider que la carte a au moins 13 chiffres (sans les espaces)
                            const cardDigits = input.value.replace(/\D/g, '');
                            if (cardDigits.length < 13) {
                                isValid = false;
                                input.classList.add('border-red-500');
                                errorElement.textContent = 'Card number must have at least 13 digits';
                            }
                        } else if (fieldId === 'expiryDate') {
                            // Valider format MM/YY
                            if (!/^\d{2}\/\d{2}$/.test(input.value)) {
                                isValid = false;
                                input.classList.add('border-red-500');
                                errorElement.textContent = 'Use MM/YY format';
                            } else {
                                // Vérifier que la date n'est pas expirée
                                const [month, year] = input.value.split('/');
                                const expiryDate = new Date(2000 + parseInt(year), parseInt(month) - 1);
                                const currentDate = new Date();
                                
                                if (expiryDate < currentDate) {
                                    isValid = false;
                                    input.classList.add('border-red-500');
                                    errorElement.textContent = 'Card has expired';
                                }
                            }
                        } else if (fieldId === 'cvv') {
                            // Valider que CVV contient 3 ou 4 chiffres
                            if (!/^\d{3,4}$/.test(input.value)) {
                                isValid = false;
                                input.classList.add('border-red-500');
                                errorElement.textContent = 'CVV must be 3 or 4 digits';
                            }
                        } else if (fieldId === 'zipCode') {
                            // Validation simple du code postal (chiffres et lettres)
                            if (!/^[a-zA-Z0-9\s-]{4,10}$/.test(input.value)) {
                                isValid = false;
                                input.classList.add('border-red-500');
                                errorElement.textContent = 'Please enter a valid zip code';
                            }
                        }
                    }
                });
                
                return isValid;
            }
            
            // La gestion du bouton "Place Order" est maintenant entièrement 
            // prise en charge par l'écouteur submit du formulaire
            // Nous n'avons plus besoin d'un écouteur click séparé pour le bouton
        });
    </script>
</body>
</html>