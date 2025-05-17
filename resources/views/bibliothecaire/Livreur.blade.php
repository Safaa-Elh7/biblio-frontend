<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBookSpace - Gestion des Livreurs</title>
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
            <a href="#" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
            <a href="#" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
              <a href="{{ route('bibliothecaire.dashboard.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
              <a href="{{ route('bibliothecaire.livreur.index') }} " class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
              <a href="{{ route('bibliothecaire.article.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
          <h1 class="text-2xl font-semibold text-gray-800">Gestion des Livreurs</h1>
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

      <!-- Livreurs content -->
      <main class="p-6 bg-secondary min-h-screen">
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Liste des Livreurs</h2>
            <button id="addLivreurBtn" class="bg-primary hover:bg-primary-dark text-white py-2 px-4 rounded-md flex items-center transition duration-200 action-button">
              <i class="fas fa-plus mr-2"></i>
              <span>Ajouter un livreur</span>
            </button>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
              <thead>
                <tr class="bg-gray-50 border-b">
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Zone de livraison</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Moyen de transport</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livraisons</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody id="livreursTableBody">
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

  <!-- Add Livreur Modal -->
  <div id="addLivreurModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
      <button id="closeModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ajouter un livreur</h2>
      
      <form id="addLivreurForm" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
            <input type="text" id="nom" name="nom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="zone_livraison" class="block text-sm font-medium text-gray-700 mb-1">Zone de livraison</label>
            <select id="zone_livraison" name="zone_livraison" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
              <option value="">Sélectionner une zone</option>
              <option value="Centre-ville">Centre-ville</option>
              <option value="Nord">Nord</option>
              <option value="Sud">Sud</option>
              <option value="Est">Est</option>
              <option value="Ouest">Ouest</option>
              <option value="Banlieue">Banlieue</option>
            </select>
          </div>
          <div>
            <label for="moyen_transport" class="block text-sm font-medium text-gray-700 mb-1">Moyen de transport</label>
            <select id="moyen_transport" name="moyen_transport" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
              <option value="">Sélectionner un moyen de transport</option>
              <option value="Voiture">Voiture</option>
              <option value="Moto">Moto</option>
              <option value="Vélo">Vélo</option>
              <option value="Scooter">Scooter</option>
              <option value="À pied">À pied</option>
            </select>
          </div>
          <div>
            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
          <div>
            <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
            <select id="statut" name="statut" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
              <option value="Actif">Actif</option>
              <option value="Inactif">Inactif</option>
              <option value="En congé">En congé</option>
            </select>
          </div>
          <div>
            <label for="date_embauche" class="block text-sm font-medium text-gray-700 mb-1">Date d'embauche</label>
            <input type="date" id="date_embauche" name="date_embauche" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          </div>
        </div>
        
        <div class="flex justify-end space-x-3 pt-4">
          <button type="button" id="cancelAddLivreur" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
            Annuler
          </button>
          <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>

  <!-- View Livreur Details Modal -->
  <div id="viewLivreurModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
      <button id="closeViewModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Détails du livreur</h2>
      
      <div id="livreurDetails" class="space-y-4">
        <!-- Livreur details will be populated by JavaScript -->
      </div>
      
      <div class="flex justify-end space-x-3 pt-6">
        <button type="button" id="closeViewModalBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
          Fermer
        </button>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Wait for DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", () => {
      // Create logo
      createLogo();

      // Sample data for livreurs
      const livreurs = [
        {
          id_livreur: 1,
          nom: "Dupont",
          prenom: "Jean",
          zone_livraison: "Centre-ville",
          moyen_transport: "Vélo",
          telephone: "06 12 34 56 78",
          email: "jean.dupont@mybookspace.com",
          statut: "Actif",
          date_embauche: "2022-03-15",
          livraisons: 145
        },
        {
          id_livreur: 2,
          nom: "Martin",
          prenom: "Sophie",
          zone_livraison: "Nord",
          moyen_transport: "Scooter",
          telephone: "06 23 45 67 89",
          email: "sophie.martin@mybookspace.com",
          statut: "Actif",
          date_embauche: "2022-05-20",
          livraisons: 98
        },
        {
          id_livreur: 3,
          nom: "Leroy",
          prenom: "Thomas",
          zone_livraison: "Sud",
          moyen_transport: "Voiture",
          telephone: "06 34 56 78 90",
          email: "thomas.leroy@mybookspace.com",
          statut: "En congé",
          date_embauche: "2021-11-10",
          livraisons: 210
        },
        {
          id_livreur: 4,
          nom: "Dubois",
          prenom: "Marie",
          zone_livraison: "Est",
          moyen_transport: "Moto",
          telephone: "06 45 67 89 01",
          email: "marie.dubois@mybookspace.com",
          statut: "Actif",
          date_embauche: "2023-01-05",
          livraisons: 67
        },
        {
          id_livreur: 5,
          nom: "Petit",
          prenom: "Lucas",
          zone_livraison: "Ouest",
          moyen_transport: "Vélo",
          telephone: "06 56 78 90 12",
          email: "lucas.petit@mybookspace.com",
          statut: "Actif",
          date_embauche: "2022-09-18",
          livraisons: 112
        },
        {
          id_livreur: 6,
          nom: "Moreau",
          prenom: "Emma",
          zone_livraison: "Centre-ville",
          moyen_transport: "À pied",
          telephone: "06 67 89 01 23",
          email: "emma.moreau@mybookspace.com",
          statut: "Inactif",
          date_embauche: "2021-07-22",
          livraisons: 89
        },
        {
          id_livreur: 7,
          nom: "Simon",
          prenom: "Hugo",
          zone_livraison: "Banlieue",
          moyen_transport: "Voiture",
          telephone: "06 78 90 12 34",
          email: "hugo.simon@mybookspace.com",
          statut: "Actif",
          date_embauche: "2022-11-30",
          livraisons: 156
        },
        {
          id_livreur: 8,
          nom: "Garcia",
          prenom: "Léa",
          zone_livraison: "Nord",
          moyen_transport: "Scooter",
          telephone: "06 89 01 23 45",
          email: "lea.garcia@mybookspace.com",
          statut: "Actif",
          date_embauche: "2023-02-14",
          livraisons: 42
        },
        {
          id_livreur: 9,
          nom: "Roux",
          prenom: "Nathan",
          zone_livraison: "Sud",
          moyen_transport: "Moto",
          telephone: "06 90 12 34 56",
          email: "nathan.roux@mybookspace.com",
          statut: "En congé",
          date_embauche: "2022-06-08",
          livraisons: 134
        },
        {
          id_livreur: 10,
          nom: "Fournier",
          prenom: "Chloé",
          zone_livraison: "Est",
          moyen_transport: "Vélo",
          telephone: "06 01 23 45 67",
          email: "chloe.fournier@mybookspace.com",
          statut: "Actif",
          date_embauche: "2022-08-25",
          livraisons: 87
        }
      ];

      // Pagination variables
      let currentPage = 1;
      const itemsPerPage = 5;
      const totalPages = Math.ceil(livreurs.length / itemsPerPage);

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

      // Add Livreur Modal functionality
      const addLivreurBtn = document.getElementById("addLivreurBtn");
      const addLivreurModal = document.getElementById("addLivreurModal");
      const closeModal = document.getElementById("closeModal");
      const cancelAddLivreur = document.getElementById("cancelAddLivreur");
      const addLivreurForm = document.getElementById("addLivreurForm");

      addLivreurBtn.addEventListener("click", () => {
        addLivreurModal.classList.remove("hidden");
        document.body.style.overflow = "hidden";
      });

      function closeModalFunction() {
        addLivreurModal.classList.add("hidden");
        document.body.style.overflow = "auto";
        addLivreurForm.reset();
      }

      closeModal.addEventListener("click", closeModalFunction);
      cancelAddLivreur.addEventListener("click", closeModalFunction);

      // Close modal when clicking outside
      addLivreurModal.addEventListener("click", (e) => {
        if (e.target === addLivreurModal) {
          closeModalFunction();
        }
      });

      // View Livreur Modal functionality
      const viewLivreurModal = document.getElementById("viewLivreurModal");
      const closeViewModal = document.getElementById("closeViewModal");
      const closeViewModalBtn = document.getElementById("closeViewModalBtn");
      const livreurDetails = document.getElementById("livreurDetails");

      function closeViewModalFunction() {
        viewLivreurModal.classList.add("hidden");
        document.body.style.overflow = "auto";
      }

      closeViewModal.addEventListener("click", closeViewModalFunction);
      closeViewModalBtn.addEventListener("click", closeViewModalFunction);

      // Close view modal when clicking outside
      viewLivreurModal.addEventListener("click", (e) => {
        if (e.target === viewLivreurModal) {
          closeViewModalFunction();
        }
      });

      // Form submission
      addLivreurForm.addEventListener("submit", (e) => {
        e.preventDefault();

        // Get form values
        const newLivreur = {
          id_livreur: livreurs.length + 1,
          nom: document.getElementById("nom").value,
          prenom: document.getElementById("prenom").value,
          zone_livraison: document.getElementById("zone_livraison").value,
          moyen_transport: document.getElementById("moyen_transport").value,
          telephone: document.getElementById("telephone").value,
          email: document.getElementById("email").value,
          statut: document.getElementById("statut").value,
          date_embauche: document.getElementById("date_embauche").value,
          livraisons: 0 // Nouveau livreur, pas encore de livraisons
        };

        // Add to livreurs array
        livreurs.unshift(newLivreur);

        // Update table and pagination
        currentPage = 1;
        updateTable();
        updatePagination();

        // Close modal
        closeModalFunction();

        // Show success notification
        showNotification("Livreur ajouté avec succès!");
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
        const tableBody = document.getElementById("livreursTableBody");
        tableBody.innerHTML = "";

        const searchTerm = searchInput.value.toLowerCase();
        const filteredLivreurs = livreurs.filter(
          (livreur) =>
            (livreur.nom && livreur.nom.toLowerCase().includes(searchTerm)) ||
            (livreur.prenom && livreur.prenom.toLowerCase().includes(searchTerm)) ||
            (livreur.zone_livraison && livreur.zone_livraison.toLowerCase().includes(searchTerm)) ||
            (livreur.moyen_transport && livreur.moyen_transport.toLowerCase().includes(searchTerm)) ||
            (livreur.email && livreur.email.toLowerCase().includes(searchTerm)) ||
            (livreur.telephone && livreur.telephone.includes(searchTerm))
        );

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredLivreurs.length);

        // Update pagination info
        document.getElementById("startEntry").textContent = filteredLivreurs.length > 0 ? startIndex + 1 : 0;
        document.getElementById("endEntry").textContent = endIndex;
        document.getElementById("totalEntries").textContent = filteredLivreurs.length;

        // Create table rows
        for (let i = startIndex; i < endIndex; i++) {
          const livreur = filteredLivreurs[i];
          const row = document.createElement("tr");
          row.className = "table-row border-b hover:bg-gray-50";

          // Status badge color
          let statusColor = "";
          switch(livreur.statut) {
            case "Actif":
              statusColor = "bg-green-100 text-green-800";
              break;
            case "Inactif":
              statusColor = "bg-red-100 text-red-800";
              break;
            case "En congé":
              statusColor = "bg-yellow-100 text-yellow-800";
              break;
            default:
              statusColor = "bg-gray-100 text-gray-800";
          }

          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${livreur.id_livreur}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${livreur.nom} ${livreur.prenom}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${livreur.zone_livraison}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${livreur.moyen_transport}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                ${livreur.statut}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${livreur.livraisons}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <div class="flex space-x-2">
                <button class="action-button bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="editLivreur(${livreur.id_livreur})">
                  <i class="fas fa-edit mr-1"></i> Modifier
                </button>
                <button class="action-button bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="deleteLivreur(${livreur.id_livreur})">
                  <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
                <button class="action-button bg-gray-600 hover:bg-gray-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="viewLivreurDetails(${livreur.id_livreur})">
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
        const filteredLivreurs = livreurs.filter(
          (livreur) =>
            (livreur.nom && livreur.nom.toLowerCase().includes(searchTerm)) ||
            (livreur.prenom && livreur.prenom.toLowerCase().includes(searchTerm)) ||
            (livreur.zone_livraison && livreur.zone_livraison.toLowerCase().includes(searchTerm)) ||
            (livreur.moyen_transport && livreur.moyen_transport.toLowerCase().includes(searchTerm)) ||
            (livreur.email && livreur.email.toLowerCase().includes(searchTerm)) ||
            (livreur.telephone && livreur.telephone.includes(searchTerm))
        );

        const totalFilteredPages = Math.ceil(filteredLivreurs.length / itemsPerPage);

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

      // Make functions available globally
      window.editLivreur = function(id) {
        showNotification("Modification du livreur #" + id);
      };

      window.deleteLivreur = function(id) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce livreur?")) {
          const index = livreurs.findIndex(livreur => livreur.id_livreur === id);
          if (index !== -1) {
            livreurs.splice(index, 1);
            updateTable();
            updatePagination();
            showNotification("Livreur #" + id + " supprimé avec succès!");
          }
        }
      };

      window.viewLivreurDetails = function(id) {
        const livreur = livreurs.find(livreur => livreur.id_livreur === id);
        if (livreur) {
          // Format date
          const dateEmbauche = new Date(livreur.date_embauche);
          const formattedDate = dateEmbauche.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
          });

          // Status badge color
          let statusColor = "";
          switch(livreur.statut) {
            case "Actif":
              statusColor = "bg-green-100 text-green-800";
              break;
            case "Inactif":
              statusColor = "bg-red-100 text-red-800";
              break;
            case "En congé":
              statusColor = "bg-yellow-100 text-yellow-800";
              break;
            default:
              statusColor = "bg-gray-100 text-gray-800";
          }

          // Populate livreur details
          livreurDetails.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div class="flex items-center space-x-4">
                  <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    ${livreur.prenom.charAt(0)}${livreur.nom.charAt(0)}
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-800">${livreur.prenom} ${livreur.nom}</h3>
                    <p class="text-gray-600">ID: ${livreur.id_livreur}</p>
                  </div>
                </div>
                <div class="pt-2">
                  <p class="text-gray-600"><span class="font-medium">Email:</span> ${livreur.email}</p>
                  <p class="text-gray-600"><span class="font-medium">Téléphone:</span> ${livreur.telephone}</p>
                  <p class="text-gray-600"><span class="font-medium">Date d'embauche:</span> ${formattedDate}</p>
                  <p class="text-gray-600"><span class="font-medium">Statut:</span> 
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                      ${livreur.statut}
                    </span>
                  </p>
                </div>
              </div>
              <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="text-lg font-medium text-gray-800 mb-2">Informations de livraison</h4>
                  <p class="text-gray-600"><span class="font-medium">Zone de livraison:</span> ${livreur.zone_livraison}</p>
                  <p class="text-gray-600"><span class="font-medium">Moyen de transport:</span> ${livreur.moyen_transport}</p>
                  <p class="text-gray-600"><span class="font-medium">Nombre de livraisons:</span> ${livreur.livraisons}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="text-lg font-medium text-gray-800 mb-2">Statistiques</h4>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600">Livraisons ce mois</span>
                    <span class="font-medium">${Math.floor(livreur.livraisons * 0.15)}</span>
                  </div>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600">Livraisons en retard</span>
                    <span class="font-medium">${Math.floor(livreur.livraisons * 0.03)}</span>
                  </div>
                  <div class="flex items-center justify-between">
                    <span class="text-gray-600">Évaluation moyenne</span>
                    <span class="font-medium">4.${Math.floor(Math.random() * 10)}/5</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
              <h4 class="text-lg font-medium text-gray-800 mb-2">Dernières livraisons</h4>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 86400000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Martin Dubois</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">15 Rue des Fleurs, ${livreur.zone_livraison}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Livré</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 172800000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Sophie Bernard</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">8 Avenue du Parc, ${livreur.zone_livraison}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Livré</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 259200000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Lucas Moreau</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">22 Rue de la Gare, ${livreur.zone_livraison}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En retard</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          `;

          // Show modal
          viewLivreurModal.classList.remove("hidden");
          document.body.style.overflow = "hidden";
        }
      };
    });

    // Function to show notifications
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