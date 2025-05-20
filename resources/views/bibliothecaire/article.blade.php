@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestion des Articles</h1>
        <button onclick="openAddModal()" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded transition duration-200">
            <i class="fas fa-plus mr-2"></i>Ajouter un Article
        </button>
    </div>

    <!-- Table des Articles -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="articlesTableBody">
                <!-- Les données seront chargées dynamiquement ici -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal pour Ajouter/Modifier un Article -->
<div id="articleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center pb-3 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">Ajouter un Article</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="articleForm" class="mt-4 space-y-4" enctype="multipart/form-data">
                <input type="hidden" id="articleId">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="titre">Titre</label>
                    <input type="text" id="titre" name="titre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="auteur">Auteur</label>
                    <input type="text" id="auteur" name="auteur" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="description">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="prix">Prix</label>
                        <div class="relative">
                            <input type="number" id="prix" name="prix" step="0.01" class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            <span class="absolute left-3 top-2 text-gray-500">€</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="image">Image</label>
                    <div class="mt-1 flex items-center">
                        <input type="file" id="image" name="image" class="hidden" accept="image/*">
                        <label for="image" class="cursor-pointer bg-white px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                            <i class="fas fa-upload mr-2"></i>Choisir une image
                        </label>
                        <span id="imageName" class="ml-3 text-sm text-gray-500"></span>
                    </div>
                    <div id="currentImage" class="mt-2 hidden">
                        <img src="" alt="Image actuelle" class="w-32 h-32 object-cover rounded-lg shadow">
                    </div>
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
// Fonctions pour gérer les articles
function loadArticles() {
    fetch('/articles')
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('articlesTableBody');
            tbody.innerHTML = '';
            data.forEach(article => {
                tbody.innerHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="/storage/${article.image}" alt="${article.titre}" class="w-16 h-16 object-cover rounded">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.titre}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.auteur}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.prix} €</td>
                        <td class="px-6 py-4 whitespace-nowrap">${article.stock}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button onclick="editArticle(${article.id_article})" class="text-blue-600 hover:text-blue-900 mr-3">Modifier</button>
                            <button onclick="deleteArticle(${article.id_article})" class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Erreur:', error));
}

function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Ajouter un Article';
    document.getElementById('articleForm').reset();
    document.getElementById('articleId').value = '';
    document.getElementById('currentImage').classList.add('hidden');
    document.getElementById('articleModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('articleModal').classList.add('hidden');
}

function editArticle(id) {
    fetch(`/api/articles/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = 'Modifier un Article';
            document.getElementById('articleId').value = data.id_article;
            document.getElementById('titre').value = data.titre;
            document.getElementById('auteur').value = data.auteur;
            document.getElementById('description').value = data.description;
            document.getElementById('prix').value = data.prix;
            document.getElementById('stock').value = data.stock;
            
            // Afficher l'image actuelle
            const currentImage = document.getElementById('currentImage');
            const img = currentImage.querySelector('img');
            img.src = `/storage/${data.image}`;
            currentImage.classList.remove('hidden');
            
            document.getElementById('articleModal').classList.remove('hidden');
        })
        .catch(error => console.error('Erreur:', error));
}

function deleteArticle(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        fetch(`/articles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadArticles();
            } else {
                alert('Erreur lors de la suppression: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur:', error));
    }
}

document.getElementById('articleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('articleId').value;
    const formData = new FormData(this);

    const url = id ? `/articles/${id}` : '/articles';
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeModal();
            loadArticles();
        } else {
            alert('Erreur: ' + data.message);
        }
    })
    .catch(error => console.error('Erreur:', error));
});

// Charger les articles au chargement de la page
document.addEventListener('DOMContentLoaded', loadArticles);
</script>
@endpush
@endsection