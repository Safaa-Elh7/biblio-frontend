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
                return response()->json([
                    'success' => false,
                    'message' => 'API returned error: ' . $response->status()
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
            $response = Http::delete($this->apiUrl . '/' . $id);

            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'API returned error: ' . $response->status()
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
}