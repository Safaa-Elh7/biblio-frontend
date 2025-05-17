<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>MyBookSpace - Gestion des Commandes</title>
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
            <a href="{{ route('bibliothecaire.payment.show') }}" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
              <i class="fas fa-shopping-cart mr-3"></i>
              <span>Commandes</span>
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
              <a href="{{ route('bibliothecaire.payment.show') }}" class="sidebar-item active flex items-center text-white py-2 px-4 rounded">
                <i class="fas fa-shopping-cart mr-3"></i>
                <span>Commandes</span>
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
          <h1 class="text-2xl font-semibold text-gray-800">Gestion des Commandes</h1>
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

      <!-- Dashboard content -->
      <main class="p-6 bg-secondary min-h-screen">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
          <div class="stat-card bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="rounded-full bg-blue-100 p-3 mr-4">
              <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Total Commandes</p>
              <h3 class="text-2xl font-bold text-gray-800" id="totalOrders">0</h3>
            </div>
          </div>
          
          <div class="stat-card bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="rounded-full bg-green-100 p-3 mr-4">
              <i class="fas fa-check-circle text-green-600 text-xl"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Commandes Complétées</p>
              <h3 class="text-2xl font-bold text-gray-800" id="completedOrders">0</h3>
            </div>
          </div>
          
          <div class="stat-card bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="rounded-full bg-yellow-100 p-3 mr-4">
              <i class="fas fa-clock text-yellow-600 text-xl"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">En Traitement</p>
              <h3 class="text-2xl font-bold text-gray-800" id="processingOrders">0</h3>
            </div>
          </div>
          
          <div class="stat-card bg-white rounded-lg shadow-md p-6 flex items-center">
            <div class="rounded-full bg-red-100 p-3 mr-4">
              <i class="fas fa-times-circle text-red-600 text-xl"></i>
            </div>
            <div>
              <p class="text-sm text-gray-500 mb-1">Commandes Annulées</p>
              <h3 class="text-2xl font-bold text-gray-800" id="canceledOrders">0</h3>
            </div>
          </div>
        </div>
        
        <!-- Orders Table -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
          <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Liste des Commandes</h2>
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
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Numéro</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paiement</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
              </thead>
              <tbody id="ordersTableBody">
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

  <!-- View Order Details Modal -->
  <div id="viewOrderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl p-6 relative">
      <button id="closeViewModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
        <i class="fas fa-times"></i>
      </button>
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Détails de la commande</h2>
      
      <div id="orderDetails" class="space-y-6">
        <!-- Order details will be populated by JavaScript -->
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

      // Sample data for orders based on the provided database structure
      const orders = [
        {
          id: 1,
          user_id: 101,
          order_number: "ORD-2023-0001",
          subtotal: 125.50,
          tax: 10.04,
          total: 135.54,
          full_name: "Jean Dupont",
          address: "123 Rue de Paris",
          city: "Paris",
          zip_code: "75001",
          payment_method: "credit_card",
          card_last_four: "4242",
          status: "completed",
          created_at: "2023-05-15 08:30:45"
        },
        {
          id: 2,
          user_id: 102,
          order_number: "ORD-2023-0002",
          subtotal: 78.25,
          tax: 6.26,
          total: 84.51,
          full_name: "Marie Martin",
          address: "456 Avenue des Champs",
          city: "Lyon",
          zip_code: "69001",
          payment_method: "paypal",
          card_last_four: null,
          status: "processing",
          created_at: "2023-05-14 14:22:10"
        },
        {
          id: 3,
          user_id: 103,
          order_number: "ORD-2023-0003",
          subtotal: 210.75,
          tax: 16.86,
          total: 227.61,
          full_name: "Thomas Bernard",
          address: "789 Boulevard Saint-Michel",
          city: "Marseille",
          zip_code: "13001",
          payment_method: "credit_card",
          card_last_four: "1234",
          status: "completed",
          created_at: "2023-05-13 09:15:30"
        },
        {
          id: 4,
          user_id: 104,
          order_number: "ORD-2023-0004",
          subtotal: 45.99,
          tax: 3.68,
          total: 49.67,
          full_name: "Sophie Petit",
          address: "101 Rue de la République",
          city: "Bordeaux",
          zip_code: "33000",
          payment_method: "credit_card",
          card_last_four: "5678",
          status: "pending",
          created_at: "2023-05-12 16:45:20"
        },
        {
          id: 5,
          user_id: 105,
          order_number: "ORD-2023-0005",
          subtotal: 156.80,
          tax: 12.54,
          total: 169.34,
          full_name: "Lucas Moreau",
          address: "202 Avenue Jean Jaurès",
          city: "Lille",
          zip_code: "59000",
          payment_method: "credit_card",
          card_last_four: "9012",
          status: "completed",
          created_at: "2023-05-11 11:10:05"
        },
        {
          id: 6,
          user_id: 106,
          order_number: "ORD-2023-0006",
          subtotal: 89.99,
          tax: 7.20,
          total: 97.19,
          full_name: "Emma Leroy",
          address: "303 Rue Victor Hugo",
          city: "Toulouse",
          zip_code: "31000",
          payment_method: "paypal",
          card_last_four: null,
          status: "processing",
          created_at: "2023-05-10 13:25:40"
        },
        {
          id: 7,
          user_id: 107,
          order_number: "ORD-2023-0007",
          subtotal: 65.50,
          tax: 5.24,
          total: 70.74,
          full_name: "Hugo Simon",
          address: "404 Boulevard Gambetta",
          city: "Nice",
          zip_code: "06000",
          payment_method: "credit_card",
          card_last_four: "3456",
          status: "canceled",
          created_at: "2023-05-09 10:05:15"
        },
        {
          id: 8,
          user_id: 108,
          order_number: "ORD-2023-0008",
          subtotal: 112.25,
          tax: 8.98,
          total: 121.23,
          full_name: "Léa Garcia",
          address: "505 Rue Nationale",
          city: "Strasbourg",
          zip_code: "67000",
          payment_method: "credit_card",
          card_last_four: "7890",
          status: "completed",
          created_at: "2023-05-08 17:30:25"
        },
        {
          id: 9,
          user_id: 109,
          order_number: "ORD-2023-0009",
          subtotal: 42.99,
          tax: 3.44,
          total: 46.43,
          full_name: "Nathan Roux",
          address: "606 Avenue Foch",
          city: "Nantes",
          zip_code: "44000",
          payment_method: "paypal",
          card_last_four: null,
          status: "pending",
          created_at: "2023-05-07 08:50:35"
        },
        {
          id: 10,
          user_id: 110,
          order_number: "ORD-2023-0010",
          subtotal: 189.75,
          tax: 15.18,
          total: 204.93,
          full_name: "Chloé Fournier",
          address: "707 Rue Pasteur",
          city: "Rennes",
          zip_code: "35000",
          payment_method: "credit_card",
          card_last_four: "2345",
          status: "canceled",
          created_at: "2023-05-06 15:15:55"
        },
        {
          id: 11,
          user_id: 111,
          order_number: "ORD-2023-0011",
          subtotal: 75.50,
          tax: 6.04,
          total: 81.54,
          full_name: "Maxime Girard",
          address: "808 Boulevard Clemenceau",
          city: "Montpellier",
          zip_code: "34000",
          payment_method: "credit_card",
          card_last_four: "6789",
          status: "completed",
          created_at: "2023-05-05 12:40:10"
        },
        {
          id: 12,
          user_id: 112,
          order_number: "ORD-2023-0012",
          subtotal: 134.99,
          tax: 10.80,
          total: 145.79,
          full_name: "Camille Dubois",
          address: "909 Rue Molière",
          city: "Grenoble",
          zip_code: "38000",
          payment_method: "paypal",
          card_last_four: null,
          status: "processing",
          created_at: "2023-05-04 09:20:30"
        }
      ];

      // Sample order items for details view
      const orderItems = {
        1: [
          { id: 1, order_id: 1, product_name: "Le Petit Prince", quantity: 2, price: 15.50, total: 31.00 },
          { id: 2, order_id: 1, product_name: "1984", quantity: 1, price: 12.99, total: 12.99 },
          { id: 3, order_id: 1, product_name: "Harry Potter à l'école des sorciers", quantity: 1, price: 18.75, total: 18.75 },
          { id: 4, order_id: 1, product_name: "L'Étranger", quantity: 1, price: 10.50, total: 10.50 },
          { id: 5, order_id: 1, product_name: "Les Misérables", quantity: 1, price: 22.50, total: 22.50 },
          { id: 6, order_id: 1, product_name: "Voyage au centre de la Terre", quantity: 1, price: 14.99, total: 14.99 },
          { id: 7, order_id: 1, product_name: "Le Comte de Monte-Cristo", quantity: 1, price: 14.77, total: 14.77 }
        ],
        2: [
          { id: 8, order_id: 2, product_name: "Orgueil et Préjugés", quantity: 1, price: 13.50, total: 13.50 },
          { id: 9, order_id: 2, product_name: "Don Quichotte", quantity: 1, price: 16.75, total: 16.75 },
          { id: 10, order_id: 2, product_name: "Guerre et Paix", quantity: 1, price: 24.99, total: 24.99 },
          { id: 11, order_id: 2, product_name: "Crime et Châtiment", quantity: 1, price: 23.01, total: 23.01 }
        ],
        3: [
          { id: 12, order_id: 3, product_name: "Madame Bovary", quantity: 1, price: 11.99, total: 11.99 },
          { id: 13, order_id: 3, product_name: "Les Fleurs du Mal", quantity: 1, price: 14.50, total: 14.50 },
          { id: 14, order_id: 3, product_name: "Notre-Dame de Paris", quantity: 1, price: 15.75, total: 15.75 },
          { id: 15, order_id: 3, product_name: "Le Rouge et le Noir", quantity: 1, price: 12.99, total: 12.99 },
          { id: 16, order_id: 3, product_name: "Les Trois Mousquetaires", quantity: 1, price: 13.50, total: 13.50 },
          { id: 17, order_id: 3, product_name: "Germinal", quantity: 1, price: 14.25, total: 14.25 },
          { id: 18, order_id: 3, product_name: "Bel-Ami", quantity: 1, price: 10.99, total: 10.99 },
          { id: 19, order_id: 3, product_name: "Le Père Goriot", quantity: 1, price: 11.50, total: 11.50 },
          { id: 20, order_id: 3, product_name: "Candide", quantity: 1, price: 9.99, total: 9.99 },
          { id: 21, order_id: 3, product_name: "Les Liaisons dangereuses", quantity: 1, price: 12.50, total: 12.50 },
          { id: 22, order_id: 3, product_name: "Le Tour du monde en 80 jours", quantity: 1, price: 11.75, total: 11.75 },
          { id: 23, order_id: 3, product_name: "Vingt mille lieues sous les mers", quantity: 1, price: 13.25, total: 13.25 },
          { id: 24, order_id: 3, product_name: "La Peste", quantity: 1, price: 14.50, total: 14.50 },
          { id: 25, order_id: 3, product_name: "Le Grand Meaulnes", quantity: 1, price: 10.50, total: 10.50 },
          { id: 26, order_id: 3, product_name: "Au Bonheur des Dames", quantity: 1, price: 12.75, total: 12.75 },
          { id: 27, order_id: 3, product_name: "La Chartreuse de Parme", quantity: 1, price: 13.99, total: 13.99 },
          { id: 28, order_id: 3, product_name: "Le Horla", quantity: 1, price: 8.50, total: 8.50 }
        ]
      };

      // Status mapping
      const statusMap = {
        "pending": { name: "En attente", color: "bg-yellow-100 text-yellow-800" },
        "processing": { name: "En traitement", color: "bg-blue-100 text-blue-800" },
        "completed": { name: "Complétée", color: "bg-green-100 text-green-800" },
        "canceled": { name: "Annulée", color: "bg-red-100 text-red-800" }
      };

      // Payment method mapping
      const paymentMethodMap = {
        "credit_card": { name: "Carte de crédit", icon: "fa-credit-card" },
        "paypal": { name: "PayPal", icon: "fa-paypal" },
        "bank_transfer": { name: "Virement bancaire", icon: "fa-university" },
        "cash": { name: "Espèces", icon: "fa-money-bill" }
      };

      // Pagination variables
      let currentPage = 1;
      const itemsPerPage = 5;
      const totalPages = Math.ceil(orders.length / itemsPerPage);

      // Initialize the dashboard
      updateStats();
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

      // View Order Modal functionality
      const viewOrderModal = document.getElementById("viewOrderModal");
      const closeViewModal = document.getElementById("closeViewModal");
      const closeViewModalBtn = document.getElementById("closeViewModalBtn");
      const orderDetails = document.getElementById("orderDetails");

      function closeViewModalFunction() {
        viewOrderModal.classList.add("hidden");
        document.body.style.overflow = "auto";
      }

      closeViewModal.addEventListener("click", closeViewModalFunction);
      closeViewModalBtn.addEventListener("click", closeViewModalFunction);

      // Close view modal when clicking outside
      viewOrderModal.addEventListener("click", (e) => {
        if (e.target === viewOrderModal) {
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
        const totalOrdersCount = orders.length;
        const completedOrdersCount = orders.filter(order => order.status === "completed").length;
        const processingOrdersCount = orders.filter(order => order.status === "processing").length;
        const canceledOrdersCount = orders.filter(order => order.status === "canceled").length;

        document.getElementById("totalOrders").textContent = totalOrdersCount;
        document.getElementById("completedOrders").textContent = completedOrdersCount;
        document.getElementById("processingOrders").textContent = processingOrdersCount;
        document.getElementById("canceledOrders").textContent = canceledOrdersCount;
      }

      // Function to update the table based on current page and search
      function updateTable() {
        const tableBody = document.getElementById("ordersTableBody");
        tableBody.innerHTML = "";

        const searchTerm = searchInput.value.toLowerCase();
        const filteredOrders = orders.filter(
          (order) =>
            order.order_number.toLowerCase().includes(searchTerm) ||
            order.full_name.toLowerCase().includes(searchTerm) ||
            statusMap[order.status].name.toLowerCase().includes(searchTerm)
        );

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredOrders.length);

        // Update pagination info
        document.getElementById("startEntry").textContent = filteredOrders.length > 0 ? startIndex + 1 : 0;
        document.getElementById("endEntry").textContent = endIndex;
        document.getElementById("totalEntries").textContent = filteredOrders.length;

        // Create table rows
        for (let i = startIndex; i < endIndex; i++) {
          const order = filteredOrders[i];
          const row = document.createElement("tr");
          row.className = "table-row border-b hover:bg-gray-50";

          // Format date
          const orderDate = new Date(order.created_at);
          const formattedDate = orderDate.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          });

          // Format payment method
          const paymentMethod = paymentMethodMap[order.payment_method];
          const paymentDisplay = order.card_last_four 
            ? `${paymentMethod.name} (**** ${order.card_last_four})` 
            : paymentMethod.name;

          row.innerHTML = `
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${order.id}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.order_number}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${order.full_name}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formattedDate}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${order.total.toFixed(2)} €</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <span class="inline-flex items-center">
                <i class="fas ${paymentMethod.icon} mr-2"></i>
                ${paymentDisplay}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm">
              <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusMap[order.status].color}">
                ${statusMap[order.status].name}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <div class="flex space-x-2">
                <button class="action-button bg-blue-600 hover:bg-blue-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="updateOrderStatus(${order.id})">
                  <i class="fas fa-edit mr-1"></i> Statut
                </button>
                <button class="action-button bg-gray-600 hover:bg-gray-700 text-white py-1 px-3 rounded text-xs flex items-center" onclick="viewOrderDetails(${order.id})">
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
        const filteredOrders = orders.filter(
          (order) =>
            order.order_number.toLowerCase().includes(searchTerm) ||
            order.full_name.toLowerCase().includes(searchTerm) ||
            statusMap[order.status].name.toLowerCase().includes(searchTerm)
        );

        const totalFilteredPages = Math.ceil(filteredOrders.length / itemsPerPage);

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
      window.updateOrderStatus = function(id) {
        showNotification("Mise à jour du statut de la commande #" + id);
      };

      window.viewOrderDetails = function(id) {
        const order = orders.find(order => order.id === id);
        if (order) {
          // Format date
          const orderDate = new Date(order.created_at);
          const formattedDate = orderDate.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
          });

          // Get order items
          const items = orderItems[order.id] || [];

          // Populate order details
          orderDetails.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <h3 class="text-lg font-medium text-gray-800 mb-4">Informations de commande</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Numéro de commande:</span>
                    <span class="font-medium">${order.order_number}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Date:</span>
                    <span class="font-medium">${formattedDate}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Statut:</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusMap[order.status].color}">
                      ${statusMap[order.status].name}
                    </span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">ID Client:</span>
                    <span class="font-medium">${order.user_id}</span>
                  </div>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mt-6 mb-4">Informations de paiement</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                  <div class="flex justify-between">
                    <span class="text-gray-600">Méthode de paiement:</span>
                    <span class="font-medium flex items-center">
                      <i class="fas ${paymentMethodMap[order.payment_method].icon} mr-2"></i>
                      ${paymentMethodMap[order.payment_method].name}
                    </span>
                  </div>
                  ${order.card_last_four ? `
                  <div class="flex justify-between">
                    <span class="text-gray-600">Derniers chiffres:</span>
                    <span class="font-medium">**** ${order.card_last_four}</span>
                  </div>
                  ` : ''}
                  <div class="flex justify-between">
                    <span class="text-gray-600">Sous-total:</span>
                    <span class="font-medium">${order.subtotal.toFixed(2)} €</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600">Taxe:</span>
                    <span class="font-medium">${order.tax.toFixed(2)} €</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-gray-600 font-medium">Total:</span>
                    <span class="font-bold text-primary">${order.total.toFixed(2)} €</span>
                  </div>
                </div>
              </div>

              <div>
                <h3 class="text-lg font-medium text-gray-800 mb-4">Adresse de livraison</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-2">
                  <div class="font-medium">${order.full_name}</div>
                  <div>${order.address}</div>
                  <div>${order.city}, ${order.zip_code}</div>
                </div>

                <h3 class="text-lg font-medium text-gray-800 mt-6 mb-4">Actions</h3>
                <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                  <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded flex items-center justify-center">
                    <i class="fas fa-print mr-2"></i> Imprimer la facture
                  </button>
                  <button class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded flex items-center justify-center">
                    <i class="fas fa-envelope mr-2"></i> Envoyer un e-mail
                  </button>
                  ${order.status !== 'canceled' ? `
                  <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded flex items-center justify-center">
                    <i class="fas fa-times-circle mr-2"></i> Annuler la commande
                  </button>
                  ` : ''}
                </div>
              </div>
            </div>

            <div class="mt-6">
              <h3 class="text-lg font-medium text-gray-800 mb-4">Articles commandés</h3>
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix unitaire</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    ${items.map(item => `
                    <tr>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.product_name}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.price.toFixed(2)} €</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${item.quantity}</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${item.total.toFixed(2)} €</td>
                    </tr>
                    `).join('')}
                  </tbody>
                  <tfoot class="bg-gray-50">
                    <tr>
                      <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Sous-total:</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${order.subtotal.toFixed(2)} €</td>
                    </tr>
                    <tr>
                      <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">Taxe:</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${order.tax.toFixed(2)} €</td>
                    </tr>
                    <tr>
                      <td colspan="3" class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">Total:</td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-primary">${order.total.toFixed(2)} €</td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          `;

          // Show modal
          viewOrderModal.classList.remove("hidden");
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