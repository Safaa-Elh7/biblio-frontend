<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande confirmée - MyBookSpace</title>
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
        
        .success-icon {
            font-size: 5rem;
            color: #10B981;
            margin-bottom: 1.5rem;
        }
        
        .order-card {
            background-color: #f8e7c9;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
        
        .divider {
            height: 1px;
            background-color: #e2d3af;
            margin: 1.5rem 0;
        }
        
        .btn {
            display: inline-block;
            background-color: #7c2d2d;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 45, 45, 0.3);
        }
        
        .btn-outline {
            background-color: transparent;
            border: 2px solid #7c2d2d;
            color: #7c2d2d;
        }
        
        .btn-outline:hover {
            background-color: #7c2d2d;
            color: white;
        }
        
        .confetti {
            position: fixed;
            width: 10px;
            height: 10px;
            background-color: #f0f;
            border-radius: 50%;
            animation: fall linear forwards;
        }
        
        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="max-w-4xl mx-auto pt-10 pb-20 px-4">
        <div class="order-card text-center mb-8">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-[#7c2d2d] mb-4">Merci pour votre commande!</h1>
            
            <p class="text-lg text-gray-600 mb-6">
                Votre commande #{{ $order->order_number }} a été confirmée et est en cours de préparation.
            </p>
            
            <div class="divider"></div>
            
            <div class="text-left mb-6">
                <h2 class="text-xl font-semibold mb-3">Détails de la commande</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600 mb-1">Date de la commande:</p>
                        <p class="font-medium">{{ $order->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-gray-600 mb-1">Statut:</p>
                        <p class="font-medium">
                            @if($order->status == 'completed')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Complétée
                                </span>
                            @elseif($order->status == 'processing')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-sync-alt mr-1"></i> En traitement
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-1"></i> En attente
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-gray-600 mb-1">Méthode de paiement:</p>
                        <p class="font-medium">
                            @if($order->payment_method == 'card')
                                <span class="inline-flex items-center">
                                    <i class="far fa-credit-card mr-1"></i> 
                                    Carte de crédit (se terminant par {{ $order->card_last_four }})
                                </span>
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <p class="text-gray-600 mb-1">Total:</p>
                        <p class="font-bold text-lg">{{ $order->total }} Dh</p>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <div class="text-left mb-6">
                <h2 class="text-xl font-semibold mb-3">Adresse de livraison</h2>
                
                <address class="not-italic">
                    <p class="font-medium">{{ $order->full_name }}</p>
                    <p>{{ $order->address }}</p>
                    <p>{{ $order->city }}, {{ $order->zip_code }}</p>
                </address>
            </div>
            
            <div class="divider"></div>
            
            <div class="text-left mb-6">
                <h2 class="text-xl font-semibold mb-3">Récapitulatif de la commande</h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center">
                            <div class="w-16 h-20 bg-white rounded overflow-hidden mr-4">
                                <img src="{{ !empty($item->image) ? (filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('storage/' . $item->image)) : 'https://via.placeholder.com/80x100?text=Livre' }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="font-medium">{{ $item->name }}</h3>
                                <p class="text-sm text-gray-600">Quantité: {{ $item->quantity }}</p>
                            </div>
                            
                            <div class="font-medium">
                                {{ $item->price * $item->quantity }} Dh
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-6 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Sous-total:</span>
                        <span>{{ $order->subtotal }} Dh</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">TVA (4%):</span>
                        <span>{{ $order->tax }} Dh</span>
                    </div>
                    
                    <div class="divider my-3"></div>
                    
                    <div class="flex justify-between font-bold">
                        <span>Total:</span>
                        <span>{{ $order->total }} Dh</span>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            <div class="text-left mb-6">
                <h2 class="text-xl font-semibold mb-3">Date de retour</h2>
                <p class="font-medium">
                    {{ $order->return_date ? $order->return_date->format('d/m/Y') : '-' }}
                </p>
            </div>
            <div class="divider"></div>
            
            <div class="flex flex-col md:flex-row justify-center gap-4 mt-6">
                <a href="{{ route('client.home') }}" class="btn">
                    <i class="fas fa-home mr-2"></i> Retour à l'accueil
                </a>
                <button onclick="window.print()" class="btn btn-outline">
                    <i class="fas fa-download mr-2"></i> Télécharger le reçu
                </button>
            </div>
        </div>
        
        
    </div>

    <script>
        // Effet de confettis pour célébrer la commande
        document.addEventListener('DOMContentLoaded', function() {
            createConfetti();
            
            function createConfetti() {
                const colors = ['#7c2d2d', '#e6c998', '#4ade80', '#60a5fa', '#f472b6'];
                const confettiCount = 200;
                
                for (let i = 0; i < confettiCount; i++) {
                    const confetti = document.createElement('div');
                    confetti.classList.add('confetti');
                    
                    // Position aléatoire
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = -10 + 'px';
                    
                    // Taille aléatoire
                    const size = Math.random() * 10 + 5;
                    confetti.style.width = size + 'px';
                    confetti.style.height = size + 'px';
                    
                    // Couleur aléatoire
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    
                    // Durée aléatoire
                    const duration = Math.random() * 3 + 2;
                    confetti.style.animationDuration = duration + 's';
                    
                    // Délai aléatoire
                    const delay = Math.random() * 3;
                    confetti.style.animationDelay = delay + 's';
                    
                    // Supprimer après l'animation
                    setTimeout(() => {
                        confetti.remove();
                    }, (duration + delay) * 1000);
                    
                    document.body.appendChild(confetti);
                }
            }
        });
    </script>
</body>
</html>