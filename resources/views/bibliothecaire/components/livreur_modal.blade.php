<!-- Modal pour ajouter/modifier un livreur -->
<div id="livreurModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
    <button id="closeModalBtn" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times"></i>
    </button>
    <h2 id="livreurModalTitle" class="text-2xl font-semibold text-gray-800 mb-6">Ajouter un livreur</h2>

    <form id="livreurForm" class="space-y-4">
      @csrf
      <input type="hidden" id="livreurId" value="">
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
          <input type="text" id="nom" name="nom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        
        <div>
          <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
          <input type="text" id="prenom" name="prenom" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <input type="email" id="email" name="email" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        
        <div>
          <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
          <input type="tel" id="telephone" name="telephone" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
        </div>
        
        <div id="passwordField">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
          <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary">
          <p id="passwordHelp" class="text-xs text-gray-500 mt-1">8 caractères minimum</p>
        </div>
        
        <div>
          <label for="zone_livraison" class="block text-sm font-medium text-gray-700 mb-1">Zone de livraison</label>
          <select id="zone_livraison" name="zone_livraison" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
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
          <select id="moyen_transport" name="moyen_transport" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary" required>
            <option value="">Sélectionner un moyen de transport</option>
            <option value="Voiture">Voiture</option>
            <option value="Moto">Moto</option>
            <option value="Vélo">Vélo</option>
            <option value="Scooter">Scooter</option>
            <option value="À pied">À pied</option>
          </select>
        </div>
      </div>

      <div class="flex justify-end space-x-3 pt-4">
        <button type="button" id="cancelBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
          Annuler
        </button>
        <button type="submit" class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-200">
          <span id="submitBtnText">Ajouter</span>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Modal pour afficher les détails d'un livreur -->
<div id="viewLivreurModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
    <button id="closeViewModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
      <i class="fas fa-times"></i>
    </button>
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Détails du livreur</h2>
    
    <div id="livreurDetails" class="py-4">
      <!-- Le contenu sera rempli dynamiquement -->
    </div>
    
    <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
      <button type="button" id="closeViewDetailBtn" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-200">
        Fermer
      </button>
    </div>
  </div>
</div>

<!-- Notification -->
<div id="notification" class="notification hidden">
  <span id="notificationMessage"></span>
</div>
