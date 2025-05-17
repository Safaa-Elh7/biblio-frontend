<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    protected $apiUrl = 'http://localhost:8080/api/articles';

    public function show()
    {
        return view('bibliothecaire.article');
    }

    public function index()
    {
        try {
            $response = Http::get($this->apiUrl);
            $articles = $response->json();
            
            // If this is an AJAX request, return JSON
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($articles);
            }
            
            // Otherwise return the view with articles
            return view('client.article', compact('articles'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Failed to fetch articles'], 500);
            }
            
            return back()->with('error', 'Failed to fetch articles');
        }
    }

    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'titre' => 'required|string|max:255',
                'auteur' => 'required|string|max:255',
                'contenu' => 'required|string',
                'image' => 'nullable|image|max:2048', // 2MB max
            ]);

            // Handle the image upload
            $multipart = [
                [
                    'name' => 'article',
                    'contents' => json_encode([
                        'titre' => $request->titre,
                        'auteur' => $request->auteur,
                        'contenu' => $request->contenu,
                        'id_categorie' => $request->id_categorie,
                        'annee_pub' => $request->annee_pub,
                        'isbn' => $request->isbn,
                        'langue' => $request->langue,
                        'qte' => $request->qte,
                        'prix_emprunt' => $request->prix_emprunt,
                    ]),
                    'headers' => ['Content-Type' => 'application/json']
                ]
            ];

            if ($request->hasFile('image')) {
                $multipart[] = [
                    'name' => 'image',
                    'contents' => fopen($request->file('image')->getPathname(), 'r'),
                    'filename' => $request->file('image')->getClientOriginalName()
                ];
            }

            $response = Http::asMultipart()->post($this->apiUrl, $multipart);

            if ($response->successful()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Article créé avec succès']);
                }
                
                return redirect()->route('articles.index')->with('success', 'Article créé avec succès');
            } else {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Erreur lors de la création de l\'article'], 500);
                }
                
                return back()->with('error', 'Erreur lors de la création de l\'article');
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'id' => 'required|numeric',
                'titre' => 'required|string|max:255',
                'auteur' => 'required|string|max:255',
                'contenu' => 'required|string',
                'image' => 'nullable|image|max:2048', // 2MB max
            ]);

            $id = $request->id;
            $url = $this->apiUrl . '/' . $id;

            $multipart = [
                [
                    'name' => 'article',
                    'contents' => json_encode([
                        'titre' => $request->titre,
                        'auteur' => $request->auteur,
                        'contenu' => $request->contenu,
                        'id_categorie' => $request->id_categorie,
                        'annee_pub' => $request->annee_pub,
                        'isbn' => $request->isbn,
                        'langue' => $request->langue,
                        'qte' => $request->qte,
                        'prix_emprunt' => $request->prix_emprunt,
                    ]),
                    'headers' => ['Content-Type' => 'application/json']
                ]
            ];

            if ($request->hasFile('image')) {
                $multipart[] = [
                    'name' => 'image',
                    'contents' => fopen($request->file('image')->getPathname(), 'r'),
                    'filename' => $request->file('image')->getClientOriginalName()
                ];
            }

            $response = Http::asMultipart()->put($url, $multipart);

            if ($response->successful()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Article mis à jour avec succès']);
                }
                
                return redirect()->route('articles.index')->with('success', 'Article mis à jour avec succès');
            } else {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Erreur lors de la mise à jour de l\'article'], 500);
                }
                
                return back()->with('error', 'Erreur lors de la mise à jour de l\'article');
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $id = $request->id;
            $response = Http::delete($this->apiUrl . '/' . $id);

            if ($response->successful()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Article supprimé avec succès']);
                }
                
                return redirect()->route('articles.index')->with('success', 'Article supprimé avec succès');
            } else {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json(['error' => 'Erreur lors de la suppression de l\'article'], 500);
                }
                
                return back()->with('error', 'Erreur lors de la suppression de l\'article');
            }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            
            return back()->with('error', $e->getMessage());
        }
    }

    // Add a method to get a single article
    public function getArticle($id)
    {
        try {
            $response = Http::get($this->apiUrl . '/' . $id);
            $article = $response->json();
            
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch article'], 500);
        }
    }
}