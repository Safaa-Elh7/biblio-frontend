<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Gestion des Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Custom styles pour correspondre au design */
        .sidebar-gradient {
            background: linear-gradient(135deg, #8B2635 0%, #A53545 100%);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
        }
        .status-pending { background-color: #FEF3C7; color: #D97706; }
        .status-processing { background-color: #DBEAFE; color: #2563EB; }
        .status-completed { background-color: #D1FAE5; color: #059669; }
        .status-cancelled { background-color: #FEE2E2; color: #DC2626; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 sidebar-gradient text-white">
            <div class="p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-white rounded-full p-2">
                        <i class="fas fa-book text-red-600"></i>
                    </div>
                    <span class="text-xl font-bold">MyBookSpace</span>
                </div>
            </div>
            
            <nav class="mt-6">
                <a href="#" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    Accueil
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-truck mr-3"></i>
                    Livreurs
                </a>
                <a href="#" class="flex items-center px-6 py-3 bg-red-700 text-white">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Orders
                </a>
                <a href="#" class="flex items-center px-6 py-3 text-red-200 hover:bg-red-700 transition-colors">
                    <i class="fas fa-book mr-3"></i>
                    Articles
                </a>
            </nav>
            
            <div class="absolute bottom-0 w-64 p-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-red-700 rounded-full p-2">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <span class="text-sm">elansarisal@gmail.com</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h1 class="text-2xl font-semibold text-gray-800">Gestion des Commandes</h1>
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <input type="text" placeholder="Rechercher..." 
                                   class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                        <div class="relative">
                            <button class="bg-red-600 text-white p-2 rounded-full">
                                <i class="fas fa-bell"></i>
                            </button>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="p-6 overflow-y-auto h-full">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Commandes</p>
                                <p class="text-2xl font-bold text-gray-900">156</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-shopping-cart text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">En Cours</p>
                                <p class="text-2xl font-bold text-blue-600">42</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="fas fa-clock text-blue-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Complétées</p>
                                <p class="text-2xl font-bold text-green-600">98</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-check-circle text-green-600"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Revenus Total</p>
                                <p class="text-2xl font-bold text-green-600">€12,450</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="fas fa-euro-sign text-green-600"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-800">Liste des Commandes</h2>
                            
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Commande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode de Paiement</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody" class="bg-white divide-y divide-gray-200">
                                <!-- Les données seront injectées par JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-3 border-t border-gray-200 text-sm text-gray-500">
                        <span id="paginationInfo">Affichage de 1 à 10 sur 45 entrées</span>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Modal de détails de commande -->
    <div id="orderDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-10 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-2/3 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between pb-3 border-b">
                    <h3 class="text-xl font-semibold text-gray-900">Détails de la Commande</h3>
                    <button onclick="closeOrderDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div id="orderDetailsContent" class="mt-4">
                    <!-- Le contenu sera injecté par JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Données simulées pour les commandes
        let orders = [
            {
                id: 1,
                order_number: 'ORD-2024-001',
                full_name: 'Jean Dupont',
                email: 'jean.dupont@email.com',
                address: '123 Rue de la Paix',
                city: 'Paris',
                zip_code: '75001',
                payment_method: 'carte',
                card_last_four: '4242',
                status: 'completed',
                subtotal: 45.90,
                tax: 9.18,
                total: 55.08,
                created_at: '2024-03-15T10:30:00Z',
                items: [
                    { name: 'Le Petit Prince', price: 15.90, quantity: 1 },
                    { name: '1984 by Orwell', price: 30.00, quantity: 1 }
                ]
            },
            {
                id: 2,
                order_number: 'ORD-2024-002',
                full_name: 'Marie Martin',
                email: 'marie.martin@email.com',
                address: '456 Avenue des Champs',
                city: 'Lyon',
                zip_code: '69001',
                payment_method: 'paypal',
                card_last_four: null,
                status: 'processing',
                subtotal: 25.00,
                tax: 5.00,
                total: 30.00,
                created_at: '2024-03-14T14:15:00Z',
                items: [
                    { name: 'Harry Potter', price: 25.00, quantity: 1 }
                ]
            },
            {
                id: 3,
                order_number: 'ORD-2024-003',
                full_name: 'Pierre Durand',
                email: 'pierre.durand@email.com',
                address: '789 Boulevard Saint-Germain',
                city: 'Marseille',
                zip_code: '13001',
                payment_method: 'carte',
                card_last_four: '1234',
                status: 'pending',
                subtotal: 67.80,
                tax: 13.56,
                total: 81.36,
                created_at: '2024-03-13T09:45:00Z',
                items: [
                    { name: 'Game of Thrones Set', price: 67.80, quantity: 1 }
                ]
            },
            {
                id: 4,
                order_number: 'ORD-2024-004',
                full_name: 'Sophie Lebrun',
                email: 'sophie.lebrun@email.com',
                address: '321 Rue Victor Hugo',
                city: 'Toulouse',
                zip_code: '31000',
                payment_method: 'virement',
                card_last_four: null,
                status: 'cancelled',
                subtotal: 89.90,
                tax: 17.98,
                total: 107.88,
                created_at: '2024-03-12T16:20:00Z',
                items: [
                    { name: 'Encyclopédie Universalis', price: 89.90, quantity: 1 }
                ]
            },
            {
                id: 5,
                order_number: 'ORD-2024-005',
                full_name: 'Antoine Moreau',
                email: 'antoine.moreau@email.com',
                address: '654 Place de la République',
                city: 'Nice',
                zip_code: '06000',
                payment_method: 'carte',
                card_last_four: '5678',
                status: 'completed',
                subtotal: 34.50,
                tax: 6.90,
                total: 41.40,
                created_at: '2024-03-11T11:10:00Z',
                items: [
                    { name: 'Les Misérables', price: 18.50, quantity: 1 },
                    { name: 'Notre-Dame de Paris', price: 16.00, quantity: 1 }
                ]
            }
        ];

        // Variables globales
        let currentEditId = null;

        // Fonctions utilitaires
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('fr-FR') + ' ' + date.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
        }

        function getStatusClass(status) {
            switch(status) {
                case 'pending': return 'status-pending';
                case 'processing': return 'status-processing';
                case 'completed': return 'status-completed';
                case 'cancelled': return 'status-cancelled';
                default: return 'status-pending';
            }
        }

        function getStatusText(status) {
            switch(status) {
                case 'pending': return 'En Attente';
                case 'processing': return 'En Cours';
                case 'completed': return 'Complété';
                case 'cancelled': return 'Annulé';
                default: return status;
            }
        }

        function getPaymentMethodText(method) {
            switch(method) {
                case 'carte': return 'Carte Bancaire';
                case 'paypal': return 'PayPal';
                case 'virement': return 'Virement';
                case 'especes': return 'Espèces';
                default: return method;
            }
        }

        // Fonction pour calculer le total automatiquement
        function calculateTotal() {
            const subtotal = parseFloat(document.getElementById('subtotal').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const total = subtotal + tax;
            document.getElementById('total').value = total.toFixed(2);
        }

        // Event listeners pour le calcul automatique
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('subtotal').addEventListener('input', calculateTotal);
            document.getElementById('tax').addEventListener('input', calculateTotal);
        });

        // Fonction pour afficher les commandes
        function renderOrders() {
            const tbody = document.getElementById('ordersTableBody');
            tbody.innerHTML = '';

            orders.forEach(order => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${order.order_number}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${order.full_name}</div>
                            <div class="text-sm text-gray-500">${order.email}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            €${order.total.toFixed(2)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge ${getStatusClass(order.status)}">
                                ${getStatusText(order.status)}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${getPaymentMethodText(order.payment_method)}
                            ${order.card_last_four ? ` ****${order.card_last_four}` : ''}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${formatDate(order.created_at)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <button onclick="viewOrder(${order.id})" 
                                    class="text-blue-600 hover:text-blue-900" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>

                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }


        function closeOrderDetailsModal() {
            document.getElementById('orderDetailsModal').classList.add('hidden');
        }

        // Fonction pour voir une commande
        function viewOrder(id) {
            const order = orders.find(o => o.id === id);
            if (!order) return;

            const itemsHtml = order.items.map(item => `
                <tr>
                    <td class="px-4 py-2 border-b">${item.name}</td>
                    <td class="px-4 py-2 border-b text-center">${item.quantity}</td>
                    <td class="px-4 py-2 border-b text-right">€${item.price.toFixed(2)}</td>
                    <td class="px-4 py-2 border-b text-right">€${(item.price * item.quantity).toFixed(2)}</td>
                </tr>
            `).join('');

            const content = `
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Informations de la Commande</h4>
                        <div class="space-y-2">
                            <p><span class="font-medium">N° Commande:</span> ${order.order_number}</p>
                            <p><span class="font-medium">Statut:</span> 
                                <span class="status-badge ${getStatusClass(order.status)}">${getStatusText(order.status)}</span>
                            </p>
                            <p><span class="font-medium">Date:</span> ${formatDate(order.created_at)}</p>
                            <p><span class="font-medium">Méthode de Paiement:</span> ${getPaymentMethodText(order.payment_method)}
                                ${order.card_last_four ? ` ****${order.card_last_four}` : ''}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold mb-3">Informations Client</h4>
                        <div class="space-y-2">
                            <p><span class="font-medium">Nom:</span> ${order.full_name}</p>
                            <p><span class="font-medium">Email:</span> ${order.email}</p>
                            <p><span class="font-medium">Adresse:</span> ${order.address}</p>
                            <p><span class="font-medium">Ville:</span> ${order.city}, ${order.zip_code}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-3">Articles Commandés</h4>
                    <table class="w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 border-b text-left">Article</th>
                                <th class="px-4 py-2 border-b text-center">Quantité</th>
                                <th class="px-4 py-2 border-b text-right">Prix Unitaire</th>
                                <th class="px-4 py-2 border-b text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${itemsHtml}
                        </tbody>
                    </table>
                    
                    <div class="mt-4 bg-gray-50 p-4 rounded">
                        <div class="flex justify-between items-center mb-2">
                            <span>Sous-total:</span>
                            <span>€${order.subtotal.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span>Taxes:</span>
                            <span>€${order.tax.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between items-center text-lg font-bold border-t pt-2">
                            <span>Total:</span>
                            <span>€${order.total.toFixed(2)}</span>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('orderDetailsContent').innerHTML = content;
            document.getElementById('orderDetailsModal').classList.remove('hidden');
        }

        // Fonction pour mettre à jour les statistiques
        function updateStats() {
            const totalOrders = orders.length;
            const processingOrders = orders.filter(o => o.status === 'processing').length;
            const completedOrders = orders.filter(o => o.status === 'completed').length;
            const totalRevenue = orders.filter(o => o.status === 'completed')
                                       .reduce((sum, order) => sum + order.total, 0);

            // Mettre à jour les cartes de statistiques
            document.querySelector('.grid .bg-white:nth-child(1) .text-2xl').textContent = totalOrders;
            document.querySelector('.grid .bg-white:nth-child(2) .text-2xl').textContent = processingOrders;
            document.querySelector('.grid .bg-white:nth-child(3) .text-2xl').textContent = completedOrders;
            document.querySelector('.grid .bg-white:nth-child(4) .text-2xl').textContent = `€${totalRevenue.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ',')}`;
        }

        // Fonction de recherche
        function searchOrders(searchTerm) {
            if (!searchTerm) {
                renderOrders();
                return;
            }

            const filteredOrders = orders.filter(order => 
                order.order_number.toLowerCase().includes(searchTerm.toLowerCase()) ||
                order.full_name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                order.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
                order.status.toLowerCase().includes(searchTerm.toLowerCase())
            );

            const tbody = document.getElementById('ordersTableBody');
            tbody.innerHTML = '';

            filteredOrders.forEach(order => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${order.order_number}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${order.full_name}</div>
                            <div class="text-sm text-gray-500">${order.email}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            €${order.total.toFixed(2)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge ${getStatusClass(order.status)}">
                                ${getStatusText(order.status)}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${getPaymentMethodText(order.payment_method)}
                            ${order.card_last_four ? ` ****${order.card_last_four}` : ''}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${formatDate(order.created_at)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="viewOrder(${order.id})" 
                                    class="text-blue-600 hover:text-blue-900" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Event listener pour la barre de recherche
        document.querySelector('input[placeholder="Rechercher..."]').addEventListener('input', function(e) {
            searchOrders(e.target.value);
        });

        // Fonction pour filtrer par statut
        function filterByStatus(status) {
            const filteredOrders = status === 'all' ? orders : orders.filter(order => order.status === status);
            
            const tbody = document.getElementById('ordersTableBody');
            tbody.innerHTML = '';

            filteredOrders.forEach(order => {
                const row = `
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            ${order.order_number}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">${order.full_name}</div>
                            <div class="text-sm text-gray-500">${order.email}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            €${order.total.toFixed(2)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge ${getStatusClass(order.status)}">
                                ${getStatusText(order.status)}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            ${getPaymentMethodText(order.payment_method)}
                            ${order.card_last_four ? ` ****${order.card_last_four}` : ''}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${formatDate(order.created_at)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <button onclick="viewOrder(${order.id})" 
                                    class="text-blue-600 hover:text-blue-900" title="Voir">
                                <i class="fas fa-eye"></i>
                            </button>

                           
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        // Ajout des boutons de filtrage
        document.addEventListener('DOMContentLoaded', function() {
            // Ajouter des boutons de filtrage après le titre
            const tableHeader = document.querySelector('.bg-white.rounded-lg.shadow .p-6.border-b');
            const filterButtons = `
                <div class="flex space-x-2 mt-4">
                    <button onclick="filterByStatus('all')" 
                            class="px-3 py-1 text-sm bg-gray-200 text-gray-700 rounded hover:bg-gray-300 active-filter">
                        Tous
                    </button>
                    <button onclick="filterByStatus('pending')" 
                            class="px-3 py-1 text-sm bg-yellow-100 text-yellow-800 rounded hover:bg-yellow-200">
                        En Attente
                    </button>
                    <button onclick="filterByStatus('processing')" 
                            class="px-3 py-1 text-sm bg-blue-100 text-blue-800 rounded hover:bg-blue-200">
                        En Cours
                    </button>
                    <button onclick="filterByStatus('completed')" 
                            class="px-3 py-1 text-sm bg-green-100 text-green-800 rounded hover:bg-green-200">
                        Complétées
                    </button>
                    <button onclick="filterByStatus('cancelled')" 
                            class="px-3 py-1 text-sm bg-red-100 text-red-800 rounded hover:bg-red-200">
                        Annulées
                    </button>
                </div>
            `;
            tableHeader.innerHTML += filterButtons;

            // Initialiser l'affichage
            renderOrders();
            updateStats();
        });

        // Fonction pour exporter les commandes en CSV
        function exportToCSV() {
            const headers = ['N° Commande', 'Client', 'Email', 'Total', 'Statut', 'Méthode de Paiement', 'Date'];
            const csvContent = [
                headers.join(','),
                ...orders.map(order => [
                    order.order_number,
                    `"${order.full_name}"`,
                    order.email,
                    order.total.toFixed(2),
                    getStatusText(order.status),
                    getPaymentMethodText(order.payment_method),
                    formatDate(order.created_at)
                ].join(','))
            ].join('\n');

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `commandes_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Ajout du bouton d'export
        document.addEventListener('DOMContentLoaded', function() {
            const exportButton = document.createElement('button');
            exportButton.onclick = exportToCSV;
            exportButton.className = 'bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors ml-2';
            exportButton.innerHTML = '<i class="fas fa-download mr-2"></i>Exporter CSV';

        });

        // Gestion des clics pour fermer les modals quand on clique en dehors
        window.onclick = function(event) {
            const orderDetailsModal = document.getElementById('orderDetailsModal');

            if (event.target === orderDetailsModal) {
                closeOrderDetailsModal();
            }
        };

        // Gestion des raccourcis clavier
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeOrderDetailsModal();
            }
        });
    </script>
</body>
</html>