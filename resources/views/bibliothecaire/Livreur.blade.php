@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Livreurs</h1>
        <button onclick="openAddModal()" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded transition duration-200">
            <i class="fas fa-plus mr-2"></i>Ajouter un Livreur
        </button>
    </div>

    <!-- Table des Livreurs -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transport</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="livreursTableBody">
                <!-- Les données seront chargées dynamiquement ici -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour Ajouter/Modifier un Livreur -->
<div id="livreurModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Ajouter un Livreur</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="livreurForm" class="mt-4 space-y-4">
                <input type="hidden" id="livreurId">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="prenom">Prénom</label>
                        <input type="text" id="prenom" name="prenom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="telephone">Téléphone</label>
                    <input type="tel" id="telephone" name="telephone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="zone_livraison">Zone de Livraison</label>
                    <input type="text" id="zone_livraison" name="zone_livraison" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="moyen_transport">Moyen de Transport</label>
                    <select id="moyen_transport" name="moyen_transport" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                        <option value="">Sélectionner un moyen de transport</option>
                        <option value="Vélo">Vélo</option>
                        <option value="Scooter">Scooter</option>
                        <option value="Voiture">Voiture</option>
                        <option value="Camionnette">Camionnette</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Laissez vide pour ne pas modifier le mot de passe</p>
                </div>
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Fonctions pour gérer les livreurs
function loadLivreurs() {
    fetch('/bibliothecaire/livreurs')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('livreursTableBody');
            tbody.innerHTML = '';
            data.forEach(livreur => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">${livreur.nom} ${livreur.prenom}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${livreur.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${livreur.telephone}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${livreur.zone_livraison}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${livreur.moyen_transport}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="editLivreur(${livreur.id_livreur})" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</button>
                            <button onclick="deleteLivreur(${livreur.id_livreur})" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Ajouter un Livreur';
    document.getElementById('livreurForm').reset();
    document.getElementById('livreurId').value = '';
    document.getElementById('livreurModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('livreurModal').classList.add('hidden');
}

function editLivreur(id) {
    fetch(`/api/livreurs/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Modifier un Livreur';
            document.getElementById('livreurId').value = data.livreur.id_livreur;
            document.getElementById('nom').value = data.livreur.nom;
            document.getElementById('prenom').value = data.livreur.prenom;
            document.getElementById('email').value = data.livreur.email;
            document.getElementById('telephone').value = data.livreur.telephone;
            document.getElementById('zone_livraison').value = data.livreur.zone_livraison;
            document.getElementById('moyen_transport').value = data.livreur.moyen_transport;
            document.getElementById('password').value = '';
            document.getElementById('livreurModal').classList.remove('hidden');
        })
        .catch(error => console.error('Erreur:', error));
}

function deleteLivreur(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce livreur ?')) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadLivreurs();
            } else {
                alert('Erreur lors de la suppression: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

document.getElementById('livreurForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('livreurId').value;
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());

    const url = id ? `/bibliothecaire/livreurs/${id}` : '/bibliothecaire/livreurs';
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            loadLivreurs();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
});

// Charger les livreurs au chargement de la page
document.addEventListener('DOMContentLoaded', loadLivreurs);
</script>
@endpush
@endsection