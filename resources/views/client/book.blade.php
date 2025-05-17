<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book['titre'] ?? 'Livre' }} - Détail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        beige: {
                            light: '#e6d5b8',
                            DEFAULT: '#d9c5a0',
                            dark: '#c4b08c',
                        },
                        burgundy: {
                            light: '#8a3232',
                            DEFAULT: '#7c2d2d',
                            dark: '#5e2121',
                        }
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'Georgia', 'serif'],
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #d9c5a0;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
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
            color: #d9c5a0;
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
            background-color: #d9c5a0;
            width: 100%;
            transform-origin: left;
            animation: progress 3s linear forwards;
        }

        @keyframes progress {
            from {
                transform: scaleX(1);
            }
            to {
                transform: scaleX(0);
            }
        }

        .sidebar-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .btn-burgundy {
            background-color: #7c2d2d;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-burgundy:hover {
            background-color: #5e2121;
        }

        .book-cover {
            transition: transform 0.3s ease;
        }

        .book-cover:hover {
            transform: scale(1.02);
        }

        .book-tag {
            background-color: rgba(124, 45, 45, 0.1);
            color: #7c2d2d;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .tab-active {
            border-bottom: 2px solid #7c2d2d;
            color: #7c2d2d;
            font-weight: 600;
        }

        .tab {
            cursor: pointer;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .tab:hover:not(.tab-active) {
            color: #7c2d2d;
        }

        /* Styles responsifs */
        @media (max-width: 1024px) {
            .book-container {
                flex-direction: column;
            }
            .book-cover-container {
                width: 100% !important;
                max-width: 400px;
                margin: 0 auto 2rem;
            }
            .book-details {
                width: 100% !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 60px !important;
            }
            .main-content {
                margin-left: 60px !important;
                padding: 1rem !important;
            }

            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
        }

        .subscribe-btn {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            text-orientation: mixed;
        }
    </style>
</head>

<body class="bg-beige">
    <!-- Sidebar -->
    <div class="sidebar w-16 bg-burgundy fixed h-full flex flex-col items-center py-6 z-50">
        <!-- Profile -->
        <div class="w-10 h-10 rounded-full overflow-hidden mb-10 border-2 border-beige">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile"
                class="w-full h-full object-cover">
        </div>
        
        <!-- Navigation Icons -->
        <div class="flex flex-col items-center space-y-8">
            <a href="#" class="sidebar-icon text-white">
                <i class="fas fa-ellipsis-h"></i>
            </a>
            <a href="{{ route('client.home') }}" class="sidebar-icon text-white">
                <i class="fas fa-home"></i>
            </a>
            <a href="{{ route('client.panier.index') }}" class="sidebar-icon text-white relative">
                <i class="fas fa-shopping-cart"></i>
                @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-1 -right-1 bg-beige text-burgundy rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>
            <a href="{{ route('order.history') }}" class="sidebar-icon text-white">
                <i class="fas fa-history"></i>
            </a>
            <a href="#" class="sidebar-icon text-white">
                <i class="fas fa-comment"></i>
            </a>
        </div>
        
        <!-- Subscribe Button -->
        <div class="mt-auto mb-6">
            <button class="subscribe-btn bg-green-500 text-white px-2 py-6 rounded-md text-xs font-medium hover:bg-green-600 transition-colors">
                Subscribe
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content ml-16 p-4 md:p-6 lg:p-8">
        <div class="container mx-auto">
            <!-- Book Container -->
            <div class="book-container flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Left Column: Book Cover -->
                <div class="book-left-column w-full lg:w-1/3">
                    <!-- Book Cover -->
                    <div class="bg-white p-4 rounded-lg mt-11">
                        <img id="book-cover" src="{{$book['image']}}" alt="{{ $book['titre'] ?? 'Livre' }}" class=" w-full h-auto rounded">
                    </div>
                </div>

                <!-- Right Column: Book Details -->
                <div class="book-details w-full lg:w-2/3 mt-10">
                    <div class="flex flex-col-row items-start justify-between mb-6">

                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">{{ $book['titre'] ?? "Le Petit Prince" }}</h2>
    
                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 ">
                            <span class="book-tag">{{ $book['categorie']['libelle'] ?? 'romantic' }}</span>
                            <span class="book-tag">{{ $book['langue'] ?? 'Français' }}</span>
                            <span class="book-tag">Bestseller</span>
                        </div>
                    </div>

                    <!-- Book Info -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-burgundy mb-3">Informations</h3>
                        <div class="bg-white/50 rounded-lg p-4 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Auteur</span>
                                <span class="font-medium">{{ $book['auteur'] ?? 'Antoine de Saint-Exupéry' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Publication</span>
                                <span class="font-medium">{{ $book['annee_pub'] ?? '1943' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Éditeur</span>
                                <span class="font-medium">Éditions Gallimard</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pages</span>
                                <span class="font-medium">324</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">ISBN</span>
                                <span class="font-medium">978-2-07-123456-7</span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-burgundy mb-3">Description</h3>
                        <div class="bg-white/50 p-4 rounded-lg">
                            <p class="text-gray-700 leading-relaxed">{{ $book['description'] ?? 'Un conte philosophique pour petits et grands.' }}</p>
                        </div>
                    </div>

                    <!-- Price and Actions -->
                    <div class="bg-white/70 rounded-lg p-6 shadow-sm">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
                            <div>
                                <p class="text-gray-600 text-sm mb-1">Prix</p>
                                <p class="text-3xl font-bold text-burgundy">{{ $book['prix_emprunt'] ?? '1500' }} Dh</p>
                            </div>
                            <div class="flex items-center mt-3 md:mt-0">
                                <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Disponible
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <form method="POST" action="{{ route('client.panier.add') }}" id="emprunt-form" class="w-full">
                                @csrf
                                <input type="hidden" name="id" value="{{ $book['id_article'] ?? '' }}">
                                <input type="hidden" name="name" value="{{ $book['titre'] ?? '' }}">
                                <input type="hidden" name="quantity" value="1">
                                <input type="hidden" name="price" value="{{ $book['prix_emprunt'] ?? '' }}">
                                <input type="hidden" name="image" value="{{ !empty($book['image']) ? $book['image'] : '' }}">
                                <input type="hidden" name="author" value="{{ $book['auteur'] ?? 'Non spécifié' }}">
                                <button type="submit" class="btn-burgundy w-full py-3 rounded-lg text-lg font-semibold">Emprunter</button>
                            </form>
                        </div>
                    </div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des onglets
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Retirer la classe active de tous les onglets
                tabs.forEach(t => t.classList.remove('tab-active'));
                // Ajouter la classe active à l'onglet cliqué
                this.classList.add('tab-active');
            });
        });
        
        // Gestion du formulaire d'emprunt
        const empruntForm = document.getElementById('emprunt-form');
        if (empruntForm) {
            empruntForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Pour la démo, empêcher l'envoi réel du formulaire
                
                const button = this.querySelector('button');
                
                // Changer l'apparence du bouton pendant le chargement
                if (button) {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Ajout en cours...';
                    button.disabled = true;
                    button.classList.add('opacity-75');
                    
                    // Simuler un délai de chargement
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.classList.remove('opacity-75');
                        
                        // Afficher la notification
                        showNotification("Le livre a été ajouté à votre panier");
                    }, 1000);
                }
            });
        }
        
        // Fonction pour afficher une notification
        window.showNotification = function(message) {
            const notification = document.getElementById('notification');
            if (!notification) return;
            
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
    });
    </script>
</body>

</html>