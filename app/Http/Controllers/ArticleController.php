<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $apiUrl = 'http://localhost:8081/api/articles';

    public function show()
    {
        return view('bibliothecaire.article');
    }

    public function index()
    {
        try {
            $response = Http::get($this->apiUrl);
            $articles = $response->json();
            
            // If this is an AJAX request or explicitly requested JSON, return JSON
            if (request()->ajax() || request()->wantsJson() || request()->has('json')) {
                return response()->json($articles);
            }
            
            // Otherwise return the view with articles
            return view('client.article', compact('articles'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson() || request()->has('json')) {
                return response()->json(['error' => 'Failed to fetch articles: ' . $e->getMessage()], 500);
            }
            
            return back()->with('error', 'Failed to fetch articles: ' . $e->getMessage());
        }
    }

    // Store a new article
    public function store(Request $request)
    {
        try {
            // Handle file upload if there's an image
            $imagePath = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $imagePath = 'articles/' . $imageName;
            }

            // Prepare data for API
            $data = $request->except(['_token', 'image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            // Send to API
            $response = Http::post($this->apiUrl, $data);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API returned error: ' . $response->status()
                ], $response->status());
            }

            return response()->json([
                'success' => true,
                'message' => 'Article créé avec succès',
                'data' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de l\'article: ' . $e->getMessage()
            ], 500);
        }
    }

    // Update an existing article
    public function update(Request $request, $id)
    {
        try {
            // Vérification de l'ID
            if (!$id || !is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID d\'article invalide'
                ], 400);
            }

            // Handle file upload if there's an image
            $imagePath = null;
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/articles', $imageName);
                $imagePath = 'articles/' . $imageName;
            }

            // Prepare data for API
            $data = $request->except(['_token', '_method', 'image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            }

            // Send to API - using PUT method regardless of how the request came in
            $response = Http::put($this->apiUrl . '/' . $id, $data);

            if (!$response->successful()) {
                $errorMessage = 'API returned error: ' . $response->status();
                // Essayer d'extraire un message d'erreur plus précis si disponible
                if ($response->json() && isset($response->json()['message'])) {
                    $errorMessage = $response->json()['message'];
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], $response->status());
            }

            return response()->json([
                'success' => true,
                'message' => 'Article mis à jour avec succès',
                'data' => $response->json()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour de l\'article: ' . $e->getMessage()
            ], 500);
        }
    }

    // Delete an article
    public function destroy($id)
    {
        try {
            // Vérification de l'ID
            if (!$id || !is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID d\'article invalide'
                ], 400);
            }

            // Vérifier si l'article existe avant de le supprimer
            $checkResponse = Http::get($this->apiUrl . '/' . $id);
            if (!$checkResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Article introuvable avec cet ID'
                ], 404);
            }

            $response = Http::delete($this->apiUrl . '/' . $id);

            if (!$response->successful()) {
                $errorMessage = 'API returned error: ' . $response->status();
                // Essayer d'extraire un message d'erreur plus précis si disponible
                if ($response->json() && isset($response->json()['message'])) {
                    $errorMessage = $response->json()['message'];
                }
                
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], $response->status());
            }

            return response()->json([
                'success' => true,
                'message' => 'Article supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de l\'article: ' . $e->getMessage()
            ], 500);
        }
    }

    // Ensure getArticle handles exceptions properly
    public function getArticle($id)
    {
        try {
            $response = Http::get($this->apiUrl . '/' . $id);
            
            if (!$response->successful()) {
                return response()->json(['error' => 'API returned error: ' . $response->status()], $response->status());
            }
            
            $article = $response->json();
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch article: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Check if storage link is properly set up
     */
    public function checkStorageLink()
    {
        try {
            $publicStoragePath = public_path('storage');
            $storageAppPublicPath = storage_path('app/public');
            
            // Check if the symbolic link exists
            $linkExists = file_exists($publicStoragePath) && is_link($publicStoragePath);
            
            // Check if the target is correct
            $correctTarget = $linkExists && readlink($publicStoragePath) === $storageAppPublicPath;
            
            if ($linkExists && $correctTarget) {
                return response()->json([
                    'exists' => true,
                    'message' => 'Storage link is properly set up.'
                ]);
            } else {
                $message = !$linkExists 
                    ? 'Storage link does not exist.' 
                    : 'Storage link exists but points to incorrect location.';
                
                return response()->json([
                    'exists' => false,
                    'message' => $message,
                    'command' => 'php artisan storage:link'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'message' => 'Error checking storage link: ' . $e->getMessage()
            ]);
        }
    }
    
    /**
     * Test API connectivity to ensure the correct API endpoint is working
     */
    public function testApiConnection()
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl);
            
            if ($response->successful()) {
                $articles = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully connected to API',
                    'status_code' => $response->status(),
                    'article_count' => count($articles),
                    'sample' => array_slice($articles, 0, 2)
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'API returned error status',
                    'status_code' => $response->status()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to connect to API: ' . $e->getMessage()
            ]);
        }
    }
}