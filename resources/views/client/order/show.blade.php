<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la commande #{{ $order->order_number }} - MyBookSpace</title>
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
            background-image: linear-gradient(to bottom, #8e3a3a, #7c2d2d, #6a2424);
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
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .order-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }
        
        .status-badge {
            display: inline-block;
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
        
        .divider {
            height: 1px;
            background-color: #e2d3af;
            margin: 1.5rem 0;
        }
        
        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #7c2d2d;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 0.5rem;
        }
        
        .info-label {
            width: 150px;
            font-weight: 500;
            color: #6e6e6e;
        }
        
        .info-value {
            flex: 1;
            font-weight: 500;
        }
        
        .item-row {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #e2d3af;
        }
        
        .item-row:last-child {
            border-bottom: none;
        }
        
        .item-image {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 0.5rem;
            margin-right: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .item-row:hover .item-image {
            transform: scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .item-details {
            flex: 1;
        }
        
        .item-title {
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
            color: #2d2d2d;
            transition: color 0.3s ease;
        }
        
        .item-row:hover .item-title {
            color: #7c2d2d;
        }
        
        .item-price {
            font-size: 0.875rem;
            color: #6e6e6e;
        }
        
        .item-quantity {
            font-weight: 600;
            margin-right: 1.5rem;
            background-color: #f0e7d1;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            color: #7c2d2d;
        }
        
        .item-total {
            font-weight: 700;
            font-size: 1.125rem;
            color: #7c2d2d;
            width: 100px;
            text-align: right;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            font-size: 1rem;
        }
        
        .total-row.final {
            font-weight: 700;
            font-size: 1.25rem;
            color: #7c2d2d;
        }
        
        .back-btn {
            background-color: transparent;
            border: 2px solid #7c2d2d;
            color: #7c2d2d;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 2rem;
            text-decoration: none;
        }
        
        .back-btn:hover {
            background-color: #7c2d2d;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 45, 45, 0.3);
        }
        
        .print-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-left: 1rem;
            margin-top: 2rem;
            text-decoration: none;
            border: 2px solid #7c2d2d;
        }
        
        .print-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(124, 45, 45, 0.3);
        }
        
        /* Styles pour l'impression */
        @media print {
            .sidebar, .back-btn, .print-btn {
                display: none;
            }
            
            .main-container {
                margin-left: 0;
                padding: 0;
            }
            
            .order-card {
                box-shadow: none;
                padding: 0;
            }
            
            body {
                background-color: white;
                color: black;
            }
            
            .page-title::after {
                display: none;
            }
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
        <a href="{{ route('client.order.history') }}" class="text-white text-xl mb-6"><i class="fas fa-history"></i></a>
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
        </header>
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="page-title">Détails de la commande</h1>
            
            @if($order->status == 'pending')
                <span class="status-badge status-pending">En attente</span>
            @elseif($order->status == 'processing')
                <span class="status-badge status-processing">En traitement</span>
            @elseif($order->status == 'completed')
                <span class="status-badge status-completed">Terminée</span>
            @elseif($order->status == 'cancelled')
                <span class="status-badge status-cancelled">Annulée</span>
            @endif
        </div>
        
        <div class="order-card">
            <div class="flex justify-between mb-2">
                <h2 class="text-xl font-bold text-sidebar">Commande #{{ $order->order_number }}</h2>
                <p class="text-gray-600">Passée le {{ $order->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            
            <div class="divider"></div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                <!-- Informations de livraison -->
                <div>
                    <h3 class="section-title">Informations de livraison</h3>
                    
                    <div class="info-row">
                        <div class="info-label">Nom complet</div>
                        <div class="info-value">{{ $order->full_name }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Adresse</div>
                        <div class="info-value">{{ $order->address }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Ville</div>
                        <div class="info-value">{{ $order->city }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Code postal</div>
                        <div class="info-value">{{ $order->zip_code }}</div>
                    </div>
                </div>
                
                <!-- Informations de paiement -->
                <div>
                    <h3 class="section-title">Informations de paiement</h3>
                    
                    <div class="info-row">
                        <div class="info-label">Méthode</div>
                        <div class="info-value">
                            @if($order->payment_method == 'card')
                                <i class="far fa-credit-card mr-2"></i> Carte de crédit
                                @if($order->card_last_four)
                                    (se terminant par {{ $order->card_last_four }})
                                @endif
                            @else
                                {{ ucfirst($order->payment_method) }}
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Statut</div>
                        <div class="info-value">
                            @if($order->status == 'pending')
                                <span class="status-badge status-pending">En attente</span>
                            @elseif($order->status == 'processing')
                                <span class="status-badge status-processing">En traitement</span>
                            @elseif($order->status == 'completed')
                                <span class="status-badge status-completed">Terminée</span>
                            @elseif($order->status == 'cancelled')
                                <span class="status-badge status-cancelled">Annulée</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="divider"></div>
            
            <!-- Articles commandés -->
            <h3 class="section-title">Articles commandés</h3>
            
            <div class="space-y-2">
                @foreach($order->items as $item)
                    <div class="item-row">
                        <img src="{{$item['image']}}" alt="{{ $item->name }}" class="item-image">
                        
                        <div class="item-details">
                            <div class="item-title">{{ $item->name }}</div>
                            <div class="item-price">{{ $item->price }} Dh par livre</div>
                        </div>
                        
                        <div class="item-quantity">x{{ $item->quantity }}</div>
                        
                        <div class="item-total">{{ $item->price * $item->quantity }} Dh</div>
                    </div>
                @endforeach
            </div>
            
            <div class="divider"></div>
            
            <!-- Récapitulatif des prix -->
            <div class="w-full max-w-md ml-auto">
                <div class="total-row">
                    <div>Sous-total</div>
                    <div>{{ $order->subtotal }} Dh</div>
                </div>
                
                <div class="total-row">
                    <div>TVA (4%)</div>
                    <div>{{ $order->tax }} Dh</div>
                </div>
                
                <div class="divider"></div>
                
                <div class="total-row final">
                    <div>Total</div>
                    <div>{{ $order->total }} Dh</div>
                </div>
            </div>
        </div>
        
        <div class="flex">
            <a href="{{ route('client.order.history') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Retour aux commandes
            </a>
            
            <button onclick="window.print()" class="print-btn">
                <i class="fas fa-print"></i> Imprimer le reçu
            </button>
        </div>
    </div>
    
    <script>
        // Script pour l'impression du reçu
        function printReceipt() {
            window.print();
        }
    </script>
</body>
</html>