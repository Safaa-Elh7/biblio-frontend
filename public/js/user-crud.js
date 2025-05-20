// User CRUD functions for user.blade.php

// Add event listeners once DOM is loaded
document.addEventListener("DOMContentLoaded", function() {
  // Get CSRF token
  const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
  
  // User Modal Elements
  const userModal = document.getElementById('userModal');
  const deleteModal = document.getElementById('deleteModal');
  const userForm = document.getElementById('userForm');
  const addUserBtn = document.getElementById('addUserBtn');
  const closeUserModal = document.getElementById('closeUserModal'); 
  const cancelUserModal = document.getElementById('cancelUserModal');
  const closeDeleteModal = document.getElementById('closeDeleteModal');
  const cancelDelete = document.getElementById('cancelDelete');
  const confirmDelete = document.getElementById('confirmDelete');
  const searchUser = document.getElementById('searchUser');
  
  // Add user button
  if (addUserBtn) {
    addUserBtn.addEventListener('click', function() {
      resetUserForm();
      userModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    });
  }
  
  // Close user modal
  if (closeUserModal) {
    closeUserModal.addEventListener('click', function() {
      userModal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    });
  }
  
  if (cancelUserModal) {
    cancelUserModal.addEventListener('click', function() {
      userModal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    });
  }
  
  // Close delete modal
  if (closeDeleteModal) {
    closeDeleteModal.addEventListener('click', function() {
      deleteModal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    });
  }
  
  if (cancelDelete) {
    cancelDelete.addEventListener('click', function() {
      deleteModal.classList.add('hidden');
      document.body.style.overflow = 'auto';
    });
  }
  
  // Edit user buttons
  document.querySelectorAll('.edit-user').forEach(button => {
    button.addEventListener('click', function() {
      const userId = this.getAttribute('data-id');
      editUser(userId);
    });
  });
  
  // Delete user buttons
  document.querySelectorAll('.delete-user').forEach(button => {
    button.addEventListener('click', function() {
      const userId = this.getAttribute('data-id');
      deleteModal.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      confirmDelete.setAttribute('data-id', userId);
    });
  });
  
  // Confirm delete
  if (confirmDelete) {
    confirmDelete.addEventListener('click', function() {
      const userId = this.getAttribute('data-id');
      
      // Send delete request
      fetch(`/users/${userId}`, {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showNotification(data.message || 'Utilisateur supprimé avec succès');
          deleteModal.classList.add('hidden');
          document.body.style.overflow = 'auto';
          
          // Reload page after successful delete
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showNotification(data.message || 'Erreur lors de la suppression');
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la suppression');
      });
    });
  }
  
  // User form submission
  if (userForm) {
    userForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const userId = document.getElementById('userId').value;
      
      let url = '/users';
      let method = 'POST';
      
      if (userId) {
        url = `/users/${userId}`;
        method = 'PUT';
        
        // If password is empty in edit mode, don't send it
        if (!formData.get('password')) {
          formData.delete('password');
        }
      }
      
      fetch(url, {
        method: method,
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
          'X-Requested-With': 'XMLHttpRequest'
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showNotification(data.message || 'Opération réussie');
          userModal.classList.add('hidden');
          document.body.style.overflow = 'auto';
          
          // Reload page after success
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showNotification(data.message || 'Une erreur est survenue');
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        showNotification('Une erreur est survenue');
      });
    });
  }
  
  // Search function
  if (searchUser) {
    searchUser.addEventListener('keyup', function() {
      const searchTerm = this.value.toLowerCase();
      const rows = document.querySelectorAll('#usersTable tbody tr');
      
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
      });
    });
  }
});

// Function to reset user form for adding a new user
function resetUserForm() {
  const userForm = document.getElementById('userForm');
  const userModalTitle = document.getElementById('userModalTitle');
  const passwordRequired = document.getElementById('passwordRequired');
  const passwordHelp = document.getElementById('passwordHelp');
  
  if (userForm) {
    userForm.reset();
    document.getElementById('userId').value = '';
    userModalTitle.textContent = 'Ajouter un utilisateur';
    
    if (passwordRequired) passwordRequired.style.display = 'inline';
    if (passwordHelp) passwordHelp.textContent = 'Minimum 8 caractères';
    
    // Set password as required
    const passwordField = document.getElementById('password');
    if (passwordField) passwordField.required = true;
  }
}

// Function to edit user
function editUser(userId) {
  const userModal = document.getElementById('userModal');
  const userModalTitle = document.getElementById('userModalTitle');
  const passwordRequired = document.getElementById('passwordRequired');
  const passwordHelp = document.getElementById('passwordHelp');
  
  if (userModal) {
    // Set modal to edit mode
    userModalTitle.textContent = 'Modifier l\'utilisateur';
    
    // Password not required in edit mode
    const passwordField = document.getElementById('password');
    if (passwordField) passwordField.required = false;
    
    if (passwordRequired) passwordRequired.style.display = 'none';
    if (passwordHelp) passwordHelp.textContent = 'Laissez vide pour conserver le mot de passe actuel';
    
    // Fetch user data
    fetch(`/users/${userId}`)
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const user = data.user;
          document.getElementById('userId').value = user.id_users;
          document.getElementById('name').value = user.name;
          document.getElementById('prenom').value = user.prenom;
          document.getElementById('email').value = user.email;
          
          if (document.getElementById('telephone')) {
            document.getElementById('telephone').value = user.telephone || '';
          }
          if (document.getElementById('adresse')) {
            document.getElementById('adresse').value = user.adresse || '';
          }
          if (document.getElementById('date_naissance')) {
            document.getElementById('date_naissance').value = user.date_naissance || '';
          }
          
          // Show the modal
          userModal.classList.remove('hidden');
          document.body.style.overflow = 'hidden';
        } else {
          showNotification(data.message || 'Impossible de récupérer les données de l\'utilisateur');
        }
      })
      .catch(error => {
        console.error('Erreur:', error);
        showNotification('Erreur lors de la récupération des données utilisateur');
      });
  }
}
