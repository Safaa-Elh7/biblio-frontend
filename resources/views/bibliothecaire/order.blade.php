@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Commandes</h1>
    </div>

    <!-- Table des Commandes -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livreur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="ordersTableBody">
                <!-- Les données seront chargées dynamiquement ici -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour Détails de la Commande -->
<div id="orderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900">Détails de la Commande</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="orderDetails" class="mt-4 space-y-6">
                <!-- Les détails de la commande seront chargés dynamiquement ici -->
            </div>
            <div class="mt-6 pt-4 border-t">
                <button onclick="closeModal()" class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
                    Fermer
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fonctions pour gérer les commandes
function loadOrders() {
    fetch('/orders')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('ordersTableBody');
            tbody.innerHTML = '';
            data.forEach(order => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${order.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${order.client_nom}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${new Date(order.date_commande).toLocaleDateString()}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${order.total} €</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full ${getStatusClass(order.statut)}">
                                ${order.statut}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${order.livreur_nom || 'Non assigné'}</td>
                        <td class="px-6 py-4 whitespace-nowrap space-x-2">
                            <button onclick="viewOrderDetails(${order.id})" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button onclick="updateOrderStatus(${order.id})" class="text-green-600 hover:text-green-900">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteOrder(${order.id})" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function getStatusClass(status) {
    switch(status.toLowerCase()) {
        case 'en attente':
            return 'bg-yellow-100 text-yellow-800';
        case 'en cours':
            return 'bg-blue-100 text-blue-800';
        case 'livrée':
            return 'bg-green-100 text-green-800';
        case 'annulée':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

function viewOrderDetails(id) {
    fetch(`/orders/${id}`)
        .then(response => response.json())
        .then(data => {
            const details = document.getElementById('orderDetails');
            details.innerHTML = `
                <div class="space-y-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Informations Client</h4>
                        <div class="space-y-2">
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-user mr-2"></i>
                                <span>${data.client_nom}</span>
                            </p>
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-envelope mr-2"></i>
                                <span>${data.client_email}</span>
                            </p>
                            <p class="flex items-center text-gray-700">
                                <i class="fas fa-phone mr-2"></i>
                                <span>${data.client_telephone}</span>
                            </p>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Articles</h4>
                        <div class="space-y-3">
                            ${data.articles.map(article => `
                                <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm">
                                    <div>
                                        <p class="font-medium text-gray-900">${article.titre}</p>
                                        <p class="text-sm text-gray-500">${article.quantite} x ${article.prix} €</p>
                                    </div>
                                    <p class="font-semibold text-gray-900">${(article.quantite * article.prix).toFixed(2)} €</p>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between items-center">
                            <h4 class="text-lg font-semibold text-gray-900">Total</h4>
                            <p class="text-xl font-bold text-primary">${data.total} €</p>
                        </div>
                    </div>
                </div>
            `;
            document.getElementById('orderModal').classList.remove('hidden');
        })
        .catch(error => console.error('Erreur:', error));
}

function closeModal() {
    document.getElementById('orderModal').classList.add('hidden');
}

function updateOrderStatus(id) {
    const statuses = ['en attente', 'en cours', 'livrée', 'annulée'];
    const currentStatus = document.querySelector(`tr[data-order-id="${id}"] .status-badge`).textContent.trim();
    const currentIndex = statuses.indexOf(currentStatus);
    const nextStatus = statuses[(currentIndex + 1) % statuses.length];

    if (confirm(`Voulez-vous changer le statut de la commande en "${nextStatus}" ?`)) {
        fetch(`/orders/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ statut: nextStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadOrders();
            } else {
                alert('Erreur lors de la mise à jour: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

function deleteOrder(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')) {
        fetch(`/orders/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadOrders();
            } else {
                alert('Erreur lors de la suppression: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

// Charger les commandes au chargement de la page
document.addEventListener('DOMContentLoaded', loadOrders);
</script>
@endpush
@endsection 