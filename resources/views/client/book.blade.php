<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBookSpace - Détail du livre</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'beige': '#e6c998', /* Beige plus chaud pour correspondre à l'image */
                        'beige-light': '#f8e7c9',
                        'sidebar': '#7c2d2d',
                        'search-btn': '#8b2121',
                        'view-btn': '#8b2121',
                        'borrow-btn': '#7c2d2d',
                        'download-btn': '#4a5568', /* Couleur pour le bouton download */
                        'romantic': '#f472b6',
                        'fiction': '#86efac',
                        'manga': '#fbbf24',
                        'education': '#60a5fa',
                        'all': '#9ca3af',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #000000; /* Fond noir comme dans l'image */
        }
        
        .main-container {
            background-color: #e6c998; /* Beige plus chaud comme dans l'image */
            border-radius: 0;
            min-height: 100vh;
        }
        
       .sidebar {
            width: 100px;
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
         .sidebar-icon {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-radius: 12px;
        }
        
        .sidebar-icon:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }
        
        .sidebar-icon.active {
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        
        .profile-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            overflow: hidden;
            margin-bottom: 1.5rem;
        }
        
        .subscribe-text {
            color: white;
            transform: rotate(90deg);
            transform-origin: center;
            white-space: nowrap;
            margin-top: auto;
            font-size: 0.875rem;
            letter-spacing: 1px;
            background-color: #4ade80;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
        }
        
        /* Style du contenu principal */
        .header {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .search-container {
            position: relative;
            width: 28rem;
        }
        
        .search-input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 9999px;
            border: none;
            background-color: #f8e7c9;
        }
        
        .search-btn {
            background-color: #8b2121;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
        }
        
        /* Styles pour la section de détail du livre */
        .book-detail-container {
            display: flex;
            padding: 2rem;
            margin: 0 auto;
            max-width: 1200px;
            background-color: #e6c998;
        }
        
        .book-cover-container {
            padding: 1rem;
            background-color: #e6c998;
            border-radius: 0.5rem;
            width: 400px;
        }
        
        .book-cover {
            width: 100%;
            height: auto;
            border-radius: 0.5rem;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .book-info {
            padding: 1rem 2rem;
            flex: 1;
        }
        
        .book-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
        }
        
        .book-metadata {
            margin-bottom: 1.5rem;
        }
        
        .metadata-item {
            margin-bottom: 0.75rem;
            font-size: 1.125rem;
        }
        
        .metadata-label {
            font-weight: 600;
            color: #7c2d2d;
        }
        
        .book-description {
            margin-bottom: 2rem;
        }
        
        .description-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #7c2d2d;
            margin-bottom: 0.5rem;
        }
        
        .description-content {
            color: #444;
            line-height: 1.6;
        }
        
        .book-price {
            font-size: 1.75rem;
            font-weight: 700;
            color: #7c2d2d;
            margin-bottom: 1.5rem;
        }
        
        .borrow-button {
            background-color: #7c2d2d;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1.25rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .borrow-button:hover {
            background-color: #6a2424;
        }
        
        .download-button {
            background-color: #4a5568;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 1.25rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-left: 1rem;
        }
        
        .download-button:hover {
            background-color: #374151;
        }
        
        .button-group {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar comme dans l'image -->
    <div class="sidebar">
        <div class="profile-icon">
            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80" alt="Profile" class="w-full h-full object-cover">
        </div>
        
        <div class="sidebar-icon">
            <i class="fas fa-bars"></i>
        </div>
        
        <div class="sidebar-icon">
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
        
        <div class="subscribe-text">
            Subscribe
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-container ml-24">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <div class="mr-2 text-sidebar">
                    <i class="fas fa-book text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-sidebar">MyBookSpace</h1>
            </div>
            
            <div class="flex items-center">
                <div class="search-container mr-4">
                    <input type="text" id="searchInput" placeholder="romantic" class="search-input">
                    <i class="fas fa-search absolute left-4 top-3 text-gray-500"></i>
                </div>
                <button id="searchButton" class="search-btn">
                    search
                </button>
            </div>
        </header>
        
        <!-- Book Detail Section -->
        <div class="book-detail-container">
            <!-- Left Side - Book Cover -->
            <div class="book-cover-container">
                <img src="https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=687&auto=format&fit=crop" alt="Don't Look Back" class="book-cover">
            </div>
            
            <!-- Right Side - Book Information -->
            <div class="book-info">
                <h1 class="book-title">Don't Look Back</h1>
                
                <div class="book-metadata">
                    <div class="metadata-item">
                        <span class="metadata-label">Catégorie : </span>
                        <span>romantic</span>
                    </div>
                    
                    <div class="metadata-item">
                        <span class="metadata-label">Langue : </span>
                        <span>FRANCAIS</span>
                    </div>
                    
                    <div class="metadata-item">
                        <span class="metadata-label">Auteur : </span>
                        <span>Wassim Dikrallah</span>
                    </div>
                    
                    <div class="metadata-item">
                        <span class="metadata-label">Année public : </span>
                        <span>Nov-2024</span>
                    </div>
                </div>
                
                <div class="book-description">
                    <h2 class="description-title">Description:</h2>
                    <p class="description-content">
                        Un récit captivant qui vous transportera dans un monde d'émotions intenses et de rebondissements inattendus. 
                        Cette histoire romantique explore les thèmes de l'amour, de la perte et de la rédemption à travers le parcours 
                        de deux personnages inoubliables dans le Paris des années 1920.
                    </p>
                </div>
                
                <div class="book-price">
                    <span>Price: 500 Dh</span>
                </div>
                
                <div class="button-group">
                    <button class="borrow-button">
                        Emprunter
                    </button>
                    <button class="download-button">
                        <i class="fas fa-download mr-2"></i>Download
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Fonction de recherche
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        
        function searchBooks() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            alert('Recherche pour: ' + searchTerm);
            // Dans une application réelle, cela redirigerait vers une page de résultats
        }
        
        // Événement de clic sur le bouton de recherche
        searchButton.addEventListener('click', searchBooks);
        
        // Événement de pression de la touche Entrée dans le champ de recherche
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                searchBooks();
            }
        });
        
        // Fonction de téléchargement
        const downloadButton = document.querySelector('.download-button');
        downloadButton.addEventListener('click', () => {
            alert('Téléchargement du livre "Don\'t Look Back" commencé');
            // Dans une application réelle, cela téléchargerait le livre
        });
    </script>
</body>
</html>