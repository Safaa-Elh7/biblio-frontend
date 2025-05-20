<!-- User Modal -->
<div class="fixed inset-0 hidden overflow-y-auto overflow-x-hidden z-50" id="userModal">
  <div class="flex items-center justify-center min-h-screen">
    <div class="fixed inset-0 bg-black opacity-50 transition-opacity"></div>
    
    <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl p-6 relative">
      <!-- Modal header -->
      <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-xl font-bold text-primary" id="userModalTitle">Ajouter un utilisateur</h3>
        <button type="button" class="text-gray-600 hover:text-primary" id="closeUserModal">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <!-- Modal body -->
      <form id="userForm">
        @csrf
        <input type="hidden" id="userId" name="id_users">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nom*</label>
            <input type="text" id="name" name="name" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
              required>
          </div>
          
          <div>
            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom*</label>
            <input type="text" id="prenom" name="prenom" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
              required>
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
            <input type="email" id="email" name="email" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" 
              required>
          </div>
          
          <div>
            <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
            <input type="tel" id="telephone" name="telephone" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
          <div>
            <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
            <input type="text" id="adresse" name="adresse" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>
          
          <div>
            <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de naissance</label>
            <input type="date" id="date_naissance" name="date_naissance" 
              class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
          </div>
        </div>
        
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
            Mot de passe<span id="passwordRequired">*</span>
          </label>
          <input type="password" id="password" name="password" 
            class="border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
          <p class="text-sm text-gray-500 mt-1" id="passwordHelp">Minimum 8 caractères</p>
        </div>
        
        <!-- Modal footer -->
        <div class="flex justify-end border-t pt-4">
          <button type="button" id="cancelUserModal" 
            class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2 transition">
            Annuler
          </button>
          <button type="submit" 
            class="px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
            Enregistrer
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="fixed inset-0 hidden overflow-y-auto overflow-x-hidden z-50" id="deleteModal">
  <div class="flex items-center justify-center min-h-screen">
    <div class="fixed inset-0 bg-black opacity-50 transition-opacity"></div>
    
    <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6 relative">
      <div class="flex justify-between items-center mb-4 border-b pb-4">
        <h3 class="text-xl font-bold text-red-600">Confirmation de suppression</h3>
        <button type="button" class="text-gray-600 hover:text-red-600" id="closeDeleteModal">
          <i class="fas fa-times"></i>
        </button>
      </div>
      
      <div class="mb-6">
        <p class="text-gray-700">Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.</p>
      </div>
      
      <div class="flex justify-end">
        <button type="button" id="cancelDelete" 
          class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 mr-2 transition">
          Annuler
        </button>
        <button type="button" id="confirmDelete" data-id="" 
          class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
          Supprimer
        </button>
      </div>
    </div>
  </div>
</div>
