<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-home mr-3"></i>
              <span>Accueil</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-users mr-3"></i>
              <span>Users</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-truck mr-3"></i>
              <span>Livreurs</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-credit-card mr-3"></i>
              <span>Payments</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="#" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
              <div class="text-white text-sm font-medium">Admin</div>
              <div class="text-white text-xs opacity-70">admin@mybookspace.com</div>
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
      <div class="sidebar bg-primary w-64 h-full transform -translate-x-full transition-transform duration-300 ease-in-out">
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
              <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-home mr-3"></i>
                <span>Accueil</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-users mr-3"></i>
                <span>Users</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-truck mr-3"></i>
                <span>Livreurs</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-credit-card mr-3"></i>
                <span>Payments</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="#" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
                <div class="text-white text-sm font-medium">Admin</div>
                <div class="text-white text-xs opacity-70">admin@mybookspace.com</div>
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
          <div class="flex items-center">
            <div class="relative mr-4">
              <input type="text" placeholder="Rechercher..." class="search-input bg-gray-100 rounded-full py-2 px-4 pl-10 focus:outline-none transition duration-200 w-64">
              <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <div class="relative">
              <button class="relative p-2 text-gray-600 hover:text-primary focus:outline-none">
                <i class="fas fa-bell text-xl"></i>
                <span class="absolute top-0 right-0 bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs">3</span>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Articles content -->
      <main class="p-6 bg-secondary min-h-screen">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Liste des Articles</h2>
            <button id="addArticleBtn" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md flex items-center transition duration-200 action-button">
              <i class="fas fa-plus mr-2"></i>
              <span>Ajouter un article</span>
            </button>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
              <thead>
                <tr class="bg-gray-50 border-b">
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auteur</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock disponible</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre d'emprunts</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody id="articlesTableBody">
                <!-- Table rows will be populated by JavaScript -->
              </tbody>
            </table>
          </div>
          
          <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
              Affichage de <span id="startEntry">1</span> à <span id="endEntry">5</span> sur <span id="totalEntries">50</span> entrées
            </div>
            <div class="flex items-center space-x-1" id="pagination">
              <button class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-l-md hover:bg-gray-300 transition-colors" id="prevPage">
                <i class="fas fa-chevron-left"></i>
              </button>
              
              <button class="pagination-button min-w-[40px] px-3 py-1.5 bg-primary text-white font-medium hover:bg-primary-dark transition-colors" data-page="1">1</button>
              <button class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" data-page="2">2</button>
              <button class="pagination-button min-w-[40px] px-3 py-1.5 bg-gray-200 text-gray-700 hover:bg-gray-300 transition-colors" data-page="3">3</button>
              
              <button class="pagination-button px-3 py-1.5 bg-gray-200 text-gray-700 rounded-r-md hover:bg-gray-300 transition-colors" id="nextPage">
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
      
      <form id="addArticleForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="titre" class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" id="titre" name="titre" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="auteur" class="block text-sm font-medium text-gray-700 mb-1">Auteur</label>
            <input type="text" id="auteur" name="auteur" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="id_categorie" class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
            <select id="id_categorie" name="id_categorie" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
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
            <input type="number" id="annee_pub" name="annee_pub" min="1000" max="2099" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
            <input type="text" id="isbn" name="isbn" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="langue" class="block text-sm font-medium text-gray-700 mb-1">Langue</label>
            <select id="langue" name="langue" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
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
            <input type="number" id="qte" name="qte" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="prix_emprunt" class="block text-sm font-medium text-gray-700 mb-1">Prix d'emprunt</label>
            <input type="number" id="prix_emprunt" name="prix_emprunt" min="0" step="0.01" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div class="md:col-span-2">
            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Image (URL)</label>
            <input type="text" id="image" name="image" placeholder="https://example.com/image.jpg" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div class="md:col-span-2">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
            <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" id="cancelAddArticle" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
            Annuler
          </button>
          <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Wait for DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", () => {
      // Create logo
      createLogo();

      // Sample data for articles
      const articles = [
        {
          id: 1,
          id_article: 1,
          titre: "Le Petit Prince",
          auteur: "Antoine de Saint-Exupéry",
          genre: "Fiction",
          id_categorie: 1,
          annee_pub: 1943,
          isbn: "978-2-07-040850-4",
          qte: 15,
          prix_emprunt: 2.50,
          image: "petit-prince.jpg",
          description: "Un récit poétique et philosophique sous l'apparence d'un conte pour enfants.",
          langue: "Français",
          loans: 120,
        },
        {
          id: 2,
          id_article: 2,
          titre: "1984",
          auteur: "George Orwell",
          genre: "Science-fiction",
          id_categorie: 2,
          annee_pub: 1949,
          isbn: "978-2-07-036822-8",
          qte: 8,
          prix_emprunt: 3.00,
          image: "1984.jpg",
          description: "Une dystopie politique et sociale décrivant un futur où la société est soumise à une dictature totalitaire.",
          langue: "Anglais",
          loans: 95,
        },
        {
          id: 3,
          id_article: 3,
          titre: "Harry Potter à l'école des sorciers",
          auteur: "J.K. Rowling",
          genre: "Fantasy",
          id_categorie: 3,
          annee_pub: 1997,
          isbn: "978-2-07-054090-1",
          qte: 20,
          prix_emprunt: 3.50,
          image: "harry-potter.jpg",
          description: "Le premier tome des aventures du jeune sorcier Harry Potter.",
          langue: "Anglais",
          loans: 200,
        },
        {
          id: 4,
          id_article: 4,
          titre: "L'Étranger",
          auteur: "Albert Camus",
          genre: "Roman",
          id_categorie: 4,
          annee_pub: 1942,
          isbn: "978-2-07-036002-4",
          qte: 12,
          prix_emprunt: 2.00,
          image: "etranger.jpg",
          description: "Un roman existentialiste qui explore l'absurdité de la vie humaine.",
          langue: "Français",
          loans: 85,
        },
        {
          id: 5,
          id_article: 5,
          titre: "Les Misérables",
          auteur: "Victor Hugo",
          genre: "Roman historique",
          id_categorie: 5,
          annee_pub: 1862,
          isbn: "978-2-253-09634-8",
          qte: 5,
          prix_emprunt: 4.00,
          image: "miserables.jpg",
          description: "Un roman historique, social et philosophique dans lequel on retrouve les idéaux du romantisme.",
          langue: "Français",
          loans: 60,
        },
        {
          id: 6,
          id_article: 6,
          titre: "Voyage au centre de la Terre",
          auteur: "Jules Verne",
          genre: "Science-fiction",
          id_categorie: 2,
          annee_pub: 1864,
          isbn: "978-2-01-002461-3",
          qte: 10,
          prix_emprunt: 2.75,
          image: "voyage-centre-terre.jpg",
          description: "Un roman d'aventures et de science-fiction relatant le voyage de trois personnages au centre de la Terre.",
          langue: "Français",
          loans: 75,
        },
        {
          id: 7,
          id_article: 7,
          titre: "Le Comte de Monte-Cristo",
          auteur: "Alexandre Dumas",
          genre: "Roman historique",
          id_categorie: 5,
          annee_pub: 1844,
          isbn: "978-2-07-041776-6",
          qte: 7,
          prix_emprunt: 3.25,
          image: "monte-cristo.jpg",
          description: "Un roman d'aventures sur le thème de la vengeance et de la justice.",
          langue: "Français",
          loans: 110,
        },
        {
          id: 8,
          id_article: 8,
          titre: "Orgueil et Préjugés",
          auteur: "Jane Austen",
          genre: "Roman",
          id_categorie: 4,
          annee_pub: 1813,
          isbn: "978-2-07-037689-6",
          qte: 9,
          prix_emprunt: 2.50,
          image: "orgueil-prejuges.jpg",
          description: "Un roman qui dépeint avec humour et finesse la société anglaise du début du XIXe siècle.",
          langue: "Anglais",
          loans: 88,
        },
        {
          id: 9,
          id_article: 9,
          titre: "Don Quichotte",
          auteur: "Miguel de Cervantes",
          genre: "Roman",
          id_categorie: 4,
          annee_pub: 1605,
          isbn: "978-2-07-011669-5",
          qte: 6,
          prix_emprunt: 3.50,
          image: "don-quichotte.jpg",
          description: "Un roman qui parodie les récits chevaleresques et explore les thèmes de l'idéalisme et de la réalité.",
          langue: "Espagnol",
          loans: 65,
        },
        {
          id: 10,
          id_article: 10,
          titre: "Guerre et Paix",
          auteur: "Léon Tolstoï",
          genre: "Roman historique",
          id_categorie: 5,
          annee_pub: 1869,
          isbn: "978-2-07-010361-9",
          qte: 4,
          prix_emprunt: 4.50,
          image: "guerre-paix.jpg",
          description: "Une fresque historique qui dépeint la société russe pendant les guerres napoléoniennes.",
          langue: "Russe",
          loans: 50,
        },
      ];

      // Pagination variables
      let currentPage = 1;
      const itemsPerPage = 5;
      const totalPages = Math.ceil(articles.length / itemsPerPage);

      // Initialize the table
      updateTable();
      updatePagination();

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
        }
      });

      document.getElementById("nextPage").addEventListener("click", () => {
        if (currentPage < totalPages) {
          currentPage++;
          updateTable();
          updatePagination();
        }
      });

      // Page number buttons
      document.querySelectorAll(".pagination-button[data-page]").forEach((button) => {
        button.addEventListener("click", function () {
          currentPage = Number.parseInt(this.getAttribute("data-page"));
          updateTable();
          updatePagination();
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

      // Form submission
      addArticleForm.addEventListener("submit", (e) => {
        e.preventDefault();

        // Get form values
        const newArticle = {
          id: articles.length + 1,
          id_article: articles.length + 1,
          titre: document.getElementById("titre").value,
          auteur: document.getElementById("auteur").value,
          id_categorie: document.getElementById("id_categorie").value,
          genre: document.getElementById("id_categorie").options[document.getElementById("id_categorie").selectedIndex].text,
          annee_pub: Number.parseInt(document.getElementById("annee_pub").value),
          isbn: document.getElementById("isbn").value,
          langue: document.getElementById("langue").value,
          qte: Number.parseInt(document.getElementById("qte").value),
          prix_emprunt: Number.parseFloat(document.getElementById("prix_emprunt").value),
          image: document.getElementById("image").value,
          description: document.getElementById("description").value,
          loans: 0 // Nouvelle entrée, pas encore d'emprunts
        };

        // Add to articles array
        articles.unshift(newArticle);

        // Update table and pagination
        currentPage = 1;
        updateTable();
        updatePagination();

        // Close modal
        closeModalFunction();

        // Show success notification
        showNotification("Article ajouté avec succès!");
      });

      // Search functionality
      const searchInput = document.querySelector(".search-input");
      searchInput.addEventListener("input", () => {
        currentPage = 1;
        updateTable();
        updatePagination();
      });

      // Function to update the table based on current page and search
      function updateTable() {
        const tableBody = document.getElementById("articlesTableBody");
        tableBody.innerHTML = "";

        const searchTerm = searchInput.value.toLowerCase();
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

          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${article.titre}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.auteur}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.genre}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.isbn}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.qte}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${article.loans}</td>
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

      // Function to update pagination buttons
      function updatePagination() {
        const searchTerm = searchInput.value.toLowerCase();
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
    });

    // Global functions for table actions
    function editArticle(id) {
      showNotification("Modification de l'article #" + id);
    }

    function deleteArticle(id) {
      if (confirm("Êtes-vous sûr de vouloir supprimer cet article?")) {
        showNotification("Article #" + id + " supprimé avec succès!");
        // In a real application, you would remove the article from the array and update the table
      }
    }

    function viewArticleDetails(id) {
      showNotification("Affichage des détails de l'article #" + id);
    }

    function showNotification(message) {
      // Remove any existing notifications
      const existingNotifications = document.querySelectorAll('.notification');
      existingNotifications.forEach(notification => {
        notification.remove();
      });

      // Create new notification
      const notification = document.createElement("div");
      notification.className = "notification";
      notification.textContent = message;

      document.body.appendChild(notification);

      // Remove notification after delay
      setTimeout(() => {
        notification.classList.add("hiding");
        setTimeout(() => {
          if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
          }
        }, 300);
      }, 3000);
    }
  </script>
</body>
</html>