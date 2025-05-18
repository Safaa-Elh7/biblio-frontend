<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>MyBookSpace - Gestion des Articles</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              DEFAULT: '#8B2635',
              dark: '#701D2A',
              light: '#A63446',
            },
            secondary: {
              DEFAULT: '#F5E6D8',
              dark: '#E6D7C9',
            },
          },
        },
      },
    }
  </script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
    }

    .sidebar {
      transition: all 0.3s ease;
    }

    .sidebar-item {
      transition: all 0.2s ease;
    }

    .sidebar-item:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .sidebar-item.active {
      background-color: rgba(255, 255, 255, 0.15);
      border-left: 4px solid white;
    }

    .action-button {
      transition: all 0.2s ease;
    }

    .action-button:hover {
      transform: translateY(-2px);
    }

    .table-row {
      transition: background-color 0.2s ease;
    }

    .table-row:hover {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .pagination-button {
      transition: all 0.2s ease;
    }

    .pagination-button:hover:not(.active) {
      background-color: #e2e8f0;
    }

    .search-input:focus {
      box-shadow: 0 0 0 3px rgba(139, 38, 53, 0.3);
    }

    .notification {
      position: fixed;
      top: 1rem;
      right: 1rem;
      background-color: #10B981;
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
      z-index: 50;
      opacity: 1;
      transform: translateY(0);
      transition: opacity 0.3s, transform 0.3s;
    }

    .notification.hiding {
      opacity: 0;
      transform: translateY(-20px);
    }
  </style>
</head>

<body class="bg-gray-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar bg-primary w-64 flex-shrink-0 hidden md:block">
      <div class="flex items-center justify-center h-16 border-b border-primary-dark">
        <div class="flex items-center">
          <img id="logo" alt="Logo" class="w-10 h-10 rounded-full bg-white">
          <span class="ml-2 text-white text-xl font-semibold">MyBookSpace</span>
        </div>
      </div>
      <div class="py-4">
        <ul>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.dashboard.index') }}"
              class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-home mr-3"></i>
              <span>Accueil</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.user.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-users mr-3"></i>
              <span>Users</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.livreur.index') }}"
              class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-truck mr-3"></i>
              <span>Livreurs</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-credit-card mr-3"></i>
              <span>Orders</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.article.index') }}"
              class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-book mr-3"></i>
              <span>Articles</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="absolute bottom-0 w-64 border-t border-primary-dark">
          <div class="flex items-center px-4 py-3">
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-primary-dark flex items-center justify-center text-white">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="ml-2">
                <div class="text-white text-sm font-medium">{{ Auth::user()->nom }}</div>
                <div class="text-white text-xs opacity-70">{{ Auth::user()->email }}</div>
              </div>
            </div>
          </div>
        </div>
    </div>

    <!-- Mobile sidebar toggle -->
    <div class="md:hidden fixed bottom-4 right-4 z-50">
      <button id="sidebarToggle" class="bg-primary text-white p-3 rounded-full shadow-lg">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Mobile sidebar -->
    <div id="mobileSidebar" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden">
      <div
        class="sidebar bg-primary w-64 h-full transform -translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex items-center justify-between h-16 border-b border-primary-dark px-4">
          <div class="flex items-center">
            <img id="mobileLogo" alt="Logo" class="w-10 h-10 rounded-full bg-white">
            <span class="ml-2 text-white text-xl font-semibold">MyBookSpace</span>
          </div>
          <button id="closeSidebar" class="text-white">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="py-4">
          <ul>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.dashboard.index') }}"
                class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-home mr-3"></i>
                <span>Accueil</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.user.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-users mr-3"></i>
                <span>Users</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.livreur.index') }}"
                class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-truck mr-3"></i>
                <span>Livreurs</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.payment.show') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-credit-card mr-3"></i>
                <span>Payments</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.article.index') }}"
                class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-book mr-3"></i>
                <span>Articles</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="absolute bottom-0 w-64 border-t border-primary-dark">
          <div class="flex items-center px-4 py-3">
            <div class="flex items-center">
              <div class="w-8 h-8 rounded-full bg-primary-dark flex items-center justify-center text-white">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="ml-2">
                <div class="text-white text-sm font-medium">{{ Auth::user()->nom }}</div>
                <div class="text-white text-xs opacity-70">{{ Auth::user()->email }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="flex-1 overflow-y-auto">
      <!-- Top navigation -->
      <header class="bg-white shadow-sm">
        <div class="flex items-center justify-between px-4 py-3">
          <h1 class="text-2xl font-semibold text-gray-800">Gestion des Articles</h1>
          
        </div>
      </header>

      <!-- Articles content -->
      <main class="p-6 bg-secondary min-h-screen">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="bg-white rounded-lg shadow-md p-4 flex items-center transition-transform transform hover:scale-105">
            <div class="bg-blue-100 p-3 rounded-full">
              <i class="fas fa-book text-blue-600 text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-gray-500 text-sm">Total des livres</h3>
              <p class="text-2xl font-semibold text-gray-800" id="totalBooks">...</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-4 flex items-center transition-transform transform hover:scale-105">
            <div class="bg-green-100 p-3 rounded-full">
              <i class="fas fa-hand-holding-heart text-green-600 text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-gray-500 text-sm">Livres empruntés</h3>
              <p class="text-2xl font-semibold text-gray-800" id="totalLoans">...</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-4 flex items-center transition-transform transform hover:scale-105">
            <div class="bg-yellow-100 p-3 rounded-full">
              <i class="fas fa-users text-yellow-600 text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-gray-500 text-sm">Auteurs uniques</h3>
              <p class="text-2xl font-semibold text-gray-800" id="uniqueAuthors">...</p>
            </div>
          </div>
          
          <div class="bg-white rounded-lg shadow-md p-4 flex items-center transition-transform transform hover:scale-105">
            <div class="bg-purple-100 p-3 rounded-full">
              <i class="fas fa-tags text-purple-600 text-xl"></i>
            </div>
            <div class="ml-4">
              <h3 class="text-gray-500 text-sm">Genres uniques</h3>
              <p class="text-2xl font-semibold text-gray-800" id="uniqueGenres">...</p>
            </div>
          </div>
        </div>
        
        <!-- View Toggle Buttons -->
        <div class="flex justify-between items-center mb-4">
          <h2 class="text-2xl font-semibold text-gray-800">Gestion de la Bibliothèque</h2>
          
        </div>

        <!-- Table View -->
        <div id="tableView" class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Liste des Articles</h2>
            <button id="addArticleBtn"
              class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md flex items-center transition duration-200 action-button">
              <i class="fas fa-plus mr-2"></i>
              <span>Ajouter un article</span>
            </button>
          </div>

          <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
              <thead>
                <tr class="bg-gray-50 border-b">
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Langue</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                    disponible</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre
                    d'emprunts</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                  </th>
                </tr>
              </thead>
              <tbody id="articlesTableBody">
                <!-- Table rows will be populated by JavaScript -->
              </tbody>
            </table>
          </div>

          <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
              Affichage de <span id="startEntry">1</span> à <span id="endEntry">5</span> sur <span
                id="totalEntries">50</span> entrées
            </div>
            <div class="flex items-center space-x-1" id="pagination">
              <button
                class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-l-md hover:bg-gray-300 transition-colors"
                id="prevPage">
                <i class="fas fa-chevron-left"></i>
              </button>

              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-primary text-white font-medium hover:bg-primary-dark transition-colors"
                data-page="1">1</button>
              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                data-page="2">2</button>
              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                data-page="3">3</button>

              <button
                class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-r-md hover:bg-gray-300 transition-colors"
                id="nextPage">
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
        
        <!-- Grid View (hidden by default) -->
        <div id="gridView" class="bg-white rounded-lg shadow-md p-6 mb-6 hidden">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Galerie des Livres</h2>
            <button id="addArticleGridBtn"
              class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md flex items-center transition duration-200">
              <i class="fas fa-plus mr-2"></i>
              <span>Ajouter un livre</span>
            </button>
          </div>
          
          <div id="articlesGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Grid items will be populated by JavaScript -->
          </div>
          
          <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
              Affichage de <span id="startEntryGrid">1</span> à <span id="endEntryGrid">8</span> sur <span
                id="totalEntriesGrid">50</span> entrées
            </div>
            <div class="flex items-center space-x-1" id="paginationGrid">
              <button
                class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-l-md hover:bg-gray-300 transition-colors"
                id="prevPageGrid">
                <i class="fas fa-chevron-left"></i>
              </button>

              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-primary text-white font-medium hover:bg-primary-dark transition-colors"
                data-page="1">1</button>
              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                data-page="2">2</button>
              <button
                class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors"
                data-page="3">3</button>

              <button
                class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-r-md hover:bg-gray-300 transition-colors"
                id="nextPageGrid">
                <i class="fas fa-chevron-right"></i>
              </button>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Add Article Modal -->
  <div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
      <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ajouter un article</h2>

      <form id="addArticleForm" action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data"
        class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" id="titre" name="titre"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div>
            <label for="auteur" class="block text-sm font-medium text-gray-700 mb-1">Auteur</label>
            <input type="text" id="auteur" name="auteur"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div>
            <label for="id_categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select id="id_categorie" name="id_categorie"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
              <option value="">Sélectionner une catégorie</option>
              <option value="1">Fiction</option>
              <option value="2">Science-fiction</option>
              <option value="3">Fantasy</option>
              <option value="4">Roman</option>
              <option value="5">Roman historique</option>
              <option value="6">Biographie</option>
              <option value="7">Poésie</option>
            </select>
          </div>
          <div>
            <label for="annee_pub" class="block text-sm font-medium text-gray-700 mb-1">Année de publication</label>
            <input type="number" id="annee_pub" name="annee_pub" min="1000" max="2099"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
            <input type="text" id="isbn" name="isbn"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div>
            <label for="langue" class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
            <select id="langue" name="langue"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
              <option value="">Sélectionner une langue</option>
              <option value="Français">Français</option>
              <option value="Anglais">Anglais</option>
              <option value="Espagnol">Espagnol</option>
              <option value="Allemand">Allemand</option>
              <option value="Italien">Italien</option>
              <option value="Arabe">Arabe</option>
            </select>
          </div>
          <div>
            <label for="qte" class="block text-sm font-medium text-gray-700 mb-1">Quantité en stock</label>
            <input type="number" id="qte" name="qte" min="0"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div>
            <label for="prix_emprunt" class="block text-sm font-medium text-gray-700 mb-1">Prix d'emprunt</label>
            <input type="number" id="prix_emprunt" name="prix_emprunt" min="0" step="0.01"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required>
          </div>
          <div class="md:col-span-2">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image</label>
            <input type="file" id="image" name="image"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              accept="image/*">
          </div>
          <div class="md:col-span-2">
            <label for="contenu" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="contenu" name="description" rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"
              required></textarea>
          </div>
        </div>

        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" id="cancelAddArticle"
            class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
            Annuler
          </button>
          <button type="submit"
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Article Modal (will be created dynamically) -->

  <!-- JavaScript -->
  <script>
    // Global variables for article management
    let articles = [];
    let currentPage = 1;
    const itemsPerPage = 5;
    let totalPages = 0;

    let currentPageGrid = 1;
    const itemsPerPageGrid = 8;

    // CSRF token for AJAX requests
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Wait for DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", () => {
      // Create logo
      createLogo();

      // Fetch articles from API
      fetchArticles();

      // Mobile sidebar toggle
      const sidebarToggle = document.getElementById("sidebarToggle");
      const mobileSidebar = document.getElementById("mobileSidebar");
      const closeSidebar = document.getElementById("closeSidebar");
      const sidebar = mobileSidebar.querySelector(".sidebar");

      sidebarToggle.addEventListener("click", () => {
        mobileSidebar.classList.remove("hidden");
        setTimeout(() => {
          sidebar.classList.add("translate-x-0");
          sidebar.classList.remove("-translate-x-full");
        }, 50);
      });

      closeSidebar.addEventListener("click", () => {
        sidebar.classList.remove("translate-x-0");
        sidebar.classList.add("-translate-x-full");
        setTimeout(() => {
          mobileSidebar.classList.add("hidden");
        }, 300);
      });

      // Close sidebar when clicking outside
      mobileSidebar.addEventListener("click", (e) => {
        if (e.target === mobileSidebar) {
          sidebar.classList.remove("translate-x-0");
          sidebar.classList.add("-translate-x-full");
          setTimeout(() => {
            mobileSidebar.classList.add("hidden");
          }, 300);
        }
      });

      // Pagination event listeners
      document.getElementById("prevPage").addEventListener("click", () => {
        if (currentPage > 1) {
          currentPage--;
          updateTable();
          updatePagination();
          updateStatistics();
        }
      });

      document.getElementById("nextPage").addEventListener("click", () => {
        if (currentPage < totalPages) {
          currentPage++;
          updateTable();
          updatePagination();
          updateStatistics();
        }
      });

      // Page number buttons
      document.querySelectorAll(".pagination-button[data-page]").forEach((button) => {
        button.addEventListener("click", function () {
          currentPage = Number.parseInt(this.getAttribute("data-page"));
          updateTable();
          updatePagination();
          updateStatistics();
        });
      });

      // Modal functionality
      const addArticleBtn = document.getElementById("addArticleBtn");
      const addArticleModal = document.getElementById("addArticleModal");
      const closeModal = document.getElementById("closeModal");
      const cancelAddArticle = document.getElementById("cancelAddArticle");
      const addArticleForm = document.getElementById("addArticleForm");

      addArticleBtn.addEventListener("click", () => {
        addArticleModal.classList.remove("hidden");
        document.body.style.overflow = "hidden";
      });

      function closeModalFunction() {
        addArticleModal.classList.add("hidden");
        document.body.style.overflow = "auto";
        addArticleForm.reset();
      }

      closeModal.addEventListener("click", closeModalFunction);
      cancelAddArticle.addEventListener("click", closeModalFunction);

      // Close modal when clicking outside
      addArticleModal.addEventListener("click", (e) => {
        if (e.target === addArticleModal) {
          closeModalFunction();
        }
      });

      // Search functionality
      const searchInput = document.querySelector(".search-input");
      searchInput.addEventListener("input", () => {
        currentPage = 1;
        updateTable();
        updatePagination();
        updateStatistics();
        updateGrid();
      });

      // Form submission for adding a new article
      addArticleForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('/articles', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': csrfToken
            // Ne pas définir Content-Type avec FormData, le navigateur le fait automatiquement
          }
        })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            closeModalFunction();
            showNotification("Article créé avec succès!");
            // Refresh the articles list
            fetchArticles();
          })
          .catch(error => {
            console.error('Error:', error);
            showNotification("Erreur lors de la création de l'article", "error");
          });
      });
    });

    // Function to update the table based on current page and search
    function updateTable() {
      const tableBody = document.getElementById("articlesTableBody");
      tableBody.innerHTML = "";

      const searchTerm = document.querySelector(".search-input").value.toLowerCase();
      const filteredArticles = articles.filter(
        (article) =>
          (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
          (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
          (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
          (article.isbn && article.isbn.includes(searchTerm)) ||
          (article.description && article.description.toLowerCase().includes(searchTerm)) ||
          (article.langue && article.langue.toLowerCase().includes(searchTerm))
      );

      const startIndex = (currentPage - 1) * itemsPerPage;
      const endIndex = Math.min(startIndex + itemsPerPage, filteredArticles.length);

      // Update pagination info
      document.getElementById("startEntry").textContent = filteredArticles.length > 0 ? startIndex + 1 : 0;
      document.getElementById("endEntry").textContent = endIndex;
      document.getElementById("totalEntries").textContent = filteredArticles.length;

      // Create table rows
      for (let i = startIndex; i < endIndex; i++) {
        const article = filteredArticles[i];
        const row = document.createElement("tr");
        row.className = "table-row border-b hover:bg-gray-50";

        // Function to get image URL
        function getImageUrl(imagePath) {
          if (!imagePath) return 'https://via.placeholder.com/50x70?text=No+Image';
          if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
            return imagePath;
          }
          return `/storage/${imagePath.replace(/^\/+/, '')}`;
        }

        row.innerHTML = `
      <td class="px-6 py-4 whitespace-nowrap text-sm">
        <img src="${getImageUrl(article.image)}" alt="${article.titre || 'Livre'}" class="h-16 w-12 object-cover rounded-md shadow-sm">
      </td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${article.titre || ''}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.auteur || ''}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.description || ''}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.langue || ''}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.qte || 0}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.loans || 0}</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
        <div class="flex space-x-2">
          <button class="action-button bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="editArticle(${article.id_article})">
            <i class="fas fa-edit mr-1"></i> Modifier
          </button>
          <button class="action-button bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="deleteArticle(${article.id_article})">
            <i class="fas fa-trash mr-1"></i> Supprimer
          </button>
          <button class="action-button bg-gray-600 hover:bg-gray-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="viewArticleDetails(${article.id_article})">
            <i class="fas fa-info-circle mr-1"></i> Détail
          </button>
        </div>
      </td>
    `;

        tableBody.appendChild(row);
      }
    }

    // Function to update the grid view
    function updateGrid() {
      const gridContainer = document.getElementById("articlesGrid");
      gridContainer.innerHTML = "";

      const searchTerm = document.querySelector(".search-input").value.toLowerCase();
      const filteredArticles = articles.filter(
        (article) =>
          (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
          (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
          (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
          (article.isbn && article.isbn.includes(searchTerm)) ||
          (article.description && article.description.toLowerCase().includes(searchTerm)) ||
          (article.langue && article.langue.toLowerCase().includes(searchTerm))
      );

      const startIndex = (currentPageGrid - 1) * itemsPerPageGrid;
      const endIndex = Math.min(startIndex + itemsPerPageGrid, filteredArticles.length);

      // Update pagination info for grid
      document.getElementById("startEntryGrid").textContent = filteredArticles.length > 0 ? startIndex + 1 : 0;
      document.getElementById("endEntryGrid").textContent = endIndex;
      document.getElementById("totalEntriesGrid").textContent = filteredArticles.length;

      // Function to get image URL
      function getImageUrl(imagePath) {
        if (!imagePath) return 'https://via.placeholder.com/200x300?text=No+Image';
        if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
          return imagePath;
        }
        return `/storage/${imagePath.replace(/^\/+/, '')}`;
      }

      // Create grid cards
      for (let i = startIndex; i < endIndex; i++) {
        const article = filteredArticles[i];
        const card = document.createElement("div");
        card.className = "bg-white rounded-lg overflow-hidden shadow-lg transition-transform transform hover:scale-105";

        card.innerHTML = `
          <div class="relative pb-48 overflow-hidden">
            <img class="absolute inset-0 h-full w-full object-cover" src="${getImageUrl(article.image)}" alt="${article.titre || 'Livre'}">
          </div>
          <div class="p-4">
            <h3 class="font-bold text-lg mb-1 text-gray-900 truncate">${article.titre || 'Sans titre'}</h3>
            <p class="text-sm text-gray-600 mb-2">
              <i class="fas fa-user mr-1 text-primary"></i> ${article.auteur || 'Auteur inconnu'}
            </p>
            <p class="text-sm text-gray-500 mb-2">
              <i class="fas fa-tag mr-1 text-primary"></i> ${article.genre || 'Genre non spécifié'}
            </p>
            <p class="text-sm text-gray-500 mb-2">
              <i class="fas fa-language mr-1 text-primary"></i> ${article.langue || 'Langue non spécifiée'}
            </p>
            <p class="text-sm text-gray-500">
              <i class="fas fa-box mr-1 text-primary"></i> Stock: ${article.qte || 0}
            </p>
          </div>
          <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
              <span class="text-xs font-semibold text-gray-500">ISBN: ${article.isbn || 'N/A'}</span>
              <div class="flex space-x-1">
                <button onclick="editArticle(${article.id_article})" class="text-blue-500 hover:text-blue-700">
                  <i class="fas fa-edit"></i>
                </button>
                <button onclick="deleteArticle(${article.id_article})" class="text-red-500 hover:text-red-700">
                  <i class="fas fa-trash"></i>
                </button>
                <button onclick="viewArticleDetails(${article.id_article})" class="text-gray-500 hover:text-gray-700">
                  <i class="fas fa-info-circle"></i>
                </button>
              </div>
            </div>
          </div>
        `;

        gridContainer.appendChild(card);
      }
    }

    // Function to update pagination buttons
    function updatePagination() {
      const searchTerm = document.querySelector(".search-input").value.toLowerCase();
      const filteredArticles = articles.filter(
        (article) =>
          (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
          (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
          (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
          (article.isbn && article.isbn.includes(searchTerm)) ||
          (article.description && article.description.toLowerCase().includes(searchTerm)) ||
          (article.langue && article.langue.toLowerCase().includes(searchTerm))
      );

      const totalFilteredPages = Math.ceil(filteredArticles.length / itemsPerPage);

      // Update pagination buttons
      const paginationContainer = document.getElementById("pagination");
      const pageButtons = paginationContainer.querySelectorAll("[data-page]");

      // Update active state
      pageButtons.forEach((button) => {
        const page = Number.parseInt(button.getAttribute("data-page"));
        if (page === currentPage) {
          button.classList.add("bg-primary", "text-white");
          button.classList.remove("bg-gray-200", "text-gray-700");
        } else {
          button.classList.remove("bg-primary", "text-white");
          button.classList.add("bg-gray-200", "text-gray-700");
        }
      });

      // Disable/enable prev/next buttons
      const prevButton = document.getElementById("prevPage");
      const nextButton = document.getElementById("nextPage");

      if (currentPage === 1) {
        prevButton.classList.add("opacity-50", "cursor-not-allowed");
      } else {
        prevButton.classList.remove("opacity-50", "cursor-not-allowed");
      }

      if (currentPage === totalFilteredPages || totalFilteredPages === 0) {
        nextButton.classList.add("opacity-50", "cursor-not-allowed");
      } else {
        nextButton.classList.remove("opacity-50", "cursor-not-allowed");
      }
    }

    // Function to update pagination buttons for grid view
    function updatePaginationGrid() {
      const searchTerm = document.querySelector(".search-input").value.toLowerCase();
      const filteredArticles = articles.filter(
        (article) =>
          (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
          (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
          (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
          (article.isbn && article.isbn.includes(searchTerm)) ||
          (article.description && article.description.toLowerCase().includes(searchTerm)) ||
          (article.langue && article.langue.toLowerCase().includes(searchTerm))
      );

      const totalFilteredPages = Math.ceil(filteredArticles.length / itemsPerPageGrid);

      // Update pagination buttons
      const paginationContainer = document.getElementById("paginationGrid");
      const pageButtons = paginationContainer.querySelectorAll("[data-page]");

      // Update active state
      pageButtons.forEach((button) => {
        const page = Number.parseInt(button.getAttribute("data-page"));
        if (page === currentPageGrid) {
          button.classList.add("bg-primary", "text-white");
          button.classList.remove("bg-gray-200", "text-gray-700");
        } else {
          button.classList.remove("bg-primary", "text-white");
          button.classList.add("bg-gray-200", "text-gray-700");
        }
      });

      // Disable/enable prev/next buttons
      const prevButton = document.getElementById("prevPageGrid");
      const nextButton = document.getElementById("nextPageGrid");

      if (currentPageGrid === 1) {
        prevButton.classList.add("opacity-50", "cursor-not-allowed");
      } else {
        prevButton.classList.remove("opacity-50", "cursor-not-allowed");
      }

      if (currentPageGrid === totalFilteredPages || totalFilteredPages === 0) {
        nextButton.classList.add("opacity-50", "cursor-not-allowed");
      } else {
        nextButton.classList.remove("opacity-50", "cursor-not-allowed");
      }
    }

    // Function to update statistics
    function updateStatistics() {
      const searchTerm = document.querySelector(".search-input").value.toLowerCase();
      const filteredArticles = articles.filter(
        (article) =>
          (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
          (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
          (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
          (article.isbn && article.isbn.includes(searchTerm)) ||
          (article.description && article.description.toLowerCase().includes(searchTerm)) ||
          (article.langue && article.langue.toLowerCase().includes(searchTerm))
      );
      
      // Total books
      document.getElementById("totalBooks").textContent = filteredArticles.length;
      
      // Total loans
      const totalLoans = filteredArticles.reduce((sum, article) => sum + (article.loans || 0), 0);
      document.getElementById("totalLoans").textContent = totalLoans;
      
      // Unique authors
      const uniqueAuthors = new Set();
      filteredArticles.forEach(article => {
        if (article.auteur) uniqueAuthors.add(article.auteur);
      });
      document.getElementById("uniqueAuthors").textContent = uniqueAuthors.size;
      
      // Unique genres
      const uniqueGenres = new Set();
      filteredArticles.forEach(article => {
        if (article.genre) uniqueGenres.add(article.genre);
      });
      document.getElementById("uniqueGenres").textContent = uniqueGenres.size;
    }

    // Create logo
    function createLogo() {
      const canvas = document.createElement("canvas");
      canvas.width = 40;
      canvas.height = 40;
      const ctx = canvas.getContext("2d");

      // Draw background
      ctx.fillStyle = "#FFFFFF";
      ctx.beginPath();
      ctx.arc(20, 20, 20, 0, Math.PI * 2);
      ctx.fill();

      // Draw book icon
      ctx.fillStyle = "#8B2635";
      ctx.beginPath();
      ctx.moveTo(12, 10);
      ctx.lineTo(28, 10);
      ctx.lineTo(28, 30);
      ctx.lineTo(12, 30);
      ctx.closePath();
      ctx.fill();

      // Draw book pages
      ctx.fillStyle = "#FFFFFF";
      ctx.beginPath();
      ctx.moveTo(14, 12);
      ctx.lineTo(26, 12);
      ctx.lineTo(26, 28);
      ctx.lineTo(14, 28);
      ctx.closePath();
      ctx.fill();

      // Draw book lines
      ctx.strokeStyle = "#8B2635";
      ctx.lineWidth = 1;
      ctx.beginPath();
      ctx.moveTo(16, 16);
      ctx.lineTo(24, 16);
      ctx.moveTo(16, 20);
      ctx.lineTo(24, 20);
      ctx.moveTo(16, 24);
      ctx.lineTo(24, 24);
      ctx.stroke();

      // Set the logo
      const logoImg = document.getElementById("logo");
      const mobileLogoImg = document.getElementById("mobileLogo");
      logoImg.src = canvas.toDataURL();
      mobileLogoImg.src = canvas.toDataURL();
    }

    // Global function to fetch articles
    function fetchArticles() {
      fetch('/articles?json=true')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          articles = data;
          totalPages = Math.ceil(articles.length / itemsPerPage);
          updateTable();
          updatePagination();
          updateStatistics();
          updateGrid();
        })
        .catch(error => {
          console.error('Error fetching articles:', error);
          showNotification("Erreur lors du chargement des articles", "error");
        });
    }

    // Function to edit an article
    function editArticle(id) {
      // Afficher un spinner ou un indicateur de chargement
      showNotification("Chargement des détails de l'article...", "info");

      // Fetch article details
      fetch(`/api/articles/${id_article}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(article => {
          // Masquer la notification de chargement
          document.querySelectorAll('.notification.bg-blue-500').forEach(el => {
            if (el.parentNode) {
              el.parentNode.removeChild(el);
            }
          });

          // S'assurer que toutes les propriétés existent
          article = {
            id: article.id_article || id,
            titre: article.titre || '',
            auteur: article.auteur || '',
            genre: article.genre || '',
            isbn: article.isbn || '',
            qte: article.qte || 0,
            prix_emprunt: article.prix_emprunt || 0,
            annee_pub: article.annee_pub || '',
            description: article.description || '',
            langue: article.langue || 'Français',
            id_categorie: article.id_categorie || 1,
            image: article.image || '',
            ...article // conserver d'autres propriétés potentielles
          };
          

          // Create edit modal
          const modal = document.createElement('div');
          modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';

          // Function to get image URL
          function getImageUrl(imagePath, defaultUrl = 'https://via.placeholder.com/300x400?text=Livre') {
            if (!imagePath) return defaultUrl;
            if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
              return imagePath;
            }
            return `/storage/${imagePath.replace(/^\/+/, '')}`;
          }

          const imageUrl = getImageUrl(article.image);

          modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-screen overflow-y-auto">
          <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-xl font-semibold text-gray-800">Modifier le livre</h3>
            <button id="closeEditModalBtn" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-times"></i>
            </button>
          </div>
          
          <div class="p-6">
            <form id="editArticleForm" class="space-y-4">
              <input type="hidden" name="_token" value="${csrfToken}">
              <input type="hidden" name="id" value="${article.id_article}">
              
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="col-span-1">
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text" id="edit-titre" name="titre" value="${article.titre}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auteur</label>
                    <input type="text" id="edit-auteur" name="auteur" value="${article.auteur}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                  </div>

                  
                  <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Stock</label>
                      <input type="number" id="edit-qte" name="qte" value="${article.qte}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Prix</label>
                      <input type="number" step="0.01" id="edit-prix" name="prix_emprunt" value="${article.prix_emprunt}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                    <div>
                      <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                      <input type="number" id="edit-annee" name="annee_pub" value="${article.annee_pub}" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    </div>
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="edit-contenu" name="description" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" rows="5">${article.description}</textarea>
                  </div>
                </div>
                
                <div class="col-span-1">
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Image</label>
                    <div class="mt-1 flex flex-col items-center justify-center">
                      <img src="${imageUrl}" alt="${article.titre}" class="w-full max-h-60 object-cover rounded-lg mb-4">
                      <input type="file" id="edit-image" name="image" class="hidden">
                      <label for="edit-image" class="cursor-pointer bg-white text-primary hover:text-primary-dark py-2 px-4 border border-primary rounded-md transition duration-200">
                        <i class="fas fa-upload mr-2"></i> Changer l'image
                      </label>
                    </div>
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
                    <select id="edit-langue" name="langue" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                      <option value="Français" ${article.langue === 'Français' ? 'selected' : ''}>Français</option>
                      <option value="Anglais" ${article.langue === 'Anglais' ? 'selected' : ''}>Anglais</option>
                      <option value="Espagnol" ${article.langue === 'Espagnol' ? 'selected' : ''}>Espagnol</option>
                      <option value="Allemand" ${article.langue === 'Allemand' ? 'selected' : ''}>Allemand</option>
                      <option value="Italien" ${article.langue === 'Italien' ? 'selected' : ''}>Italien</option>
                      <option value="Arabe" ${article.langue === 'Arabe' ? 'selected' : ''}>Arabe</option>
                      <option value="Autre" ${!['Français', 'Anglais', 'Espagnol', 'Allemand', 'Italien', 'Arabe'].includes(article.langue) ? 'selected' : ''}>Autre</option>
                    </select>
                  </div>
                  
                  <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="edit-categorie" name="id_categorie" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                      <option value="1" ${article.id_categorie == 1 ? 'selected' : ''}>Fiction</option>
                      <option value="2" ${article.id_categorie == 2 ? 'selected' : ''}>Science-fiction</option>
                      <option value="3" ${article.id_categorie == 3 ? 'selected' : ''}>Fantasy</option>
                      <option value="4" ${article.id_categorie == 4 ? 'selected' : ''}>Roman</option>
                      <option value="5" ${article.id_categorie == 5 ? 'selected' : ''}>Roman historique</option>
                      <option value="6" ${article.id_categorie == 6 ? 'selected' : ''}>Biographie</option>
                      <option value="7" ${article.id_categorie == 7 ? 'selected' : ''}>Poésie</option>
                    </select>
                  </div>
                </div>
              </div>
            
              <div class="border-t border-gray-200 pt-4 mt-4 flex justify-end">
                <button type="submit" id="saveArticleBtn" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded transition duration-200 mr-2">
                  <i class="fas fa-save mr-2"></i> Enregistrer
                </button>
                <button type="button" id="closeEditFormBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded transition duration-200">
                  Annuler
                </button>
              </div>
            </form>
          </div>
        </div>
      `;

          document.body.appendChild(modal);

          // Event handlers
          document.getElementById('closeEditModalBtn').addEventListener('click', () => {
            document.body.removeChild(modal);
          });

          document.getElementById('closeEditFormBtn').addEventListener('click', () => {
            document.body.removeChild(modal);
          });

          // Image preview
          const imageInput = document.getElementById('edit-image');
          imageInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
              const reader = new FileReader();
              reader.onload = (event) => {
                const imgElement = modal.querySelector('img');
                imgElement.src = event.target.result;
              };
              reader.readAsDataURL(e.target.files[0]);
            }
          });

          // Form submission
          document.getElementById('editArticleForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            // Ajouter le champ _method pour simuler une requête PUT
            formData.append('_method', 'PUT');

            fetch(`/articles/${id}`, {
              method: 'POST',
              body: formData,
              headers: {
                'X-CSRF-TOKEN': csrfToken
                // Ne pas définir Content-Type avec FormData, le navigateur le fait automatiquement
              }
            })
              .then(response => {
                if (!response.ok) {
                  return response.json().then(data => {
                    throw new Error(data.message || 'Network response was not ok');
                  });
                }
                return response.json();
              })
              .then(data => {
                document.body.removeChild(modal);
                showNotification("Article modifié avec succès!");
                // Refresh the articles list
                fetchArticles();
              })
              .catch(error => {
                console.error('Error:', error);
                showNotification("Erreur lors de la modification de l'article: " + error.message, "error");
              });
          });
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification("Erreur lors du chargement des détails de l'article", "error");
        });
    }

    // Function to delete an article
    function deleteArticle(id) {
      // Vérifier que l'ID est valide
      if (!id || isNaN(parseInt(id))) {
        showNotification("ID d'article invalide", "error");
        return;
      }
      
      if (confirm("Êtes-vous sûr de vouloir supprimer cet article?")) {
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('_method', 'DELETE');
        
        fetch(`/articles/${id}`, {
          method: 'POST',
          headers: {
            'X-CSRF-TOKEN': csrfToken
          },
          body: formData
        })
          .then(response => {
            // Gérer également les réponses non JSON
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
              return response.json().then(data => {
                if (!response.ok) {
                  throw new Error(data.message || `Erreur ${response.status}`);
                }
                return data;
              });
            } else {
              if (!response.ok) {
                throw new Error(`Erreur ${response.status}`);
              }
              return { success: true, message: "Article supprimé avec succès" };
            }
          })
          .then(data => {
            if (data.success) {
              showNotification("Article supprimé avec succès!");
              // Refresh the articles list
              fetchArticles();
            } else {
              showNotification(data.message || "Opération réussie", data.success ? "success" : "error");
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Message d'erreur plus court et plus convivial
            showNotification("Erreur lors de la suppression: " + error.message, "error");
          });
      }
    }

    // Function to view article details
    function viewArticleDetails(id) {
      // Fetch article details
      fetch(`/api/articles/${id}`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(article => {
          // Create details modal
          const modal = document.createElement('div');
          modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';

          // Function to get image URL
          function getImageUrl(imagePath, defaultUrl = 'https://via.placeholder.com/300x400?text=Livre') {
            if (!imagePath) return defaultUrl;
            if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
              return imagePath;
            }
            return `/storage/${imagePath.replace(/^\/+/, '')}`;
          }

          const imageUrl = getImageUrl(article.image);

          // Modal content
          modal.innerHTML = `
        <div class="bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-screen overflow-y-auto">
          <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
            <h3 class="text-xl font-semibold text-gray-800">Détails du livre</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-500">
              <i class="fas fa-times"></i>
            </button>
          </div>
          
          <div class="p-6">
            <div class="flex flex-col md:flex-row gap-6">
              <div class="w-full md:w-1/3">
                <img src="${imageUrl}" alt="${article.titre}" class="rounded-lg shadow-md w-full">
              </div>
              
              <div class="flex-1">
                <h2 class="text-2xl font-semibold mb-4">${article.titre || ''}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                  <div>
                    <p class="text-sm text-gray-600">Auteur</p>
                    <p class="font-medium">${article.auteur || ''}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Genre</p>
                    <p class="font-medium">${article.genre || ''}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Année de publication</p>
                    <p class="font-medium">${article.annee_pub || ''}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Langue</p>
                    <p class="font-medium">${article.langue || ''}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">ISBN</p>
                    <p class="font-medium">${article.isbn || ''}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Stock disponible</p>
                    <p class="font-medium">${article.qte || 0}</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Prix d'emprunt</p>
                    <p class="font-medium">${article.prix_emprunt || 0} Dh</p>
                  </div>
                  <div>
                    <p class="text-sm text-gray-600">Nombre d'emprunts</p>
                    <p class="font-medium">${article.loans || 0}</p>
                  </div>
                </div>
                
                <div class="mb-6">
                  <p class="text-sm text-gray-600 mb-1">Description</p>
                  <p class="bg-gray-50 p-3 rounded-md">${article.description || 'Aucune description disponible.'}</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="border-t border-gray-200 px-6 py-4 flex justify-end">
            <button class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded transition duration-200 mr-2" onclick="editArticle(${article.id})">
              <i class="fas fa-edit mr-2"></i> Modifier
            </button>
            <button id="closeDetailBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded transition duration-200">
              Fermer
            </button>
          </div>
        </div>
      `;

          document.body.appendChild(modal);

          // Close modal
          document.getElementById('closeModalBtn').addEventListener('click', () => {
            document.body.removeChild(modal);
          });

          document.getElementById('closeDetailBtn').addEventListener('click', () => {
            document.body.removeChild(modal);
          });
        })
        .catch(error => {
          console.error('Error:', error);
          showNotification("Erreur lors du chargement des détails de l'article", "error");
        });
    }

    // Function to show notifications
    function showNotification(message, type = "success") {
      // Éviter les messages vides ou non définis
      if (!message) {
        console.warn("Tentative d'afficher une notification sans message");
        return;
      }
      
      // Déterminer la classe de couleur en fonction du type
      let bgColor = "bg-green-500"; // success par défaut
      let icon = "fa-check-circle";
      
      if (type === "error") {
        bgColor = "bg-red-500";
        icon = "fa-exclamation-circle";
        // Si le message contient une erreur trop technique, la simplifier
        if (message.includes("NetworkError") || message.includes("Failed to fetch")) {
          message = "Problème de connexion au serveur";
        } else if (message.length > 100) {
          // Tronquer les messages trop longs
          message = message.substring(0, 100) + "...";
        }
      } else if (type === "info") {
        bgColor = "bg-blue-500";
        icon = "fa-info-circle";
      } else if (type === "warning") {
        bgColor = "bg-yellow-500";
        icon = "fa-exclamation-triangle";
      }

      // Supprimer toutes les notifications existantes du même type
      document.querySelectorAll(`.notification.${bgColor}`).forEach(el => {
        if (el.parentNode) {
          el.parentNode.removeChild(el);
        }
      });

      const notification = document.createElement('div');
      notification.className = `notification ${bgColor}`;
      notification.innerHTML = `
        <div class="flex items-center">
          <i class="fas ${icon} mr-2"></i>
          <span>${message}</span>
        </div>
      `;
      
      document.body.appendChild(notification);
      
      // Auto hide after 3 seconds (sauf si c'est une notification de type info qui peut rester plus longtemps)
      const timeout = type === "info" ? 2000 : 3000;
      setTimeout(() => {
        notification.classList.add('hiding');
        
        // Remove from DOM after animation completes
        setTimeout(() => {
          if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
          }
        }, 300);
      }, timeout);
    }

    // Initialize pagination event handlers for grid view
    document.addEventListener('DOMContentLoaded', function() {
      // Existing event listeners...
      
      // Grid pagination event handlers
      document.getElementById('paginationGrid').addEventListener('click', (e) => {
        const target = e.target.closest('[data-page]');
        if (target) {
          const page = Number.parseInt(target.getAttribute('data-page'));
          if (!isNaN(page)) {
            currentPageGrid = page;
            updateGrid();
            updatePaginationGrid();
          }
        }
      });
      
      document.getElementById('prevPageGrid').addEventListener('click', () => {
        if (currentPageGrid > 1) {
          currentPageGrid--;
          updateGrid();
          updatePaginationGrid();
        }
      });
      
      document.getElementById('nextPageGrid').addEventListener('click', () => {
        const searchTerm = document.querySelector(".search-input").value.toLowerCase();
        const filteredArticles = articles.filter(
          (article) =>
            (article.titre && article.titre.toLowerCase().includes(searchTerm)) ||
            (article.auteur && article.auteur.toLowerCase().includes(searchTerm)) ||
            (article.genre && article.genre.toLowerCase().includes(searchTerm)) ||
            (article.isbn && article.isbn.includes(searchTerm)) ||
            (article.description && article.description.toLowerCase().includes(searchTerm)) ||
            (article.langue && article.langue.toLowerCase().includes(searchTerm))
        );
        const totalFilteredPages = Math.ceil(filteredArticles.length / itemsPerPageGrid);
        
        if (currentPageGrid < totalFilteredPages) {
          currentPageGrid++;
          updateGrid();
          updatePaginationGrid();
        }
      });
    });
  </script>
</body>

</html>