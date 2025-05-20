document.addEventListener('DOMContentLoaded', function() {
    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // DOM Elements
    const livreurTable = document.getElementById('livreursTable');
    const addLivreurBtn = document.getElementById('addLivreurBtn');
    const livreurModal = document.getElementById('livreurModal');
    const viewLivreurModal = document.getElementById('viewLivreurModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const closeViewModal = document.getElementById('closeViewModal');
    const closeViewDetailBtn = document.getElementById('closeViewDetailBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const livreurForm = document.getElementById('livreurForm');
    const searchInput = document.getElementById('searchLivreur');
    
    // Add livreur button event
    if (addLivreurBtn) {
        addLivreurBtn.addEventListener('click', function() {
            openModal();
        });
    }
      // Close modal buttons events
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', function() {
            closeModal();
        });
    }
    
    if (closeViewModal) {
        closeViewModal.addEventListener('click', function() {
            closeViewLivreurModal();
        });
    }
    
    if (closeViewDetailBtn) {
        closeViewDetailBtn.addEventListener('click', function() {
            closeViewLivreurModal();
        });
    }
    
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            closeModal();
        });
    }
      // Close modals when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === livreurModal) {
            closeModal();
        }
        if (event.target === viewLivreurModal) {
            closeViewLivreurModal();
        }
    });
    
    // Edit livreur buttons
    document.querySelectorAll('.edit-livreur').forEach(button => {
        button.addEventListener('click', function() {
            const livreurId = this.getAttribute('data-id');
            editLivreur(livreurId);
        });
    });
    
    // View livreur buttons
    document.querySelectorAll('.view-livreur').forEach(button => {
        button.addEventListener('click', function() {
            const livreurId = this.getAttribute('data-id');
            viewLivreur(livreurId);
        });
    });
    
    // Delete livreur buttons
    document.querySelectorAll('.delete-livreur').forEach(button => {
        button.addEventListener('click', function() {
            const livreurId = this.getAttribute('data-id');
            const confirmDelete = confirm('Êtes-vous sûr de vouloir supprimer ce livreur ? Cette action est irréversible.');
            
            if (confirmDelete) {
                deleteLivreur(livreurId);
            }
        });
    });
    
    // Form submission
    if (livreurForm) {
        livreurForm.addEventListener('submit', function(e) {
            e.preventDefault();
            submitLivreurForm();
        });
    }
    
    // Search functionality
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = livreurTable.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
    
    // Function to open modal for adding new livreur
    function openModal() {
        resetForm();
        document.getElementById('livreurModalTitle').textContent = 'Ajouter un livreur';
        document.getElementById('submitBtnText').textContent = 'Ajouter';
        document.getElementById('passwordField').style.display = 'block';
        document.getElementById('password').required = true;
        document.getElementById('passwordHelp').textContent = '8 caractères minimum';
        livreurModal.classList.remove('hidden');
    }
      // Function to close the edit/add modal
    function closeModal() {
        livreurModal.classList.add('hidden');
        resetForm();
    }
      // Function to close the view details modal
    function closeViewLivreurModal() {
        if (viewLivreurModal) {
            viewLivreurModal.classList.add('hidden');
            viewLivreurModal.classList.remove('flex');
        }
    }
    
    // Function to reset form
    function resetForm() {
        livreurForm.reset();
        document.getElementById('livreurId').value = '';
    }
    // Function to view livreur details
    function viewLivreur(id) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const livreur = data.livreur;
                const detailsContainer = document.getElementById('livreurDetails');
                
                // Create HTML for livreur details
                let detailsHtml = `
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold">Informations Personnelles</h3>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <div class="text-sm font-medium text-gray-600">Nom:</div>
                                <div class="text-sm text-gray-900">${livreur.nom} ${livreur.prenom}</div>
                                <div class="text-sm font-medium text-gray-600">Email:</div>
                                <div class="text-sm text-gray-900">${livreur.email}</div>
                                <div class="text-sm font-medium text-gray-600">Téléphone:</div>
                                <div class="text-sm text-gray-900">${livreur.telephone || 'Non renseigné'}</div>
                                <div class="text-sm font-medium text-gray-600">ID:</div>
                                <div class="text-sm text-gray-900">${livreur.id_livreur}</div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Informations de Livraison</h3>
                            <div class="grid grid-cols-2 gap-2 mt-2">
                                <div class="text-sm font-medium text-gray-600">Zone de livraison:</div>
                                <div class="text-sm text-gray-900">${livreur.zone_livraison}</div>
                                <div class="text-sm font-medium text-gray-600">Moyen de transport:</div>
                                <div class="text-sm text-gray-900">${livreur.moyen_transport}</div>
                            </div>
                        </div>
                    </div>
                `;
                
                // Update the details container
                detailsContainer.innerHTML = detailsHtml;
                
                // Show modal
                viewLivreurModal.classList.remove('hidden');
                viewLivreurModal.classList.add('flex');
            } else {
                showNotification(data.message || 'Erreur lors de la récupération des données', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la récupération des données', 'error');
        });
    }
      // Function to edit livreur
    function editLivreur(id) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const livreur = data.livreur;
                
                // Fill form with livreur data
                document.getElementById('livreurId').value = livreur.id_livreur;
                document.getElementById('nom').value = livreur.nom;
                document.getElementById('prenom').value = livreur.prenom;
                document.getElementById('email').value = livreur.email;
                document.getElementById('telephone').value = livreur.telephone || '';
                document.getElementById('zone_livraison').value = livreur.zone_livraison;
                document.getElementById('moyen_transport').value = livreur.moyen_transport;
                
                // Change modal title, button text, and password field
                document.getElementById('livreurModalTitle').textContent = 'Modifier le livreur';
                document.getElementById('submitBtnText').textContent = 'Modifier';
                document.getElementById('passwordField').style.display = 'block';
                document.getElementById('password').required = false;
                document.getElementById('passwordHelp').textContent = 'Laissez vide pour conserver le mot de passe actuel';
                
                // Show modal
                livreurModal.classList.remove('hidden');
            } else {
                showNotification(data.message || 'Erreur lors de la récupération des données', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la récupération des données', 'error');
        });
    }
    
    // Function to delete livreur
    function deleteLivreur(id) {
        fetch(`/bibliothecaire/livreurs/${id}`, {
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
                showNotification(data.message || 'Livreur supprimé avec succès');
                
                // Remove row from table or reload page
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Erreur lors de la suppression', 'error');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de la suppression', 'error');
        });
    }
      // Function to submit livreur form
    function submitLivreurForm() {
        const formData = new FormData(livreurForm);
        const livreurId = document.getElementById('livreurId').value;
        
        // Add CSRF token
        formData.append('_token', csrfToken);
        
        let url = '/bibliothecaire/livreurs';
        let method = 'POST';
        
        if (livreurId) {
            url = `/bibliothecaire/livreurs/${livreurId}`;
            method = 'PUT';
            
            // For PUT requests, we need to add the _method field
            formData.append('_method', 'PUT');
            
            // If password is empty in edit mode, don't send it
            if (!formData.get('password')) {
                formData.delete('password');
            }
        }
        
        fetch(url, {
            method: 'POST', // Always use POST for FormData (PUT doesn't work with FormData)
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest'
                // Don't set Content-Type header when sending FormData
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'Opération réussie');
                closeModal();
                
                // Reload page after successful operation
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showNotification(data.message || 'Erreur lors de l\'opération', 'error');
            }        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Erreur lors de l\'opération', 'error');
        });
    }
    
    // Function to show notification
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');
        
        if (notification && notificationMessage) {
            // Set the message
            notificationMessage.textContent = message;
            
            // Set the appropriate style based on type
            notification.classList.remove('bg-green-500', 'bg-red-500', 'bg-yellow-500');
            
            if (type === 'success') {
                notification.classList.add('bg-green-500');
            } else if (type === 'error') {
                notification.classList.add('bg-red-500');
            } else if (type === 'warning') {
                notification.classList.add('bg-yellow-500');
            }
            
            // Show the notification
            notification.classList.remove('hidden');
            
            // Hide after 3 seconds
            setTimeout(() => {
                notification.classList.add('hiding');
                
                // Remove the 'hiding' class and hide after animation completes
                setTimeout(() => {
                    notification.classList.remove('hiding');
                    notification.classList.add('hidden');
                }, 300);
            }, 3000);
        }
    }
});
