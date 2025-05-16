<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book['titre'] ?? 'Livre' }} - Détail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Style pour le message de notification */
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
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0);
            }
        }
    </style>
</head>

<body class="bg-black text-gray-900">
    <div class="sidebar w-24 bg-[#7c2d2d] fixed h-full flex flex-col items-center py-6">
        <div class="profile-icon w-16 h-16 rounded-full overflow-hidden mb-6">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile"
                class="w-full h-full object-cover">
        </div>
        <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-bars"></i></div>
        <div class="sidebar-icon text-white text-2xl mb-6"><a href="{{ route('client.home') }}"><i
                    class="fas fa-home"></i></a></div>
        <div class="sidebar-icon text-white text-2xl mb-6 relative">
            <a href="{{ route('client.panier.index') }}"><i class="fas fa-shopping-cart"></i></a>
            @if(session()->has('cart') && count(session('cart')) > 0)
                <span
                    class="absolute -top-1 -right-1 bg-[#e6c998] text-[#7c2d2d] rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">
                    {{ count(session('cart')) }}
                </span>
            @endif
        </div>
        <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-camera"></i></div>
        <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-envelope"></i></div>
        <div class="subscribe-text text-white rotate-90 mt-auto text-sm bg-green-400 px-4 py-2 rounded">Subscribe</div>
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
                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f"
                    alt="{{ $book['titre'] ?? 'Livre' }}" class="w-full rounded shadow">
            </div>
            <div class="flex-1">
                <h2 class="text-4xl font-bold mb-4">{{ $book['titre'] ?? 'Titre inconnu' }}</h2>
                <div class="space-y-2 mb-6">
                    <p><span class="font-semibold text-[#7c2d2d]">Catégorie:</span>
                        {{ $book['categorie']['libelle'] ?? 'Non spécifiée' }}</p>
                    <p><span class="font-semibold text-[#7c2d2d]">Langue:</span>
                        {{ $book['langue'] ?? 'Non spécifiée' }}</p>
                    <p><span class="font-semibold text-[#7c2d2d]">Auteur:</span> {{ $book['auteur'] ?? 'Inconnu' }}</p>
                    <p><span class="font-semibold text-[#7c2d2d]">Année pub:</span>
                        {{ $book['annee_pub'] ?? 'Non indiquée' }}</p>
                </div>
                <div class="mb-6">
                    <h3 class="text-xl font-semibold text-[#7c2d2d] mb-2">Description:</h3>
                    <p>{{ $book['description'] ?? 'Aucune description disponible.' }}</p>
                </div>
                <p class="text-2xl font-bold text-[#7c2d2d] mb-6">Prix: {{ $book['prix_emprunt'] ?? '---' }} Dh</p>
                <div class="flex gap-4">
                    <form method="POST" action="{{ route('client.panier.add') }}" id="emprunt-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book['id_article'] ?? '' }}">
                        <input type="hidden" name="name" value="{{ $book['titre'] ?? '' }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="price" value="{{ $book['prix_emprunt'] ?? '' }}">
                        <input type="hidden" name="image"
                            value="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}">
                        <input type="hidden" name="author" value="{{ $book['auteur'] ?? 'Non spécifié' }}">
                        <button type="submit"
                            class="bg-[#7c2d2d] text-white rounded-full px-6 py-2 text-lg font-semibold">Emprunter</button>
                    </form>
                    <form method="POST" action="{{ route('client.panier.add') }}" id="download-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book['id_article'] ?? '' }}">
                        <input type="hidden" name="name" value="{{ $book['titre'] ?? '' }}">
                        <input type="hidden" name="quantity" value="1">
                        <input type="hidden" name="price" value="{{ $book['prix_emprunt'] ?? '' }}">
                        <input type="hidden" name="image"
                            value="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}">
                        <input type="hidden" name="author" value="{{ $book['auteur'] ?? 'Non spécifié' }}">
                        <button type="submit"
                            class="bg-gray-700 text-white rounded-full px-6 py-2 text-lg font-semibold"><i
                                class="fas fa-download mr-2"></i>Télécharger</button>
                    </form>
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

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Afficher la notification
                const notification = document.getElementById('notification');
                const notificationMessage = document.getElementById('notification-message');
                const notificationClose = document.getElementById('notification-close');

                // Mettre à jour le message
                notificationMessage.textContent = "{{ session('success') }}";

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
            });
        </script>
    @endif

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des formulaires d'ajout au panier
        const empruntForm = document.getElementById('emprunt-form');
        const downloadForm = document.getElementById('download-form');
        
        // Animation et feedback visuel pour le bouton Emprunter
        if (empruntForm) {
            empruntForm.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                
                // Changer l'apparence du bouton pendant le chargement
                if (button) {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Ajout en cours...';
                    button.disabled = true;
                    button.classList.add('opacity-75');
                    
                    // Rétablir le bouton après 2 secondes si la page ne se recharge pas
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.classList.remove('opacity-75');
                    }, 2000);
                }
            });
        }
        
        // Animation et feedback visuel pour le bouton Télécharger
        if (downloadForm) {
            downloadForm.addEventListener('submit', function(e) {
                const button = this.querySelector('button');
                
                // Changer l'apparence du bouton pendant le chargement
                if (button) {
                    const originalText = button.innerHTML;
                    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Ajout en cours...';
                    button.disabled = true;
                    button.classList.add('opacity-75');
                    
                    // Rétablir le bouton après 2 secondes si la page ne se recharge pas
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                        button.classList.remove('opacity-75');
                    }, 2000);
                }
            });
        }
        
        // Afficher la notification si un message de succès existe
        @if(session('success'))
            showNotification("{{ session('success') }}");
        @endif
        
        // Fonction pour afficher une notification
        function showNotification(message) {
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