@extends('layouts.bibliothecaire')

@section('title', 'Édition d\'un article')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1>Édition de l'article</h1>
            <a href="{{ route('bibliothecaire.article.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5>Informations de l'article #{{ $article['id_article'] ?? $article['id'] }}</h5>
        </div>
        <div class="card-body">
            <form id="editArticleForm" method="POST" action="{{ route('articles.update', $article['id_article'] ?? $article['id']) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre*</label>
                            <input type="text" class="form-control" id="titre" name="titre" value="{{ $article['titre'] }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="auteur" class="form-label">Auteur</label>
                            <input type="text" class="form-control" id="auteur" name="auteur" value="{{ $article['auteur'] }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="annee_pub" class="form-label">Année de publication</label>
                            <input type="number" class="form-control" id="annee_pub" name="annee_pub" value="{{ $article['annee_pub'] }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="qte" class="form-label">Quantité disponible*</label>
                            <input type="number" class="form-control" id="qte" name="qte" value="{{ $article['qte'] }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="prix_emprunt" class="form-label">Prix d'emprunt*</label>
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control" id="prix_emprunt" name="prix_emprunt" value="{{ $article['prix_emprunt'] }}" required>
                                <span class="input-group-text">MAD</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="langue" class="form-label">Langue</label>
                            <input type="text" class="form-control" id="langue" name="langue" value="{{ $article['langue'] }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="id_categorie" class="form-label">Catégorie</label>
                            <select class="form-select" id="id_categorie" name="id_categorie">
                                <option value="">Sélectionner une catégorie</option>
                                <!-- Les options de catégorie seront chargées dynamiquement via JS -->
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4">{{ $article['description'] }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <div class="form-text">Format recommandé : JPG, PNG ou WEBP, max 2MB</div>
                    </div>
                    <div class="col-md-6">
                        @if(isset($article['image']) && $article['image'])
                        <div class="mt-3">
                            <p>Image actuelle :</p>
                            <img src="{{ asset('storage/' . $article['image']) }}" alt="{{ $article['titre'] }}" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour charger les catégories
    function loadCategories() {
        fetch('/api/categories')
            .then(response => response.json())
            .then(data => {
                const select = document.getElementById('id_categorie');
                data.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id_categorie;
                    option.textContent = category.nom_categorie;
                    option.selected = category.id_categorie == {{ $article['id_categorie'] ?? 'null' }};
                    select.appendChild(option);
                });
            })
            .catch(error => console.error('Erreur lors du chargement des catégories:', error));
    }

    // Charger les catégories au chargement de la page
    loadCategories();

    // Gestion de la soumission du formulaire
    document.getElementById('editArticleForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST', // Le formulaire utilise POST même si la méthode est PUT (via @method)
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message || 'Article mis à jour avec succès');
                window.location.href = "{{ route('bibliothecaire.article.index') }}";
            } else {
                alert(data.message || 'Une erreur est survenue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour');
        });
    });
});
</script>
@endpush
@endsection
