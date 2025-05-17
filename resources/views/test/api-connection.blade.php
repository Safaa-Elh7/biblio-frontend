@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">API Connection Test</h1>
        
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Test API Connection to http://localhost:8080/api/articles</h2>
            <p class="text-gray-600 mb-4">
                Use this tool to check the connection to your articles API and verify that image storage links are properly set up.
            </p>
            <div class="flex items-center space-x-4">
                <button id="testApiBtn" class="bg-primary hover:bg-primary-dark text-white font-bold py-2 px-4 rounded transition duration-200">
                    <i class="fas fa-vial mr-2"></i> Test Connection
                </button>
                <button id="checkStorageBtn" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200">
                    <i class="fas fa-link mr-2"></i> Check Storage Link
                </button>
            </div>
        </div>
        
        <div id="apiTestResults" class="mb-6">
            <!-- API test results will be displayed here -->
        </div>
        
        <div id="storageTestResults" class="mb-6">
            <!-- Storage test results will be displayed here -->
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Setup Instructions</h2>
            
            <div class="mb-4">
                <h3 class="font-medium text-lg">1. API Configuration</h3>
                <p class="text-gray-600">Verify that ArticleController.php is using the correct API URL:</p>
                <pre class="bg-gray-100 p-3 mt-2 rounded-md">protected $apiUrl = 'http://localhost:8080/api/articles';</pre>
            </div>
            
            <div class="mb-4">
                <h3 class="font-medium text-lg">2. Storage Link Setup</h3>
                <p class="text-gray-600">Run the following command to create a symbolic link from public/storage to storage/app/public:</p>
                <pre class="bg-gray-100 p-3 mt-2 rounded-md">php artisan storage:link</pre>
            </div>
            
            <div>
                <h3 class="font-medium text-lg">3. CORS Configuration</h3>
                <p class="text-gray-600">If you're experiencing CORS issues, add the following headers to your API responses:</p>
                <pre class="bg-gray-100 p-3 mt-2 rounded-md">
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, X-Token-Auth, Authorization');
                </pre>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('checkStorageBtn').addEventListener('click', function() {
        const resultContainer = document.getElementById('storageTestResults');
        resultContainer.innerHTML = '<div class="p-4 bg-gray-100 rounded-md"><p>Checking storage link setup...</p></div>';
        
        fetch('/check-storage-link')
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    resultContainer.innerHTML = `
                    <div class="p-4 bg-green-100 rounded-md">
                        <p class="text-green-700 font-medium"><i class="fas fa-check-circle mr-2"></i>Storage Link Setup Correctly</p>
                        <p class="text-sm text-gray-700 mt-2">The symbolic link from public/storage to storage/app/public exists.</p>
                    </div>`;
                } else {
                    resultContainer.innerHTML = `
                    <div class="p-4 bg-red-100 rounded-md">
                        <p class="text-red-700 font-medium"><i class="fas fa-times-circle mr-2"></i>Storage Link Not Set Up</p>
                        <p class="text-sm text-gray-700 mt-2">${data.message}</p>
                        <p class="text-sm font-medium mt-3">Solution:</p>
                        <p class="text-sm text-gray-700">Run <code>php artisan storage:link</code> command to create the symbolic link.</p>
                    </div>`;
                }
            })
            .catch(error => {
                resultContainer.innerHTML = `
                <div class="p-4 bg-red-100 rounded-md">
                    <p class="text-red-700 font-medium"><i class="fas fa-times-circle mr-2"></i>Error Checking Storage Link</p>
                    <p class="text-sm text-gray-700 mt-2">An error occurred while checking the storage link: ${error.message}</p>
                </div>`;
            });
    });
</script>

<script src="{{ asset('js/article-api-test.js') }}"></script>
@endsection
