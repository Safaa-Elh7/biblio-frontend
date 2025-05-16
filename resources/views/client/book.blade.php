<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book['titre'] ?? 'Livre' }} - Détail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/notification.css') }}">
    <style>
        /* Style du panier flottant */
        #cart-container {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 80vh;
            overflow-y: auto;
            display: none;
        }
        
        #cart-header {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            background-color: #7c2d2d;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        
        #cart-items {
            padding: 8px 0;
            max-height: 60vh;
            overflow-y: auto;
        }
        
        .cart-item {
            display: flex;
            padding: 8px 16px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .cart-item-image {
            width: 60px;
            height: 80px;
            object-fit: cover;
            margin-right: 10px;
            border-radius: 4px;
        }
        
        .cart-item-details {
            flex: 1;
        }
        
        .cart-item-title {
            font-weight: 600;
            margin-bottom: 4px;
        }
        
        .cart-item-quantity {
            display: flex;
            align-items: center;
            margin-top: 4px;
        }
        
        .cart-item-price {
            font-weight: 500;
            color: #7c2d2d;
        }
        
        #cart-footer {
            padding: 12px 16px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        
        #cart-total {
            display: flex;
            justify-content: space-between;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .checkout-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #7c2d2d;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .checkout-btn:hover {
            background-color: #6a2424;
        }
        
        .empty-cart-message {
            padding: 40px 20px;
            text-align: center;
            color: #666;
        }
        
        .empty-cart-icon {
            font-size: 40px;
            margin-bottom: 12px;
            color: #ccc;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #e6c998;
            color: #7c2d2d;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-black text-gray-900">
<div class="sidebar w-24 bg-[#7c2d2d] fixed h-full flex flex-col items-center py-6">
    <div class="profile-icon w-16 h-16 rounded-full overflow-hidden mb-6">
        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile" class="w-full h-full object-cover">
    </div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-bars"></i></div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-home"></i></div>
    <div class="sidebar-icon text-white text-2xl mb-6 relative">
        <i class="fas fa-shopping-cart" id="cart-toggle"></i>
        <span class="cart-badge" id="cart-count">0</span>
    </div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-camera"></i></div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-envelope"></i></div>
    <div class="subscribe-text text-white rotate-90 mt-auto text-sm bg-green-400 px-4 py-2 rounded">Subscribe</div>
</div>

<!-- Cart Container -->
<div id="cart-container">
    <div id="cart-header">
        <h3>Mon Panier</h3>
        <button id="close-cart" class="text-white"><i class="fas fa-times"></i></button>
    </div>
    <div id="cart-items">
        <!-- Les éléments du panier seront ajoutés ici dynamiquement -->
    </div>
    <div id="cart-footer">
        <div id="cart-total">
            <span>Total:</span>
            <span id="total-amount">0 Dh</span>
        </div>
        <a href="{{ route('client.panier.index') }}" class="checkout-btn">
            Voir le panier
        </a>
    </div>
</div>

<div class="ml-24 bg-[#e6c998] min-h-screen p-6">
    <header class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <i class="fas fa-book text-2xl text-[#7c2d2d] mr-2"></i>
            <h1 class="text-2xl font-bold text-[#7c2d2d]">MyBookSpace</h1>
        </div>
       
    </header>

    <div class="flex gap-8">
        <div class="w-1/3">
            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f" alt="{{ $book['titre'] ?? 'Livre' }}" class="w-full rounded shadow">
        </div>
        <div class="flex-1">
            <h2 class="text-4xl font-bold mb-4">{{ $book['titre'] ?? 'Titre inconnu' }}</h2>
            <div class="space-y-2 mb-6">
                <p><span class="font-semibold text-[#7c2d2d]">Catégorie:</span> {{ $book['categorie']['libelle'] ?? 'Non spécifiée' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Langue:</span> {{ $book['langue'] ?? 'Non spécifiée' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Auteur:</span> {{ $book['auteur'] ?? 'Inconnu' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Année pub:</span> {{ $book['annee_pub'] ?? 'Non indiquée' }}</p>
            </div>
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-[#7c2d2d] mb-2">Description:</h3>
                <p>{{ $book['description'] ?? 'Aucune description disponible.' }}</p>
            </div>
            <p class="text-2xl font-bold text-[#7c2d2d] mb-6">Prix: {{ $book['prix_emprunt'] ?? '---' }} Dh</p>
            <div class="flex gap-4">
                <button id="add-to-cart-btn" 
                    data-id="{{ $book['id'] ?? '' }}"
                    data-name="{{ $book['titre'] ?? '' }}"
                    data-price="{{ $book['prix_emprunt'] ?? '' }}"
                    data-image="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}"
                    class="bg-[#7c2d2d] text-white rounded-full px-6 py-2 text-lg font-semibold">
                    Emprunter
                </button>
                <button id="download-btn"
                    data-id="{{ $book['id'] ?? '' }}"
                    data-name="{{ $book['titre'] ?? '' }}"
                    data-price="{{ $book['prix_emprunt'] ?? '' }}"
                    data-image="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}"
                    class="bg-gray-700 text-white rounded-full px-6 py-2 text-lg font-semibold">
                    <i class="fas fa-download mr-2"></i>Télécharger
                </button>
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
        <div class="notification-title">Ajouté au panier</div>
        <div class="notification-message" id="notification-message">Le livre a été ajouté à votre panier</div>
    </div>
    <button class="notification-close" id="notification-close"><i class="fas fa-times"></i></button>
    <div class="notification-progress">
        <div class="notification-progress-bar"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
$(document).ready(function() {
    // Variables globales pour le panier
    let cart = {};
    let cartCount = 0;
    let cartTotal = 0;
    
    // Charger le panier existant depuis la session
    loadCartFromSession();
    
    // Gestion de l'affichage du panier
    $('#cart-toggle').click(function() {
        $('#cart-container').toggle();
    });
    
    $('#close-cart').click(function() {
        $('#cart-container').hide();
    });
    
    // Ajouter au panier avec le bouton Emprunter
    $('#add-to-cart-btn').click(function() {
        const bookData = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            price: $(this).data('price'),
            image: $(this).data('image'),
            quantity: 1
        };
        
        addToCart(bookData);
    });
    
    // Ajouter au panier avec le bouton Télécharger
    $('#download-btn').click(function() {
        const bookData = {
            id: $(this).data('id'),
            name: $(this).data('name'),
            price: $(this).data('price'),
            image: $(this).data('image'),
            quantity: 1
        };
        
        addToCart(bookData);
    });
    
    // Fonction pour ajouter un livre au panier
    function addToCart(bookData) {
        // Appel AJAX pour ajouter au panier côté serveur
        $.ajax({
            url: '{{ route("client.panier.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: bookData.id,
                name: bookData.name,
                price: bookData.price,
                image: bookData.image
            },
            success: function(response) {
                // Mettre à jour le panier côté client
                cart = response.cart; // Récupérer le panier mis à jour depuis la réponse
                
                updateCartUI();
                
                // Afficher le panier s'il n'est pas déjà visible
                $('#cart-container').show();
                
                // Animation de feedback
                animateCartIcon();
                
                // Afficher une notification
                showNotification(`${bookData.name} a été ajouté à votre panier`);
            },
            error: function(error) {
                console.error('Erreur lors de l\'ajout au panier:', error);
                alert('Une erreur est survenue lors de l\'ajout au panier');
            }
        });
    }
    
    // Fonction pour afficher une notification
    function showNotification(message) {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notification-message');
        const notificationClose = document.getElementById('notification-close');
        
        // Mettre à jour le message
        notificationMessage.textContent = message;
        
        // Afficher la notification
        notification.classList.add('show');
        
        // Configurer un timer pour faire disparaître la notification
        const notificationTimeout = setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
        
        // Fermer la notification lorsqu'on clique sur le bouton de fermeture
        notificationClose.addEventListener('click', () => {
            clearTimeout(notificationTimeout);
            notification.classList.remove('show');
        });
    }
    
    // Fonction pour charger le panier depuis la session
    function loadCartFromSession() {
        $.ajax({
            url: '{{ route("client.panier.getCart") }}',
            method: 'GET',
            success: function(response) {
                if (response.cart) {
                    cart = response.cart;
                    updateCartUI();
                }
            },
            error: function(error) {
                console.error('Erreur lors du chargement du panier:', error);
            }
        });
    }
    
    // Fonction pour mettre à jour l'interface du panier
    function updateCartUI() {
        cartCount = 0;
        cartTotal = 0;
        
        // Vider le conteneur des éléments du panier
        $('#cart-items').empty();
        
        // Si le panier est vide, afficher un message
        if (Object.keys(cart).length === 0) {
            $('#cart-items').html(`
                <div class="empty-cart-message">
                    <div class="empty-cart-icon"><i class="fas fa-shopping-cart"></i></div>
                    <p>Votre panier est vide</p>
                </div>
            `);
        } else {
            // Ajouter chaque article au panier
            for (const id in cart) {
                const item = cart[id];
                cartCount += item.quantity;
                cartTotal += item.quantity * item.price;
                
                $('#cart-items').append(`
                    <div class="cart-item" data-id="${id}">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-title">${item.name}</div>
                            <div class="cart-item-price">${item.price} Dh</div>
                            <div class="cart-item-quantity">
                                Quantité: ${item.quantity}
                            </div>
                        </div>
                    </div>
                `);
            }
        }
        
        // Mettre à jour le badge du panier et le total
        $('#cart-count').text(cartCount);
        $('#total-amount').text(cartTotal.toFixed(2) + ' Dh');
        
        // Afficher/masquer le badge selon que le panier est vide ou non
        if (cartCount > 0) {
            $('#cart-count').show();
        } else {
            $('#cart-count').hide();
        }
    }
    
    // Animation du badge du panier
    function animateCartIcon() {
        $('#cart-count').addClass('animate-bounce');
        setTimeout(function() {
            $('#cart-count').removeClass('animate-bounce');
        }, 1000);
    }
});
</script>
</body>
</html>
