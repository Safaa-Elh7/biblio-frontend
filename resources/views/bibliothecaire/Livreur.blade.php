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
  // Script pour gérer les opérations CRUD sur les livreurs avec AJAX
document.addEventListener("DOMContentLoaded", function() {
    // Éléments du DOM
    const addLivreurForm = document.getElementById('addLivreurForm');
    const addLivreurModal = document.getElementById('addLivreurModal');
    const closeModal = document.getElementById('closeModal');
    const cancelAddLivreur = document.getElementById('cancelAddLivreur');
    const editLivreurForm = document.getElementById('editLivreurForm');
    const editLivreurModal = document.getElementById('editLivreurModal');
    const closeEditModal = document.getElementById('closeEditModal');
    const cancelEditLivreur = document.getElementById('cancelEditLivreur');
    
    // Token CSRF pour les requêtes AJAX
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Gestion du formulaire d'ajout
    if (addLivreurForm) {
        addLivreurForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(addLivreurForm);
            
            fetch('/bibliothecaire/livreurs', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fermer le modal
                    closeModalFunction(addLivreurModal);
                    
                    // Rafraîchir la liste des livreurs
                    window.location.reload();
                    
                    // Afficher un message de succès
                    showNotification(data.message);
                } else {
                    // Afficher un message d'erreur
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de l\'ajout du livreur', 'error');
            });
        });
    }
    
    // Gestion du formulaire d'édition
    if (editLivreurForm) {
        editLivreurForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(editLivreurForm);
            const livreurId = editLivreurForm.getAttribute('data-id');
            
            // Utiliser la méthode PUT pour la mise à jour
            formData.append('_method', 'PUT');
            
            fetch(`/bibliothecaire/livreurs/${livreurId}`, {
                method: 'POST', // POST avec _method=PUT
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Fermer le modal
                    closeModalFunction(editLivreurModal);
                    
                    // Rafraîchir la liste des livreurs
                    window.location.reload();
                    
                    // Afficher un message de succès
                    showNotification(data.message);
                } else {
                    // Afficher un message d'erreur
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de la mise à jour du livreur', 'error');
            });
        });
    }
    
    // Fonction pour ouvrir le modal d'édition
    window.editLivreur = function(id) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remplir le formulaire avec les données du livreur
                const livreur = data.livreur;
                document.getElementById('edit_nom').value = livreur.nom;
                document.getElementById('edit_prenom').value = livreur.prenom;
                document.getElementById('edit_email').value = livreur.email;
                document.getElementById('edit_telephone').value = livreur.telephone;
                document.getElementById('edit_zone_livraison').value = livreur.zone_livraison;
                document.getElementById('edit_moyen_transport').value = livreur.moyen_transport;
                
                // Définir l'ID du livreur pour la soumission du formulaire
                editLivreurForm.setAttribute('data-id', livreur.id_users);
                
                // Ouvrir le modal
                editLivreurModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Une erreur est survenue lors de la récupération des données du livreur', 'error');
        });
    };
    
    // Fonction pour supprimer un livreur
    window.deleteLivreur = function(id) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce livreur?')) {
            fetch(`/bibliothecaire/livreurs/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Rafraîchir la liste des livreurs
                    window.location.reload();
                    
                    // Afficher un message de succès
                    showNotification(data.message);
                } else {
                    // Afficher un message d'erreur
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                showNotification('Une erreur est survenue lors de la suppression du livreur', 'error');
            });
        }
    };
    
    // Fonction pour voir les détails d'un livreur
    window.viewLivreurDetails = function(id) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Récupérer les données du livreur
                const livreur = data.livreur;
                
                // Remplir le modal avec les détails du livreur
                const livreurDetails = document.getElementById('livreurDetails');
                
                // Mettre à jour le contenu avec les détails du livreur
                // (Le code pour remplir livreurDetails est déjà dans votre HTML)
                
                // Ouvrir le modal
                document.getElementById('viewLivreurModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Une erreur est survenue lors de la récupération des détails du livreur', 'error');
        });
    };
    
    // Fonction pour fermer les modals
    function closeModalFunction(modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        if (modal === addLivreurModal) {
            addLivreurForm.reset();
        } else if (modal === editLivreurModal) {
            editLivreurForm.reset();
        }
    }
    
    // Événements pour fermer les modals
    if (closeModal) {
        closeModal.addEventListener('click', () => closeModalFunction(addLivreurModal));
    }
    if (cancelAddLivreur) {
        cancelAddLivreur.addEventListener('click', () => closeModalFunction(addLivreurModal));
    }
    if (closeEditModal) {
        closeEditModal.addEventListener('click', () => closeModalFunction(editLivreurModal));
    }
    if (cancelEditLivreur) {
        cancelEditLivreur.addEventListener('click', () => closeModalFunction(editLivreurModal));
    }
    
    // Fonction pour afficher les notifications
    window.showNotification = function(message, type = 'success') {
        // Supprimer les notifications existantes
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });
        
        // Créer une nouvelle notification
        const notification = document.createElement('div');
        notification.className = `notification ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Supprimer la notification après un délai
        setTimeout(() => {
            notification.classList.add('hiding');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 300);
        }, 3000);
    };
});    
  </script>
</body>
</html>