<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Employé - MyBookSpace</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .bg-red-800 {
            background-color: #9b2c2c;
        }

        .hover\:bg-red-900:hover {
            background-color: #742a2a;
        }

        .focus\:ring-red-800:focus {
            --tw-ring-color: rgba(155, 44, 44, 0.5);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }

            .overflow-x-auto {
                margin-left: -1rem;
                margin-right: -1rem;
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            .logout-text {
                display: none;
            }
        }
        
        .logout-btn {
            background-color: #9b2c2c;
            color: white;
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-left: 0.75rem;
        }
        
        .logout-btn:hover {
            background-color: #742a2a;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        
        .logout-btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(155, 44, 44, 0.5);
        }
        
        .selected-row {
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/40" alt="Logo" class="rounded-full mr-3">
            <h1 class="text-2xl font-bold text-gray-800">MyBookSpace</h1>
        </div>
        <div class="flex items-center">
            <div class="relative mr-4">
                <input type="text" placeholder="Rechercher..." class="border rounded-md py-2 px-4 focus:outline-none focus:ring-2 focus:ring-red-800 w-64">
                <svg xmlns="http://www.w3.org/2000/svg" class="absolute right-3 top-3 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            
            <!-- Bouton de déconnexion -->
            <button class="logout-btn">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="logout-text">Déconnexion</span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Gestion des Articles et Amendes</h2>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Liste des Articles et Amendes</h3>
                    <button class="bg-red-800 hover:bg-red-900 text-white py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter un article
                    </button>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white" id="articlesTable">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Article</th>
                                <th class="py-3 px-6 text-left">User</th>
                                <th class="py-3 px-6 text-left">Date de retour prévue</th>
                                <th class="py-3 px-6 text-left">Date de retour réelle</th>
                                <th class="py-3 px-6 text-center">Retard (jours)</th>
                                <th class="py-3 px-6 text-center">Amende (Dhs)</th>
                                <th class="py-3 px-6 text-center">État de l'amende</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm" id="articlesTableBody">
                            <!-- Table rows will be inserted here by JavaScript -->
                        </tbody>
                    </table>
                </div>

                <!-- Action Buttons -->
                <div class="flex mt-6 gap-2">
                    <button id="addBtn" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Ajouter
                    </button>
                    <button id="editBtn" class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </button>
                    <button id="deleteBtn" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded flex items-center opacity-50 cursor-not-allowed" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Sample data for articles and fines
        const articles = [
            {
                id: 1,
                title: "Le Petit Prince",
                user: "Ahmed Benali",
                expectedReturnDate: "10/05/2023",
                actualReturnDate: "15/05/2023",
                delayDays: 5,
                fine: 50,
                fineStatus: "paye"
            },
            {
                id: 2,
                title: "1984",
                user: "Fatima Zahra",
                expectedReturnDate: "12/05/2023",
                actualReturnDate: "12/05/2023",
                delayDays: 0,
                fine: 0,
                fineStatus: "paye"
            },
            {
                id: 3,
                title: "Harry Potter à l'école des sorciers",
                user: "Karim Idrissi",
                expectedReturnDate: "05/05/2023",
                actualReturnDate: "15/05/2023",
                delayDays: 10,
                fine: 100,
                fineStatus: "non-paye"
            },
            {
                id: 4,
                title: "L'Étranger",
                user: "Nadia Tazi",
                expectedReturnDate: "08/05/2023",
                actualReturnDate: "16/05/2023",
                delayDays: 8,
                fine: 80,
                fineStatus: "non-paye"
            },
            {
                id: 5,
                title: "Les Misérables",
                user: "Youssef Alami",
                expectedReturnDate: "01/05/2023",
                actualReturnDate: "03/05/2023",
                delayDays: 2,
                fine: 20,
                fineStatus: "paye"
            }
        ];

        // DOM elements
        const tableBody = document.getElementById('articlesTableBody');
        const addBtn = document.getElementById('addBtn');
        const editBtn = document.getElementById('editBtn');
        const deleteBtn = document.getElementById('deleteBtn');
        
        let selectedArticleId = null;

        // Function to get fine status badge HTML
        function getFineStatusBadge(status) {
            let badgeClass = '';
            let statusText = '';

            switch (status) {
                case 'paye':
                    badgeClass = 'bg-green-100 text-green-800';
                    statusText = 'Payé';
                    break;
                case 'non-paye':
                    badgeClass = 'bg-red-100 text-red-800';
                    statusText = 'Non payé';
                    break;
                default:
                    badgeClass = 'bg-gray-100 text-gray-800';
                    statusText = 'Inconnu';
            }

            return `<span class="${badgeClass} py-1 px-3 rounded-full text-xs">${statusText}</span>`;
        }

        // Function to render articles
        function renderArticles() {
            tableBody.innerHTML = '';
            
            articles.forEach(article => {
                const row = document.createElement('tr');
                row.className = `border-b border-gray-200 hover:bg-gray-50 cursor-pointer ${selectedArticleId === article.id ? 'selected-row' : ''}`;
                row.dataset.id = article.id;
                
                row.innerHTML = `
                    <td class="py-3 px-6 text-left">${article.title}</td>
                    <td class="py-3 px-6 text-left">${article.user}</td>
                    <td class="py-3 px-6 text-left">${article.expectedReturnDate}</td>
                    <td class="py-3 px-6 text-left">${article.actualReturnDate}</td>
                    <td class="py-3 px-6 text-center">${article.delayDays}</td>
                    <td class="py-3 px-6 text-center">${article.fine}</td>
                    <td class="py-3 px-6 text-center">${getFineStatusBadge(article.fineStatus)}</td>
                `;
                
                row.addEventListener('click', () => selectArticle(article.id));
                tableBody.appendChild(row);
            });
        }

        // Function to select an article
        function selectArticle(id) {
            selectedArticleId = id;
            renderArticles();
            updateButtonStates();
        }

        // Function to update button states
        function updateButtonStates() {
            const isSelected = selectedArticleId !== null;
            
            if (isSelected) {
                addBtn.disabled = false;
                addBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                editBtn.disabled = false;
                editBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                
                deleteBtn.disabled = false;
                deleteBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                addBtn.disabled = true;
                addBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                editBtn.disabled = true;
                editBtn.classList.add('opacity-50', 'cursor-not-allowed');
                
                deleteBtn.disabled = true;
                deleteBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        // Function to delete an article
        function deleteArticle() {
            if (selectedArticleId) {
                const index = articles.findIndex(a => a.id === selectedArticleId);
                if (index !== -1) {
                    articles.splice(index, 1);
                    selectedArticleId = null;
                    renderArticles();
                    updateButtonStates();
                }
            }
        }

        // Event listeners for buttons
        deleteBtn.addEventListener('click', deleteArticle);
        
        // Ajouter un événement pour le bouton de déconnexion
        document.querySelector('.logout-btn').addEventListener('click', function() {
            alert('Déconnexion en cours...');
            // Ici vous pouvez rediriger vers la page de connexion
            // window.location.href = 'login.html';
        });

        // Initial render
        renderArticles();
        updateButtonStates();
    </script>
</body>
</html>