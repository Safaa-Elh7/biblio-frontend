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
        }

        .selected-row {
            background-color: #f3f4f6;
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
            <div class="bg-red-800 p-2 rounded-md cursor-pointer hover:bg-red-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
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
        // Sample data for deliveries
        const deliveries = [
            {
                id: "CMD-001",
                client: "Ahmed Benali",
                address: "123 Rue Hassan II, Casablanca",
                date: "15/05/2023",
                status: "en-cours"
            },
            {
                id: "CMD-002",
                client: "Fatima Zahra",
                address: "45 Avenue Mohammed V, Rabat",
                date: "16/05/2023",
                status: "livre"
            },
            {
                id: "CMD-003",
                client: "Karim Idrissi",
                address: "78 Rue Ibn Sina, Marrakech",
                date: "14/05/2023",
                status: "non-livre"
            },
            {
                id: "CMD-004",
                client: "Nadia Tazi",
                address: "12 Boulevard Zerktouni, Casablanca",
                date: "17/05/2023",
                status: "en-cours"
            },
            {
                id: "CMD-005",
                client: "Youssef Alami",
                address: "56 Rue Moulay Ismail, Tanger",
                date: "13/05/2023",
                status: "livre"
            }
        ];

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
            
            deliveries.forEach(delivery => {
                const row = document.createElement('tr');
                row.className = `border-b border-gray-200 hover:bg-gray-50 cursor-pointer ${selectedDeliveryId === delivery.id ? 'selected-row' : ''}`;
                row.dataset.id = delivery.id;
                
                row.innerHTML = `
                    <td class="py-3 px-6 text-left">${delivery.id}</td>
                    <td class="py-3 px-6 text-left">${delivery.client}</td>
                    <td class="py-3 px-6 text-left">${delivery.address}</td>
                    <td class="py-3 px-6 text-left">${delivery.date}</td>
                    <td class="py-3 px-6 text-center">${getStatusBadge(delivery.status)}</td>
                `;
                
                row.addEventListener('click', () => selectDelivery(delivery.id));
                tableBody.appendChild(row);
            });
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
            const selectedDelivery = deliveries.find(d => d.id === selectedDeliveryId);
            const isDelivered = selectedDelivery && selectedDelivery.status === 'livre';
            
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
                const index = deliveries.findIndex(d => d.id === selectedDeliveryId);
                if (index !== -1) {
                    deliveries[index].status = 'livre';
                    renderDeliveries();
                    updateButtonStates();
                }
            }
        }

        // Function to delete a delivery
        function deleteDelivery() {
            if (selectedDeliveryId) {
                const index = deliveries.findIndex(d => d.id === selectedDeliveryId);
                if (index !== -1) {
                    deliveries.splice(index, 1);
                    selectedDeliveryId = null;
                    renderDeliveries();
                    updateButtonStates();
                }
            }
        }

        // Event listeners for buttons
        markDeliveredBtn.addEventListener('click', markAsDelivered);
        deleteBtn.addEventListener('click', deleteDelivery);

        // Initial render
        renderDeliveries();
        updateButtonStates();
    </script>
</body>
</html>