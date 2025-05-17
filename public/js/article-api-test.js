/**
 * Article API Test Script
 * This script tests the API connection to http://localhost:8080/api/articles
 * and verifies that the images are properly linked
 */

document.addEventListener('DOMContentLoaded', function() {
    const testBtn = document.getElementById('testApiBtn');
    const resultContainer = document.getElementById('apiTestResults');
    
    if (testBtn) {
        testBtn.addEventListener('click', testApiConnection);
    }
    
    function testApiConnection() {
        resultContainer.innerHTML = '<div class="p-4 bg-gray-100 rounded-md"><p>Testing API connection...</p></div>';
        
        fetch('http://localhost:8080/api/articles')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`API returned status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                let html = '<div class="p-4 bg-green-100 rounded-md mb-4">';
                html += '<p class="text-green-700 font-medium"><i class="fas fa-check-circle mr-2"></i>API Connection Successful!</p>';
                html += `<p class="text-sm text-gray-700 mt-2">Retrieved ${data.length} articles</p>`;
                html += '</div>';
                
                // Check for image paths
                const imagesWithIssues = data.filter(article => 
                    article.image && !article.image.startsWith('http') && !article.image.startsWith('https')
                );
                
                if (imagesWithIssues.length > 0) {
                    html += '<div class="p-4 bg-yellow-100 rounded-md mb-4">';
                    html += '<p class="text-yellow-700 font-medium"><i class="fas fa-exclamation-triangle mr-2"></i>Image Path Issues Found</p>';
                    html += '<p class="text-sm text-gray-700 mt-2">Found articles with relative image paths that may require storage:link setup:</p>';
                    html += '<ul class="list-disc pl-5 mt-2 text-sm">';
                    
                    imagesWithIssues.slice(0, 5).forEach(article => {
                        html += `<li>Article ID ${article.id}: Image path "${article.image}"</li>`;
                    });
                    
                    if (imagesWithIssues.length > 5) {
                        html += `<li>... and ${imagesWithIssues.length - 5} more</li>`;
                    }
                    
                    html += '</ul>';
                    html += '<p class="text-sm font-medium mt-3">Recommendation:</p>';
                    html += '<p class="text-sm text-gray-700">Run <code>php artisan storage:link</code> to create a symbolic link from public/storage to storage/app/public.</p>';
                    html += '</div>';
                }
                
                // Display sample data
                html += '<div class="mt-4"><h3 class="font-medium text-lg mb-2">Sample Data:</h3>';
                html += '<pre class="bg-gray-800 text-green-400 p-4 rounded-md overflow-auto max-h-60 text-sm">';
                html += JSON.stringify(data.slice(0, 2), null, 2);
                html += '</pre></div>';
                
                resultContainer.innerHTML = html;
            })
            .catch(error => {
                resultContainer.innerHTML = `
                <div class="p-4 bg-red-100 rounded-md">
                    <p class="text-red-700 font-medium"><i class="fas fa-times-circle mr-2"></i>API Connection Failed</p>
                    <p class="text-sm text-gray-700 mt-2">${error.message}</p>
                    <p class="text-sm font-medium mt-3">Troubleshooting Steps:</p>
                    <ul class="list-disc pl-5 mt-1 text-sm">
                        <li>Verify the API server is running at http://localhost:8080</li>
                        <li>Check if CORS is properly configured on the API server</li>
                        <li>Verify network connectivity between frontend and API</li>
                    </ul>
                </div>`;
            });
    }
});
