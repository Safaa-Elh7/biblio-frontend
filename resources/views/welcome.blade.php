<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Votre bibliothèque en ligne</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'beige': '#f5deb3',
                        'beige-light': '#f8e7c9',
                        'beige-dark': '#d4b785',
                        'sidebar': '#7c2d2d',
                        'sidebar-dark': '#6a2424',
                        'sidebar-light': '#8e3a3a',
                        'accent': '#c17a0f',
                        'text-dark': '#2d2d2d',
                        'text-medium': '#4a4a4a',
                        'text-light': '#6e6e6e',
                        'romantic': '#f472b6',
                        'fiction': '#86efac',
                        'manga': '#fbbf24',
                        'education': '#60a5fa',
                        'all': '#9ca3af',
                    },
                    boxShadow: {
                        'custom': '0 4px 20px rgba(0, 0, 0, 0.08)',
                        'input': '0 2px 5px rgba(0, 0, 0, 0.05)',
                        'card': '0 8px 30px rgba(0, 0, 0, 0.12)',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5deb3;
            background-image: linear-gradient(to bottom right, #f8e7c9, #f5deb3, #d4b785);
            color: #2d2d2d;
            min-height: 100vh;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        /* Styles de la sidebar */
        .sidebar {
            width: 56px;
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
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1.5rem;
            border: 2px solid #e6c998;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-icon:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }

        .sidebar-icon {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1.25rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 8px;
        }

        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .sidebar-icon.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .subscribe-btn {
            background-color: #4ade80;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transform: rotate(90deg);
            transform-origin: center;
            white-space: nowrap;
            margin-top: auto;
            font-size: 0.875rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .subscribe-btn:hover {
            transform: rotate(90deg) scale(1.05);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        /* Styles des catégories */
        .categories-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            overflow-x: auto;
            padding: 0.75rem 1.5rem;
            -ms-overflow-style: none;
            scrollbar-width: none;
            position: relative;
        }

        .categories-container::-webkit-scrollbar {
            display: none;
        }

        .categories-container::after {
            content: '';
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 50px;
            background: linear-gradient(to right, transparent, #f5deb3);
            pointer-events: none;
        }

        .category-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            min-width: 70px;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .category-item:hover {
            transform: translateY(-3px);
        }

        .category-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .category-item:hover .category-icon {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .category-text {
            font-size: 0.75rem;
            text-align: center;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .category-item:hover .category-text {
            color: #7c2d2d;
        }

        .category-item.active {
            background-color: #f8e7c9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .category-item.active .category-text {
            color: #7c2d2d;
            font-weight: 600;
        }

        /* Styles pour les livres */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #7c2d2d;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #7c2d2d;
            border-radius: 1.5px;
        }

        .view-all-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .view-all-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.5rem;
        }

        .book-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 0.75rem;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .book-card:hover {
            background-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-5px);
        }

        .book-cover {
            width: 128px;
            height: 176px;
            border-radius: 0.5rem;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 0.75rem;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .book-card:hover .book-cover {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }

        .book-title {
            font-weight: 600;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 0.25rem;
            color: #2d2d2d;
            transition: color 0.3s ease;
        }

        .book-card:hover .book-title {
            color: #7c2d2d;
        }

        .author-name {
            font-size: 0.75rem;
            font-weight: 400;
            text-align: center;
            color: #6e6e6e;
        }

        .book-badge {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            background-color: #7c2d2d;
            color: white;
            font-size: 0.625rem;
            font-weight: 600;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .book-card:hover .book-badge {
            opacity: 1;
            transform: translateY(0);
        }

        /* Styles pour la bannière */
        .banner {
            position: relative;
            border-radius: 1rem;
            overflow: hidden;
            height: 250px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .banner-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .banner:hover .banner-image {
            transform: scale(1.05);
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.3));
            display: flex;
            align-items: center;
        }

        .banner-content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            margin-left: 3rem;
            max-width: 450px;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transform: translateX(0);
            transition: all 0.3s ease;
        }

        .banner:hover .banner-content {
            transform: translateX(10px);
        }

        .banner-title {
            font-size: 2rem;
            font-weight: 700;
            color: #7c2d2d;
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .banner-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: #7c2d2d;
            border-radius: 1.5px;
        }

        .banner-text {
            font-size: 0.875rem;
            line-height: 1.5;
            color: #4a4a4a;
            margin-bottom: 1.5rem;
        }

        .banner-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            font-weight: 500;
            font-size: 0.875rem;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
            transition: all 0.3s ease;
            display: inline-block;
        }

        .banner-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }

        /* Styles pour l'en-tête */
        .header {
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo-icon {
            color: #7c2d2d;
            font-size: 1.75rem;
            margin-right: 0.75rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.75rem;
            color: #7c2d2d;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .search-container {
            position: relative;
            width: 400px;
            transition: all 0.3s ease;
        }

        .search-container:focus-within {
            transform: translateY(-2px);
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border-radius: 9999px;
            border: none;
            background-color: #f8e7c9;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .search-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: #7c2d2d;
            font-size: 1rem;
            pointer-events: none;
        }

        .search-btn {
            background-color: #7c2d2d;
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            font-weight: 500;
            box-shadow: 0 4px 10px rgba(124, 45, 45, 0.3);
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .search-btn:hover {
            background-color: #6a2424;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(124, 45, 45, 0.4);
        }

        .search-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(124, 45, 45, 0.3);
        }

        /* Animation de chargement */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            width: 120px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 0.75rem;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile-icon">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                alt="Profile" class="w-full h-full object-cover">
        </div>

        <div class="sidebar-icon">
            <i class="fas fa-bars"></i>
        </div>

        <div class="sidebar-icon active">
            <i class="fas fa-home"></i>
        </div>

        <div class="sidebar-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>

        <div class="sidebar-icon">
            <i class="fas fa-camera"></i>
        </div>

        <div class="sidebar-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <div class="subscribe-btn">
            Subscribe
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-14 p-4">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <i class="fas fa-book-open logo-icon"></i>
                <h1 class="logo-text">MyBookSpace</h1>
            </div>

            <div class="flex items-center">
                <div class="search-container mr-4">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="searchInput" placeholder="Find your next favorite book..."
                        class="search-input">
                </div>
                <button id="searchButton" class="search-btn">
                    Search
                </button>
            </div>
        </header>

        <!-- Categories -->
        <div class="categories-container scrollbar-hide">
            <div class="category-item"
                style="background-color: #7c2d2d; color: white; border-radius: 0.5rem; padding: 0.5rem;">
                <div class="category-icon" style="background-color: transparent; box-shadow: none;">
                    <i class="fas fa-book text-xl"></i>
                </div>
                <span class="category-text">Category</span>
            </div>

            <div class="category-item active" data-category="romantic">
                <div class="category-icon" style="background-color: #ec4899;">
                    <i class="fas fa-heart text-white text-lg"></i>
                </div>
                <span class="category-text">Romantic</span>
            </div>

            <div class="category-item" data-category="fiction">
                <div class="category-icon" style="background-color: #22c55e;">
                    <i class="fas fa-magic text-white text-lg"></i>
                </div>
                <span class="category-text">Fiction</span>
            </div>

            <div class="category-item" data-category="manga">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book-open text-white text-lg"></i>
                </div>
                <span class="category-text">Manga</span>
            </div>

            <div class="category-item" data-category="education">
                <div class="category-icon" style="background-color: #3b82f6;">
                    <i class="fas fa-graduation-cap text-white text-lg"></i>
                </div>
                <span class="category-text">Education</span>
            </div>

            <div class="category-item" data-category="all">
                <div class="category-icon" style="background-color: #6b7280;">
                    <i class="fas fa-th text-white text-lg"></i>
                </div>
                <span class="category-text">All</span>
            </div>

            <!-- Répétition des catégories comme dans l'image -->
            <div class="category-item" data-category="romantic">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Romantic</span>
            </div>

            <div class="category-item" data-category="fiction">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Fiction</span>
            </div>

            <div class="category-item" data-category="manga">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Manga</span>
            </div>

            <div class="category-item" data-category="education">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Education</span>
            </div>

            <div class="category-item" data-category="all">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">All</span>
            </div>

            <div class="category-item" data-category="romantic">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Romantic</span>
            </div>

            <div class="category-item" data-category="fiction">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Fiction</span>
            </div>

            <div class="category-item" data-category="manga">
                <div class="category-icon" style="background-color: #f59e0b;">
                    <i class="fas fa-book text-white text-lg"></i>
                </div>
                <span class="category-text">Manga</span>
            </div>
        </div>

        <!-- Popular Section -->
        <div class="mb-12">
            <div class="section-header">
                <h2 class="section-title">Popular</h2>
                <button class="view-all-btn">
                    View all
                </button>
            </div>

            <div class="book-grid" id="popularBooks">
                <!-- Les livres seront ajoutés dynamiquement par JavaScript -->
            </div>
        </div>

        <!-- Best of Today Section -->
        <div class="banner mb-12">
            <img src="https://images.unsplash.com/photo-1474366521946-c3d4b507abf2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80"
                alt="Best of Today" class="banner-image">
            <div class="banner-overlay">
                <div class="banner-content">
                    <h2 class="banner-title">BEST OF TODAY</h2>
                    <p class="banner-text">
                        Explore the literary highlights of 2023 with our '50 Most Popular Bestsellers' badge—a curated
                        collection of the year's must-reads.
                    </p>
                    <a href="#" class="banner-btn">
                        View out
                    </a>
                </div>
            </div>
        </div>

        <!-- Best Seller Section -->
        <div class="mb-12">
            <div class="section-header">
                <h2 class="section-title">Best Seller</h2>
                <button class="view-all-btn">
                    View all
                </button>
            </div>

            <div class="book-grid" id="bestSellerBooks">
                <!-- Les livres seront ajoutés dynamiquement par JavaScript -->
            </div>
        </div>
    </div>

   <script>
    // Fonction pour gérer la visibilité de la bannière "Best of Today"
function updateBannerVisibility() {
    const searchTerm = document.getElementById('searchInput').value.trim();
    const activeCategory = document.querySelector('.category-item.active');
    const categoryType = activeCategory ? activeCategory.dataset.category : 'all';
    const banner = document.querySelector('.banner');
    
    // Masquer la bannière si la recherche n'est pas vide OU si la catégorie n'est pas "all"
    if (searchTerm !== '' || (categoryType !== 'all' && categoryType !== undefined)) {
        banner.style.display = 'none';
    } else {
        banner.style.display = 'block';
    }
}

// Supprimer le tableau books statique
let books = [];

// Fonction pour sécuriser l'accès aux propriétés
function getBookProperty(book, property, defaultValue = "Non disponible") {
    if (book && book[property] !== undefined && book[property] !== null) {
        return book[property];
    } else {
        return defaultValue;
    }
}

// Fonction pour charger les livres depuis l'API
function loadBooks() {
    fetch("http://localhost:8081/api/articles")
        .then(res => {
            if (!res.ok) {
                throw new Error("Erreur réseau lors de la récupération des articles");
            }
            return res.json();
        })
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                // Remplir books avec les données récupérées
                books = data.map(book => ({
                    id: getBookProperty(book, 'id', Math.random().toString(36).substr(2, 9)),
                    title: getBookProperty(book, 'titre', 'Titre inconnu'),
                    author: getBookProperty(book, 'auteur', 'Auteur inconnu'),
                    category: getBookProperty(book, 'category', 'all'),
                    cover: getBookProperty(book, 'image', 'https://images.unsplash.com/photo-1598618253208-d75408cee680?q=80&w=1000&auto=format&fit=crop'),
                    prix_emprunt: getBookProperty(book, 'prix_emprunt', 0),
                    isBestSeller: book.prix_emprunt > 100 || getBookProperty(book, 'isBestSeller', false)
                }));

                console.log('Livres chargés avec succès:', books.length);

                // Afficher les livres après le chargement
                displayBooks("popularBooks", books);
                displayBooks("bestSellerBooks", books.filter(book => book.isBestSeller));
                
                // Afficher un message de confirmation
                showToast(`${books.length} livres chargés avec succès`);
            } else {
                console.warn("Aucun livre n'a été renvoyé par l'API ou format invalide");
                showToast("Aucun livre disponible pour le moment");
            }
        })
        .catch(err => {
            console.error("Erreur lors du chargement des articles :", err);
            showToast("Impossible de charger les livres. Veuillez réessayer plus tard.");
            
            // Utiliser des données de démonstration en cas d'échec
            const demoBooks = generateDemoBooks();
            books = demoBooks;
            
            // Afficher les livres de démonstration
            displayBooks("popularBooks", books);
            displayBooks("bestSellerBooks", books.filter(book => book.isBestSeller));
        });
}

// Fonction pour générer des livres de démonstration en cas d'échec de l'API
function generateDemoBooks() {
    const categories = ['romantic', 'fiction', 'manga', 'education', 'all'];
    const demoBooks = [];
    
    // Générer 12 livres de démonstration
    for (let i = 1; i <= 12; i++) {
        const category = categories[Math.floor(Math.random() * categories.length)];
        const isBestSeller = Math.random() > 0.7; // 30% de chance d'être un best-seller
        
        demoBooks.push({
            id: i,
            title: `Livre de démonstration ${i}`,
            author: `Auteur ${i}`,
            category: category,
            cover: `https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=1000&auto=format&fit=crop`,
            prix_emprunt: Math.floor(Math.random() * 200) + 50,
            isBestSeller: isBestSeller
        });
    }
    
    return demoBooks;
}

// Fonction pour afficher les livres avec animation
function displayBooks(containerId, booksToDisplay) {
    const container = document.getElementById(containerId);
    if (!container) {
        console.error(`Conteneur avec l'ID ${containerId} introuvable`);
        return;
    }
    
    container.innerHTML = '';
    
    // Vérifier si nous avons des livres à afficher
    if (!Array.isArray(booksToDisplay) || booksToDisplay.length === 0) {
        const emptyMessage = document.createElement('div');
        emptyMessage.className = 'col-span-full text-center py-8 text-text-medium';
        emptyMessage.textContent = 'Aucun livre à afficher pour cette catégorie';
        container.appendChild(emptyMessage);
        return;
    }
    
    booksToDisplay.forEach((book, index) => {
        const bookCard = document.createElement('div');
        bookCard.className = 'book-card fade-in';
        bookCard.dataset.category = getBookProperty(book, 'category', 'all');
        bookCard.style.animationDelay = `${index * 0.05}s`;
        
        const title = getBookProperty(book, 'title', 'Titre inconnu');
        const author = getBookProperty(book, 'author', 'Auteur inconnu');
        const image = getBookProperty(book, 'cover', '');
        const isBestSeller = getBookProperty(book, 'isBestSeller', false);

        
        const bestSellerBadge = isBestSeller ? `<span class="book-badge">Best Seller</span>` : '';
        
        bookCard.innerHTML = `
            <img src="${image}" alt="${title}" class="book-cover">
            <h3 class="book-title">${title}</h3>
            <span class="author-name">${author}</span>
            ${bestSellerBadge}
        `;
        
        // Ajouter un effet de clic
        bookCard.addEventListener('click', function() {
            showToast(`Vous avez sélectionné "${title}" de ${author}`);
        });
        
        container.appendChild(bookCard);
    });
}

// Filtrage par catégorie avec animation
function initCategoryFilters() {
    const categoryItems = document.querySelectorAll('.category-item');
    categoryItems.forEach(item => {
        if (!item.dataset.category) return; // Ignorer l'élément "category"

        item.addEventListener('click', () => {
            // Retirer la classe active de tous les éléments
            categoryItems.forEach(cat => cat.classList.remove('active'));

            // Ajouter la classe active à l'élément cliqué
            item.classList.add('active');

            const category = item.dataset.category;

            // Ajouter une animation au clic
            item.classList.add('animate-click');
            setTimeout(() => {
                item.classList.remove('animate-click');
            }, 300);

            // Filtrer les livres
            let filteredBooks;
            if (category === 'all') {
                filteredBooks = books;
            } else {
                filteredBooks = books.filter(book => 
                    getBookProperty(book, 'categorie', '').toLowerCase() === category.toLowerCase()
                );
            }

            // Afficher les livres filtrés dans la section Popular
            displayBooks('popularBooks', filteredBooks);

            // Filtrer les best-sellers également
            const filteredBestSellers = category === 'all'
                ? books.filter(book => getBookProperty(book, 'isBestSeller', false))
                : books.filter(book => 
                    getBookProperty(book, 'categorie', '').toLowerCase() === category.toLowerCase() && 
                    getBookProperty(book, 'isBestSeller', false)
                );

            displayBooks('bestSellerBooks', filteredBestSellers);

            // Mettre à jour la visibilité de la bannière
            updateBannerVisibility();

            // Afficher un message de confirmation
            showToast(`Affichage des livres de la catégorie: ${category}`);
        });
    });
}

// Recherche de livres avec animation
function initSearchFunctionality() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    
    if (!searchInput || !searchButton) {
        console.error("Éléments de recherche introuvables");
        return;
    }
    
    function searchBooks() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        
        if (searchTerm === '') {
            // Si la recherche est vide, afficher tous les livres
            displayBooks('popularBooks', books);
            displayBooks('bestSellerBooks', books.filter(book => 
                getBookProperty(book, 'isBestSeller', false)
            ));
            
            // Mettre à jour la visibilité de la bannière
            updateBannerVisibility();
            return;
        }
        
        // Filtrer les livres par titre ou auteur
        const filteredBooks = books.filter(book => 
            getBookProperty(book, 'title', '').toLowerCase().includes(searchTerm) || 
            getBookProperty(book, 'author', '').toLowerCase().includes(searchTerm)
        );
        
        // Afficher les résultats
        displayBooks('popularBooks', filteredBooks);
        
        // Filtrer également les best-sellers
        const filteredBestSellers = filteredBooks.filter(book => 
            getBookProperty(book, 'isBestSeller', false)
        );
        
        displayBooks('bestSellerBooks', filteredBestSellers);
        
        // Mettre à jour la visibilité de la bannière
        updateBannerVisibility();
        
        // Afficher un message de confirmation
        showToast(`${filteredBooks.length} livres correspondent à "${searchTerm}"`);
    }
    
    // Événement de clic sur le bouton de recherche
    searchButton.addEventListener('click', searchBooks);
    
    // Événement de pression de la touche Entrée dans le champ de recherche
    searchInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            searchBooks();
        }
    });
    
    // Événement d'entrée de texte dans le champ de recherche
    searchInput.addEventListener('input', updateBannerVisibility);
}

// Fonction pour afficher un toast de notification
function showToast(message) {
    // Créer l'élément toast s'il n'existe pas déjà
    let toast = document.getElementById('toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast';
        toast.className = 'fixed bottom-4 right-4 bg-sidebar text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-20 opacity-0 transition-all duration-500 z-50';
        document.body.appendChild(toast);
        
        // Ajouter du CSS pour l'animation
        document.head.insertAdjacentHTML('beforeend', `
            <style>
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
                .shake {
                    animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
                }
                .animate-click {
                    animation: click 0.3s ease;
                }
                @keyframes click {
                    0% { transform: scale(1); }
                    50% { transform: scale(0.9); }
                    100% { transform: scale(1); }
                }
            </style>
        `);
    }
    
    // Mettre à jour le message et afficher le toast
    toast.textContent = message;
    toast.style.transform = 'translateY(0)';
    toast.style.opacity = '1';
    
    // Masquer le toast après 3 secondes
    setTimeout(() => {
        toast.style.transform = 'translateY(20px)';
        toast.style.opacity = '0';
    }, 3000);
}

// Initialiser les effets des boutons "view all"
function initButtonEffects() {
    // Ajouter des effets de survol aux boutons "view all"
    document.querySelectorAll('.view-all-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Ajouter une animation au clic
            this.classList.add('animate-click');
            setTimeout(() => {
                this.classList.remove('animate-click');
                showToast('Affichage de tous les livres de cette catégorie');
            }, 300);
        });
    });
    
    // Ajouter un effet de clic au bouton de la bannière
    const bannerBtn = document.querySelector('.banner-btn');
    if (bannerBtn) {
        bannerBtn.addEventListener('click', function(e) {
            e.preventDefault();
            // Ajouter une animation au clic
            this.classList.add('animate-click');
            setTimeout(() => {
                this.classList.remove('animate-click');
                showToast('Exploration de la collection "Meilleurs du jour"');
            }, 300);
        });
    }
}

// Fonction d'initialisation principale
function init() {
    // Charger les livres
    loadBooks();
    
    // Initialiser les filtres de catégorie
    initCategoryFilters();
    
    // Initialiser la fonctionnalité de recherche
    initSearchFunctionality();
    
    // Initialiser les effets des boutons
    initButtonEffects();
}

// Lancer l'initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', init);
    </script>
</body>

</html>