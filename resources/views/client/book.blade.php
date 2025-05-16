<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book['titre'] ?? 'Livre' }} - Détail</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-black text-gray-900">
<div class="sidebar w-24 bg-[#7c2d2d] fixed h-full flex flex-col items-center py-6">
    <div class="profile-icon w-16 h-16 rounded-full overflow-hidden mb-6">
        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80" alt="Profile" class="w-full h-full object-cover">
    </div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-bars"></i></div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-home"></i></div>
    <div class="sidebar-icon text-white text-2xl mb-6"><i class="fas fa-shopping-cart"></i></div>
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
            <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f" alt="{{ $book['titre'] ?? 'Livre' }}" class="w-full rounded shadow">
        </div>
        <div class="flex-1">
            <h2 class="text-4xl font-bold mb-4">{{ $book['titre'] ?? 'Titre inconnu' }}</h2>
            <div class="space-y-2 mb-6">
                <p><span class="font-semibold text-[#7c2d2d]">Catégorie:</span> {{ $book['categorie']['libelle'] ?? 'Non spécifiée' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Langue:</span> {{ $book['langue'] ?? 'Non spécifiée' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Auteur:</span> {{ $book['auteur'] ?? 'Inconnu' }}</p>
                <p><span class="font-semibold text-[#7c2d2d]">Année pub:</span> {{ $book['annee_pub'] ?? 'Non indiquée' }}</p>
            </div>
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-[#7c2d2d] mb-2">Description:</h3>
                <p>{{ $book['description'] ?? 'Aucune description disponible.' }}</p>
            </div>
            <p class="text-2xl font-bold text-[#7c2d2d] mb-6">Prix: {{ $book['prix_emprunt'] ?? '---' }} Dh</p>
            <div class="flex gap-4">
                <form method="POST" action="{{ route('client.panier.add') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $book['id'] ?? '' }}">
                    <input type="hidden" name="name" value="{{ $book['titre'] ?? '' }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{ $book['prix_emprunt'] ?? '' }}">
                    <input type="hidden" name="image" value="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}">
                    <button type="submit" class="bg-[#7c2d2d] text-white rounded-full px-6 py-2 text-lg font-semibold">Emprunter</button>
                </form>
                <form method="POST" action="{{ route('client.panier.add') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $book['id'] ?? '' }}">
                    <input type="hidden" name="name" value="{{ $book['titre'] ?? '' }}">
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{ $book['prix_emprunt'] ?? '' }}">
                    <input type="hidden" name="image" value="{{ $book['image'] ?? 'https://via.placeholder.com/80x100?text=Livre' }}">
                    <button type="submit" class="bg-gray-700 text-white rounded-full px-6 py-2 text-lg font-semibold"><i class="fas fa-download mr-2"></i>Télécharger</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
