<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBookSpace - Tableau de Bord Utilisateurs</title>
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

    .stat-card {
      transition: all 0.3s ease;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .chart-container {
      height: 300px;
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
            <a href="{{ route('bibliothecaire.dashboard.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-home mr-3"></i>
              <span>Accueil</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.user.index') }}" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-users mr-3"></i>
              <span>Users</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.livreur.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-truck mr-3"></i>
              <span>Livreurs</span>
            </a>
          </li>
          <li class="px-4 py-2">
            <a href="" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-credit-card mr-3"></i>
              <span>Orders</span>
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
              <a href="{{ route('bibliothecaire.user.index') }}" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-users mr-3"></i>
                <span>Users</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{ route('bibliothecaire.livreur.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
          <h1 class="text-2xl font-semibold text-gray-800">Tableau de Bord Utilisateurs</h1>
          
        </div>
      </header>

      <!-- Dashboard content -->
      <main class="p-6 bg-secondary min-h-screen">
       
        
        
        <!-- Users Table -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Liste des Utilisateurs</h2>
            <div class="flex space-x-2">
              <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md flex items-center transition duration-200">
                <i class="fas fa-filter mr-2"></i>
                <span>Filtrer</span>
              </button>
              <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md flex items-center transition duration-200">
                <i class="fas fa-download mr-2"></i>
                <span>Exporter</span>
              </button>
            </div>
          </div>
          
          <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
              <thead>
                <tr class="bg-gray-50 border-b">
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière connexion</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody id="usersTableBody">
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
        
        <!-- Recent Activity -->
        
      </main>
    </div>
  </div>

  <!-- View User Details Modal -->
  <div id="viewUserModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
      <button id="closeViewModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Détails de l'utilisateur</h2>
      
      <div id="userDetails" class="space-y-4">
        <!-- User details will be populated by JavaScript -->
      </div>
      
      <div class="flex justify-end space-x-3 pt-6">
        <button type="button" id="closeViewModalBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
          Fermer
        </button>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    // Wait for DOM to be fully loaded
    document.addEventListener("DOMContentLoaded", () => {
      // Create logo
      createLogo();

      // Sample data for users based on the provided database structure
      const users = [
        {
          id_utilisateur: 1,
          id: 101,
          email: "admin@mybookspace.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 1, // Admin
          remember_token: "token123",
          last_login: "2023-05-15 08:30:45",
          status: "Actif"
        },
        {
          id_utilisateur: 2,
          id: 102,
          email: "jean.dupont@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 2, // Modérateur
          remember_token: "token456",
          last_login: "2023-05-14 14:22:10",
          status: "Actif"
        },
        {
          id_utilisateur: 3,
          id: 103,
          email: "marie.martin@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "token789",
          last_login: "2023-05-13 09:15:30",
          status: "Actif"
        },
        {
          id_utilisateur: 4,
          id: 104,
          email: "thomas.bernard@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenABC",
          last_login: "2023-05-12 16:45:20",
          status: "Inactif"
        },
        {
          id_utilisateur: 5,
          id: 105,
          email: "sophie.petit@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenDEF",
          last_login: "2023-05-11 11:10:05",
          status: "Actif"
        },
        {
          id_utilisateur: 6,
          id: 106,
          email: "lucas.moreau@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 2, // Modérateur
          remember_token: "tokenGHI",
          last_login: "2023-05-10 13:25:40",
          status: "Actif"
        },
        {
          id_utilisateur: 7,
          id: 107,
          email: "emma.leroy@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenJKL",
          last_login: "2023-05-09 10:05:15",
          status: "Actif"
        },
        {
          id_utilisateur: 8,
          id: 108,
          email: "hugo.simon@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenMNO",
          last_login: "2023-05-08 17:30:25",
          status: "Bloqué"
        },
        {
          id_utilisateur: 9,
          id: 109,
          email: "lea.garcia@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenPQR",
          last_login: "2023-05-07 08:50:35",
          status: "Actif"
        },
        {
          id_utilisateur: 10,
          id: 110,
          email: "nathan.roux@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenSTU",
          last_login: "2023-05-06 15:15:55",
          status: "Actif"
        },
        {
          id_utilisateur: 11,
          id: 111,
          email: "chloe.fournier@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 3, // Client
          remember_token: "tokenVWX",
          last_login: "2023-05-05 12:40:10",
          status: "Actif"
        },
        {
          id_utilisateur: 12,
          id: 112,
          email: "maxime.girard@example.com",
          mot_de_passe: "$2y$10$hashed_password_here",
          id_role: 1, // Admin
          remember_token: "tokenYZ1",
          last_login: "2023-05-04 09:20:30",
          status: "Actif"
        }
      ];

      // Role mapping
      const roles = {
        1: { name: "Administrateur", color: "bg-red-100 text-red-800" },
        2: { name: "Modérateur", color: "bg-blue-100 text-blue-800" },
        3: { name: "Client", color: "bg-green-100 text-green-800" }
      };

      // Pagination variables
      let currentPage = 1;
      const itemsPerPage = 5;
      const totalPages = Math.ceil(users.length / itemsPerPage);

      // Initialize the dashboard
      updateStats();
      initCharts();
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

      // View User Modal functionality
      const viewUserModal = document.getElementById("viewUserModal");
      const closeViewModal = document.getElementById("closeViewModal");
      const closeViewModalBtn = document.getElementById("closeViewModalBtn");
      const userDetails = document.getElementById("userDetails");

      function closeViewModalFunction() {
        viewUserModal.classList.add("hidden");
        document.body.style.overflow = "auto";
      }

      closeViewModal.addEventListener("click", closeViewModalFunction);
      closeViewModalBtn.addEventListener("click", closeViewModalFunction);

      // Close view modal when clicking outside
      viewUserModal.addEventListener("click", (e) => {
        if (e.target === viewUserModal) {
          closeViewModalFunction();
        }
      });

      // Search functionality
      const searchInput = document.querySelector(".search-input");
      searchInput.addEventListener("input", () => {
        currentPage = 1;
        updateTable();
        updatePagination();
      });

      // Function to update dashboard stats
      function updateStats() {
        const totalUsersCount = users.length;
        const activeUsersCount = users.filter(user => user.status === "Actif").length;
        const newUsersCount = 5; // Simulated value for new users in last 30 days
        const adminUsersCount = users.filter(user => user.id_role === 1).length;

        document.getElementById("totalUsers").textContent = totalUsersCount;
        document.getElementById("activeUsers").textContent = activeUsersCount;
        document.getElementById("newUsers").textContent = newUsersCount;
        document.getElementById("adminUsers").textContent = adminUsersCount;
      }

      // Function to initialize charts
      function initCharts() {
        // New users chart (last 6 months)
        const months = ["Décembre", "Janvier", "Février", "Mars", "Avril", "Mai"];
        const newUsersData = [3, 5, 2, 7, 4, 6]; // Simulated data

        const newUsersCtx = document.getElementById("newUsersChart").getContext("2d");
        new Chart(newUsersCtx, {
          type: "line",
          data: {
            labels: months,
            datasets: [{
              label: "Nouveaux utilisateurs",
              data: newUsersData,
              backgroundColor: "rgba(59, 130, 246, 0.2)",
              borderColor: "rgba(59, 130, 246, 1)",
              borderWidth: 2,
              tension: 0.3,
              fill: true,
              pointBackgroundColor: "rgba(59, 130, 246, 1)",
              pointRadius: 4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  precision: 0
                }
              }
            },
            plugins: {
              legend: {
                display: false
              }
            }
          }
        });

        // Roles distribution chart
        const roleLabels = ["Administrateurs", "Modérateurs", "Clients"];
        const roleData = [
          users.filter(user => user.id_role === 1).length,
          users.filter(user => user.id_role === 2).length,
          users.filter(user => user.id_role === 3).length
        ];
        const roleColors = [
          "rgba(239, 68, 68, 0.7)",
          "rgba(59, 130, 246, 0.7)",
          "rgba(16, 185, 129, 0.7)"
        ];

        const rolesCtx = document.getElementById("rolesChart").getContext("2d");
        new Chart(rolesCtx, {
          type: "doughnut",
          data: {
            labels: roleLabels,
            datasets: [{
              data: roleData,
              backgroundColor: roleColors,
              borderColor: "white",
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: "right"
              }
            },
            cutout: "60%"
          }
        });
      }

      // Function to update the table based on current page and search
      function updateTable() {
        const tableBody = document.getElementById("usersTableBody");
        tableBody.innerHTML = "";

        const searchTerm = searchInput.value.toLowerCase();
        const filteredUsers = users.filter(
          (user) =>
            user.email.toLowerCase().includes(searchTerm) ||
            roles[user.id_role].name.toLowerCase().includes(searchTerm) ||
            user.status.toLowerCase().includes(searchTerm)
        );

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredUsers.length);

        // Update pagination info
        document.getElementById("startEntry").textContent = filteredUsers.length > 0 ? startIndex + 1 : 0;
        document.getElementById("endEntry").textContent = endIndex;
        document.getElementById("totalEntries").textContent = filteredUsers.length;

        // Create table rows
        for (let i = startIndex; i < endIndex; i++) {
          const user = filteredUsers[i];
          const row = document.createElement("tr");
          row.className = "table-row border-b hover:bg-gray-50";

          // Status badge color
          let statusColor = "";
          switch(user.status) {
            case "Actif":
              statusColor = "bg-green-100 text-green-800";
              break;
            case "Inactif":
              statusColor = "bg-yellow-100 text-yellow-800";
              break;
            case "Bloqué":
              statusColor = "bg-red-100 text-red-800";
              break;
            default:
              statusColor = "bg-gray-100 text-gray-800";
          }

          // Format last login date
          const lastLogin = new Date(user.last_login);
          const formattedLastLogin = lastLogin.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          });

          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${user.id_utilisateur}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${user.email}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${roles[user.id_role].color}">
                ${roles[user.id_role].name}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedLastLogin}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                ${user.status}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <div class="flex space-x-2">
                <button class="action-button bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="editUser(${user.id_utilisateur})">
                  <i class="fas fa-edit mr-1"></i> Modifier
                </button>
                <button class="action-button bg-gray-600 hover:bg-gray-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="viewUserDetails(${user.id_utilisateur})">
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
        const filteredUsers = users.filter(
          (user) =>
            user.email.toLowerCase().includes(searchTerm) ||
            roles[user.id_role].name.toLowerCase().includes(searchTerm) ||
            user.status.toLowerCase().includes(searchTerm)
        );

        const totalFilteredPages = Math.ceil(filteredUsers.length / itemsPerPage);

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
      window.editUser = function(id) {
        showNotification("Modification de l'utilisateur #" + id);
      };

      window.viewUserDetails = function(id) {
        const user = users.find(user => user.id_utilisateur === id);
        if (user) {
          // Format last login date
          const lastLogin = new Date(user.last_login);
          const formattedLastLogin = lastLogin.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          });

          // Status badge color
          let statusColor = "";
          switch(user.status) {
            case "Actif":
              statusColor = "bg-green-100 text-green-800";
              break;
            case "Inactif":
              statusColor = "bg-yellow-100 text-yellow-800";
              break;
            case "Bloqué":
              statusColor = "bg-red-100 text-red-800";
              break;
            default:
              statusColor = "bg-gray-100 text-gray-800";
          }

          // Populate user details
          userDetails.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-4">
                <div class="flex items-center space-x-4">
                  <div class="w-16 h-16 bg-primary-light rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    ${user.email.charAt(0).toUpperCase()}
                  </div>
                  <div>
                    <h3 class="text-xl font-semibold text-gray-800">${user.email}</h3>
                    <p class="text-gray-600">ID: ${user.id_utilisateur}</p>
                  </div>
                </div>
                <div class="pt-2">
                  <p class="text-gray-600"><span class="font-medium">ID Système:</span> ${user.id}</p>
                  <p class="text-gray-600"><span class="font-medium">Rôle:</span> 
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${roles[user.id_role].color}">
                      ${roles[user.id_role].name}
                    </span>
                  </p>
                  <p class="text-gray-600"><span class="font-medium">Statut:</span> 
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">
                      ${user.status}
                    </span>
                  </p>
                  <p class="text-gray-600"><span class="font-medium">Dernière connexion:</span> ${formattedLastLogin}</p>
                </div>
              </div>
              <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="text-lg font-medium text-gray-800 mb-2">Activité récente</h4>
                  <div class="space-y-2">
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Dernière connexion</span>
                      <span class="font-medium">${formattedLastLogin}</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Emprunts actifs</span>
                      <span class="font-medium">${Math.floor(Math.random() * 5)}</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Emprunts totaux</span>
                      <span class="font-medium">${Math.floor(Math.random() * 20) + 5}</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Retards</span>
                      <span class="font-medium">${Math.floor(Math.random() * 3)}</span>
                    </div>
                  </div>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <h4 class="text-lg font-medium text-gray-800 mb-2">Sécurité</h4>
                  <div class="space-y-2">
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Authentification à deux facteurs</span>
                      <span class="font-medium text-red-600">Désactivée</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Dernière modification du mot de passe</span>
                      <span class="font-medium">Il y a 45 jours</span>
                    </div>
                    <div class="flex items-center justify-between">
                      <span class="text-gray-600">Tentatives de connexion échouées</span>
                      <span class="font-medium">0</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mt-6 bg-gray-50 p-4 rounded-lg">
              <h4 class="text-lg font-medium text-gray-800 mb-2">Derniers emprunts</h4>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Livre</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date de retour</th>
                      <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200">
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 1000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Le Petit Prince</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() + 1000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">En cours</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 3000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">1984</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 2000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Retourné</span>
                      </td>
                    </tr>
                    <tr>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 5000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">Harry Potter à l'école des sorciers</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">${new Date(Date.now() - 4000000000).toLocaleDateString('fr-FR')}</td>
                      <td class="px-4 py-2 whitespace-nowrap text-sm">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Retourné</span>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          `;

          // Show modal
          viewUserModal.classList.remove("hidden");
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
