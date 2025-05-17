<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Livreur - MyBookSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .bg-red-800 {
            background-color: #9b2c2c;
        }

        .hover\:bg-red-900:hover {
            background-color: #742a2a;
        }

        .focus\:ring-red-800:focus {
            --tw-ring-color: rgba(155, 44, 44, 0.5);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .overflow-x-auto {
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .logout-text {
                display: none;
            }
        }

        .selected-row {
            background-color: #f3f4f6;
        }
        
        .logout-btn {
            background-color: #9b2c2c;
            color: white;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-left: 0.75rem;
        }
        
        .logout-btn:hover {
            background-color: #742a2a;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .logout-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(155, 44, 44, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="rounded-full mr-3">
            <h1 class="text-2xl font-bold text-gray-800">MyBookSpace</h1>
        </div>
        <div class="flex items-center">
            <div class="relative mr-4">
                <input type="text" placeholder="Rechercher..." class="border rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-800 w-64">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-3 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <div class="bg-red-800 p-2 rounded-md cursor-pointer hover:bg-red-900 transition-colors mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <!-- Bouton de déconnexion -->
            <button class="logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="logout-text">Déconnexion</span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <!-- Total Livraisons -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-gray-500 text-sm">Total Livraisons</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['total_livraisons'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Livraisons en cours -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-gray-500 text-sm">En cours</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['livraisons_en_cours'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Livraisons terminées -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-gray-500 text-sm">Terminées</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ $stats['livraisons_terminees'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Note moyenne -->
            <div class="bg-white rounded-lg shadow-md p-4">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-gray-500 text-sm">Note moyenne</h3>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($stats['note_moyenne'], 2) }}/5</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Livreur Info Card -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Information du Livreur</h2>
                <div>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="disponibiliteToggle" class="sr-only peer" @if($livreur->disponibilite) checked @endif>
                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-800"></div>
                        <span class="ml-3 text-sm font-medium text-gray-900">Disponible pour livraison</span>
                    </label>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div id="livreurInfoCard" class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-4">
                        <h3 class="text-md font-semibold text-gray-700">Informations Personnelles</h3>
                        <p class="text-sm mt-1"><span class="font-medium">Nom complet:</span> <span id="livreurFullName">{{ $livreur->fullName() }}</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Email:</span> <span id="livreurEmail">{{ $livreur->user->email ?? 'N/A' }}</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Téléphone:</span> <span id="livreurPhone">{{ $livreur->user->telephone ?? 'N/A' }}</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Adresse:</span> <span id="livreurAddress">{{ $livreur->user->adresse ?? 'N/A' }}</span></p>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="mb-4">
                        <h3 class="text-md font-semibold text-gray-700">Informations de Livraison</h3>
                        <p class="text-sm mt-1"><span class="font-medium">Zone de livraison:</span> <span id="livreurZone">{{ $livreur->zone_livraison ?? 'N/A' }}</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Moyen de transport:</span> <span id="livreurTransport">{{ $livreur->moyen_transport ?? 'N/A' }}</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Note:</span> <span id="livreurRating">{{ $livreur->rating ?? '0.00' }}/5</span></p>
                        <p class="text-sm mt-1"><span class="font-medium">Livraisons effectuées:</span> <span id="livreurTotalDeliveries">{{ $stats['total_livraisons'] ?? 0 }}</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Gestion des Livraisons</h2>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Liste des Livraisons</h3>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white" id="deliveryTable">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Commande</th>
                                <th class="py-3 px-6 text-left">Client</th>
                                <th class="py-3 px-6 text-left">Adresse</th>
                                <th class="py-3 px-6 text-left">Date de livraison prévue</th>
                                <th class="py-3 px-6 text-center">État</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm" id="deliveryTableBody">
                            <!-- Table rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="flex mt-6 gap-2">
                    <button id="markDeliveredBtn" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Marquer comme livré
                    </button>
                    <button id="editBtn" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </button>
                    <button id="deleteBtn" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Récupérer les livraisons du livreur connecté
        const deliveries = @json($livraisons ?? []);

        // DOM elements
        const tableBody = document.getElementById('deliveryTableBody');
        const markDeliveredBtn = document.getElementById('markDeliveredBtn');
        const editBtn = document.getElementById('editBtn');
        const deleteBtn = document.getElementById('deleteBtn');
        
        let selectedDeliveryId = null;

        // Function to get status badge HTML
        function getStatusBadge(status) {
            let badgeClass = '';
            let statusText = '';

            switch (status) {
                case 'en-cours':
                    badgeClass = 'bg-yellow-100 text-yellow-800';
                    statusText = 'En cours';
                    break;
                case 'livre':
                    badgeClass = 'bg-green-100 text-green-800';
                    statusText = 'Livré';
                    break;
                case 'non-livre':
                    badgeClass = 'bg-red-100 text-red-800';
                    statusText = 'Non livré';
                    break;
                default:
                    badgeClass = 'bg-gray-100 text-gray-800';
                    statusText = 'Inconnu';
            }

            return `<span class="${badgeClass} py-1 px-3 rounded-full text-xs">${statusText}</span>`;
        }

        // Function to render deliveries
        function renderDeliveries() {
            tableBody.innerHTML = '';
            
            if (deliveries && deliveries.length > 0) {
                deliveries.forEach(delivery => {
                    const row = document.createElement('tr');
                    row.className = `border-b border-gray-200 hover:bg-gray-50 cursor-pointer ${selectedDeliveryId === delivery.id_livraison ? 'selected-row' : ''}`;
                    row.dataset.id = delivery.id_livraison;
                    
                    // Formatage de la date de livraison prévue
                    const dateLivraison = delivery.date_livraison_prevue ? new Date(delivery.date_livraison_prevue).toLocaleDateString('fr-FR') : 'Non définie';
                    
                    // Récupérer les informations de commande et client
                    const commandeId = delivery.id_commande || 'N/A';
                    const client = delivery.client ? `${delivery.client.nom} ${delivery.client.prenom}` : 'Client inconnu';
                    const adresse = delivery.adresse_livraison || (delivery.client ? delivery.client.adresse : 'Adresse inconnue');
                    
                    row.innerHTML = `
                        <td class="py-3 px-6 text-left">CMD-${commandeId}</td>
                        <td class="py-3 px-6 text-left">${client}</td>
                        <td class="py-3 px-6 text-left">${adresse}</td>
                        <td class="py-3 px-6 text-left">${dateLivraison}</td>
                        <td class="py-3 px-6 text-center">${getStatusBadge(delivery.statut)}</td>
                    `;
                    
                    row.addEventListener('click', () => selectDelivery(delivery.id_livraison));
                    tableBody.appendChild(row);
                });
            } else {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" class="py-4 px-6 text-center text-gray-500">Aucune livraison disponible</td>
                `;
                tableBody.appendChild(row);
            }
        }

        // Function to select a delivery
        function selectDelivery(id) {
            selectedDeliveryId = id;
            renderDeliveries();
            updateButtonStates();
        }

        // Function to update button states
        function updateButtonStates() {
            const isSelected = selectedDeliveryId !== null;
            const selectedDelivery = deliveries.find(d => d.id_livraison === selectedDeliveryId);
            const isDelivered = selectedDelivery && selectedDelivery.statut === 'livré';
            
            // Enable/disable buttons based on selection
            if (isSelected) {
                markDeliveredBtn.disabled = isDelivered;
                markDeliveredBtn.classList.toggle('opacity-50', isDelivered);
                markDeliveredBtn.classList.toggle('cursor-not-allowed', isDelivered);
                
                editBtn.disabled = false;
                editBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                deleteBtn.disabled = false;
                deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                markDeliveredBtn.disabled = true;
                markDeliveredBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                editBtn.disabled = true;
                editBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                deleteBtn.disabled = true;
                deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Function to mark a delivery as delivered
        function markAsDelivered() {
            if (selectedDeliveryId) {
                // Appel API pour mettre à jour le statut de la livraison
                fetch(`/api/livraisons/${selectedDeliveryId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        statut: 'livré'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mise à jour locale
                        const index = deliveries.findIndex(d => d.id_livraison === selectedDeliveryId);
                        if (index !== -1) {
                            deliveries[index].statut = 'livré';
                            renderDeliveries();
                            updateButtonStates();
                            alert('Livraison marquée comme livrée avec succès');
                        }
                    } else {
                        alert('Erreur lors de la mise à jour du statut');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la mise à jour du statut');
                });
            }
        }

        // Function to delete a delivery
        function deleteDelivery() {
            if (selectedDeliveryId && confirm('Êtes-vous sûr de vouloir supprimer cette livraison ?')) {
                // Appel API pour supprimer la livraison
                fetch(`/api/livraisons/${selectedDeliveryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mise à jour locale
                        const index = deliveries.findIndex(d => d.id_livraison === selectedDeliveryId);
                        if (index !== -1) {
                            deliveries.splice(index, 1);
                            selectedDeliveryId = null;
                            renderDeliveries();
                            updateButtonStates();
                            alert('Livraison supprimée avec succès');
                        }
                    } else {
                        alert('Erreur lors de la suppression de la livraison');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la suppression de la livraison');
                });
            }
        }

        // Event listeners for buttons
        markDeliveredBtn.addEventListener('click', markAsDelivered);
        deleteBtn.addEventListener('click', deleteDelivery);
        
        // Gestion de la disponibilité du livreur
        const disponibiliteToggle = document.getElementById('disponibiliteToggle');
        disponibiliteToggle.addEventListener('change', function() {
            const disponibilite = this.checked;
            
            // Appel AJAX pour mettre à jour la disponibilité
            fetch("{{ route('livreur.update.disponibilite') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id_livreur: {{ $livreur->id_livreur }},
                    disponibilite: disponibilite
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Afficher une notification de succès
                    alert('Votre disponibilité a été mise à jour');
                } else {
                    // En cas d'erreur
                    alert('Erreur lors de la mise à jour de votre disponibilité');
                    disponibiliteToggle.checked = !disponibilite; // Remettre dans l'état précédent
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour de votre disponibilité');
                disponibiliteToggle.checked = !disponibilite; // Remettre dans l'état précédent
            });
        });

        // Fonction pour charger les données du livreur depuis l'API
        function loadLivreurDetails() {
            fetch("{{ route('livreur.details', ['id' => $livreur->id_livreur]) }}")
            .then(response => response.json())
            .then(data => {
                if (data.livreur) {
                    // Mettre à jour les informations du livreur dans l'interface
                    document.getElementById('livreurFullName').textContent = data.fullName;
                    document.getElementById('livreurEmail').textContent = data.email;
                    document.getElementById('livreurPhone').textContent = data.telephone;
                    document.getElementById('livreurAddress').textContent = data.adresse;
                    document.getElementById('livreurZone').textContent = data.livreur.zone_livraison || 'N/A';
                    document.getElementById('livreurTransport').textContent = data.livreur.moyen_transport || 'N/A';
                    document.getElementById('livreurRating').textContent = (data.livreur.rating || '0.00') + '/5';
                    document.getElementById('livreurTotalDeliveries').textContent = data.totalLivraisons;
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des données du livreur:', error);
            });
        }

        // Ajouter un événement pour le bouton de déconnexion
        document.querySelector('.logout-btn').addEventListener('click', function() {
            // Rediriger vers la page de déconnexion
            window.location.href = "{{ route('logout') }}";
        });

        // Charger les détails du livreur au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            loadLivreurDetails();
        });

        // Initial render
        renderDeliveries();
        updateButtonStates();
    </script>
</body>
</html>