<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBookSpace - Tableau de bord</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    
    .card {
      transition: all 0.3s ease;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }
  </style>
</head>
<body class="bg-gray-100">
  <div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar bg-primary w-64 flex-shrink-0 hidden md:block">
      <div class="flex items-center justify-center h-16 border-b border-primary-dark">
        <div class="flex items-center">
          <img src="https://via.placeholder.com/40" alt="Logo" class="w-10 h-10 rounded-full">
          <span class="ml-2 text-white text-xl font-semibold">MyBookSpace</span>
        </div>
      </div>
      <div class="py-4">
        <ul>
          <li class="px-4 py-2">
            <a href="{{ route('bibliothecaire.dashboard.index') }}" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
            <a href="{{ route('bibliothecaire.livreur.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
            <img src="https://via.placeholder.com/40" alt="Logo" class="w-10 h-10 rounded-full">
            <span class="ml-2 text-white text-xl font-semibold">MyBookSpace</span>
          </div>
          <button id="closeSidebar" class="text-white">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="py-4">
          <ul>
            <li class="px-4 py-2">
              <a href="#" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
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
              <a href="{{ route('bibliothecaire.livreur.index') }}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-truck mr-3"></i>
                <span>Livreurs</span>
              </a>
            </li>
            <li class="px-4 py-2">
              <a href="{{route('bibliothecaire.payment.show')}}" class="sidebar-item flex items-center text-white py-2 px-4 rounded">
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
              <i class="fas fa-user-shield text-white mr-2"></i>
              <div>
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
          <h1 class="text-2xl font-semibold text-gray-800">Tableau de bord</h1>
          <div class="flex items-center">
            <div class="relative mr-4">
              <input type="text" placeholder="Rechercher..." class="bg-gray-100 rounded-full py-2 px-4 pl-10 focus:outline-none focus:ring-2 focus:ring-primary focus:bg-white transition duration-200 w-64">
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

      <!-- Dashboard content -->
      <main class="p-6 bg-secondary">
        <!-- Stats cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <!-- Emprunts en cours -->
          <div class="bg-white rounded-lg shadow-md p-6 card">
            <div class="flex items-center">
              <div class="bg-blue-100 p-3 rounded-full">
                <i class="fas fa-book text-blue-500"></i>
              </div>
              <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Emprunts en cours</h3>
                <p class="text-3xl font-bold text-gray-800">124</p>
              </div>
            </div>
          </div>
          
          <!-- Retards -->
          <div class="bg-white rounded-lg shadow-md p-6 card">
            <div class="flex items-center">
              <div class="bg-red-100 p-3 rounded-full">
                <i class="fas fa-exclamation-circle text-red-500"></i>
              </div>
              <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Retards</h3>
                <p class="text-3xl font-bold text-gray-800">18</p>
              </div>
            </div>
          </div>
          
          <!-- Livres disponibles -->
          <div class="bg-white rounded-lg shadow-md p-6 card">
            <div class="flex items-center">
              <div class="bg-green-100 p-3 rounded-full">
                <i class="fas fa-check-circle text-green-500"></i>
              </div>
              <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Livres disponibles</h3>
                <p class="text-3xl font-bold text-gray-800">1,254</p>
              </div>
            </div>
          </div>
          
          <!-- Paiements non réglés -->
          <div class="bg-white rounded-lg shadow-md p-6 card">
            <div class="flex items-center">
              <div class="bg-yellow-100 p-3 rounded-full">
                <i class="fas fa-money-bill-wave text-yellow-500"></i>
              </div>
              <div class="ml-4">
                <h3 class="text-gray-500 text-sm">Paiements non réglés</h3>
                <p class="text-3xl font-bold text-gray-800">32</p>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Charts -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Line chart -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Évolution des emprunts par mois</h3>
            <div class="chart-container">
              <canvas id="empruntsChart"></canvas>
            </div>
          </div>
          
          <!-- Bar chart -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pénalités totales par mois</h3>
            <div class="chart-container">
              <canvas id="penalitesChart"></canvas>
            </div>
          </div>
        </div>
        
        <!-- Quick links and recent loans -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
          <!-- Quick links -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Liens rapides</h3>
            <div class="space-y-3">
              <a href="#" class="flex items-center p-3 bg-green-50 text-green-700 rounded-md hover:bg-green-100 transition duration-200">
                <i class="fas fa-plus-circle mr-3"></i>
                <span>Ajouter un livre</span>
              </a>
              <a href="#" class="flex items-center p-3 bg-blue-50 text-blue-700 rounded-md hover:bg-blue-100 transition duration-200">
                <i class="fas fa-user-plus mr-3"></i>
                <span>Nouvel utilisateur</span>
              </a>
              <a href="#" class="flex items-center p-3 bg-purple-50 text-purple-700 rounded-md hover:bg-purple-100 transition duration-200">
                <i class="fas fa-chart-line mr-3"></i>
                <span>Voir les statistiques</span>
              </a>
            </div>
          </div>
          
          <!-- Recent loans -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Derniers emprunts</h3>
            <div class="overflow-x-auto">
              <table class="min-w-full">
                <thead>
                  <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Utilisateur</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Livre</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date d'emprunt</th>
                    <th class="px-4 py-3 text-left text-sm font-medium text-gray-500">Date de retour</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b border-gray-200">
                    <td class="px-4 py-3 text-sm text-gray-800">Sophie Martin</td>
                    <td class="px-4 py-3 text-sm text-gray-800">Le Petit Prince</td>
                    <td class="px-4 py-3 text-sm text-gray-800">15/05/2023</td>
                    <td class="px-4 py-3 text-sm text-gray-800">29/05/2023</td>
                  </tr>
                  <tr class="border-b border-gray-200">
                    <td class="px-4 py-3 text-sm text-gray-800">Thomas Dubois</td>
                    <td class="px-4 py-3 text-sm text-gray-800">1984</td>
                    <td class="px-4 py-3 text-sm text-gray-800">14/05/2023</td>
                    <td class="px-4 py-3 text-sm text-gray-800">28/05/2023</td>
                  </tr>
                  <tr>
                    <td class="px-4 py-3 text-sm text-gray-800">Emma Leroy</td>
                    <td class="px-4 py-3 text-sm text-gray-800">Harry Potter</td>
                    <td class="px-4 py-3 text-sm text-gray-800">12/05/2023</td>
                    <td class="px-4 py-3 text-sm text-gray-800">26/05/2023</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        
        <!-- Articles table -->
        
      </main>
    </div>
  </div>

  <script >
    import { Chart } from "@/components/ui/chart"
document.addEventListener("DOMContentLoaded", () => {
  // Mobile sidebar toggle
  const sidebarToggle = document.getElementById("sidebarToggle")
  const mobileSidebar = document.getElementById("mobileSidebar")
  const closeSidebar = document.getElementById("closeSidebar")
  const sidebar = mobileSidebar.querySelector(".sidebar")

  sidebarToggle.addEventListener("click", () => {
    mobileSidebar.classList.remove("hidden")
    setTimeout(() => {
      sidebar.classList.add("translate-x-0")
      sidebar.classList.remove("-translate-x-full")
    }, 50)
  })

  closeSidebar.addEventListener("click", () => {
    sidebar.classList.remove("translate-x-0")
    sidebar.classList.add("-translate-x-full")
    setTimeout(() => {
      mobileSidebar.classList.add("hidden")
    }, 300)
  })

  // Close sidebar when clicking outside
  mobileSidebar.addEventListener("click", (e) => {
    if (e.target === mobileSidebar) {
      sidebar.classList.remove("translate-x-0")
      sidebar.classList.add("-translate-x-full")
      setTimeout(() => {
        mobileSidebar.classList.add("hidden")
      }, 300)
    }
  })

  // Charts
  const empruntsCtx = document.getElementById("empruntsChart").getContext("2d")
  const penalitesCtx = document.getElementById("penalitesChart").getContext("2d")

  // Months labels
  const months = ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Août", "Sep", "Oct", "Nov", "Déc"]

  // Emprunts chart data
  const empruntsData = [65, 59, 80, 81, 56, 55, 40, 45, 60, 70, 85, 90]

  // Pénalités chart data
  const penalitesData = [1200, 1850, 1500, 1650, 1950, 1750, 1550, 1400, 2050, 1850, 2100, 2400]

  // Line chart for emprunts
  new Chart(empruntsCtx, {
    type: "line",
    data: {
      labels: months,
      datasets: [
        {
          label: "Emprunts",
          data: empruntsData,
          fill: false,
          borderColor: "#4F46E5",
          backgroundColor: "#4F46E5",
          tension: 0.1,
          pointBackgroundColor: "#4F46E5",
          pointBorderColor: "#fff",
          pointBorderWidth: 2,
          pointRadius: 4,
          pointHoverRadius: 6,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            drawBorder: false,
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
      plugins: {
        legend: {
          display: true,
          position: "top",
          align: "end",
          labels: {
            boxWidth: 15,
            usePointStyle: true,
            pointStyle: "circle",
          },
        },
        tooltip: {
          backgroundColor: "rgba(0, 0, 0, 0.7)",
          padding: 10,
          cornerRadius: 4,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
        },
      },
    },
  })

  // Bar chart for pénalités
  new Chart(penalitesCtx, {
    type: "bar",
    data: {
      labels: months,
      datasets: [
        {
          label: "Pénalités (DH)",
          data: penalitesData,
          backgroundColor: "#EF4444",
          borderRadius: 4,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            drawBorder: false,
          },
        },
        x: {
          grid: {
            display: false,
          },
        },
      },
      plugins: {
        legend: {
          display: true,
          position: "top",
          align: "end",
          labels: {
            boxWidth: 15,
            usePointStyle: true,
            pointStyle: "circle",
          },
        },
        tooltip: {
          backgroundColor: "rgba(0, 0, 0, 0.7)",
          padding: 10,
          cornerRadius: 4,
          titleFont: {
            size: 14,
          },
          bodyFont: {
            size: 13,
          },
        },
      },
    },
  })

  // Search functionality
  const searchInput = document.querySelector('input[placeholder="Rechercher..."]')
  searchInput.addEventListener("focus", function () {
    this.classList.add("ring-2", "ring-primary", "bg-white")
  })

  searchInput.addEventListener("blur", function () {
    this.classList.remove("ring-2", "ring-primary", "bg-white")
  })

  // Notification button effect
  const notificationBtn = document.querySelector("button.text-gray-600")
  notificationBtn.addEventListener("mouseover", function () {
    this.classList.add("text-primary")
    this.classList.remove("text-gray-600")
  })

  notificationBtn.addEventListener("mouseout", function () {
    this.classList.remove("text-primary")
    this.classList.add("text-gray-600")
  })

  // Table row hover effect
  const tableRows = document.querySelectorAll("tbody tr")
  tableRows.forEach((row) => {
    row.addEventListener("mouseover", function () {
      this.classList.add("bg-gray-50")
    })

    row.addEventListener("mouseout", function () {
      this.classList.remove("bg-gray-50")
    })
  })

  // Action buttons hover effects
  const actionButtons = document.querySelectorAll("button.bg-blue-500, button.bg-red-500, button.bg-gray-500")
  actionButtons.forEach((button) => {
    button.addEventListener("mouseover", function () {
      if (this.classList.contains("bg-blue-500")) {
        this.classList.add("bg-blue-600")
        this.classList.remove("bg-blue-500")
      } else if (this.classList.contains("bg-red-500")) {
        this.classList.add("bg-red-600")
        this.classList.remove("bg-red-500")
      } else if (this.classList.contains("bg-gray-500")) {
        this.classList.add("bg-gray-600")
        this.classList.remove("bg-gray-500")
      }
    })

    button.addEventListener("mouseout", function () {
      if (this.classList.contains("bg-blue-600")) {
        this.classList.add("bg-blue-500")
        this.classList.remove("bg-blue-600")
      } else if (this.classList.contains("bg-red-600")) {
        this.classList.add("bg-red-500")
        this.classList.remove("bg-red-600")
      } else if (this.classList.contains("bg-gray-600")) {
        this.classList.add("bg-gray-500")
        this.classList.remove("bg-gray-600")
      }
    })
  })

  // Pagination buttons
  const paginationButtons = document.querySelectorAll("button.bg-gray-200")
  paginationButtons.forEach((button) => {
    button.addEventListener("mouseover", function () {
      this.classList.add("bg-gray-300")
      this.classList.remove("bg-gray-200")
    })

    button.addEventListener("mouseout", function () {
      this.classList.add("bg-gray-200")
      this.classList.remove("bg-gray-300")
    })
  })
})

  </script>
</body>
</html>