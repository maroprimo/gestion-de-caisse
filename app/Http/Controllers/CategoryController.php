<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
class CategoryController extends Controller
{
    //
    public function ajoutercategory(){

        return view('admin.categories');
    }

/*
    public function sauverCategory(Request $request)
    {
        // Créer la catégorie principale
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->parent_id = null;
        $category->save();
    
        // Vérifier et ajouter les sous-catégories si fournies
        if ($request->has('sub_category')) {
            foreach ($request->input('sub_category') as $subCategoryName) {
                $subCategory = new Category();
                $subCategory->category_name = $subCategoryName;
                $subCategory->parent_id = $category->id;
                $subCategory->save();
            }
        }
    
        return redirect()->back()->with('success', 'Catégorie et sous-catégories sauvegardées avec succès.');
    }*/


    public function sauverCategory(Request $request)
    {
        // Créer la catégorie principale
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->parent_id = null;
        $category->save();
    
        // Si des sous-catégories sont fournies, les ajouter
        if ($request->filled('sub_categories')) {
            $subCategories = json_decode($request->input('sub_categories'), true);
            $this->saveSubCategories($category->id, $subCategories);
        }
    
        return redirect()->back()->with('success', 'Catégorie et sous-catégories enregistrées avec succès.');
    }
    
    // Fonction récursive pour sauvegarder les sous-catégories
    private function saveSubCategories($parentId, $subCategories)
    {
        foreach ($subCategories as $subCategoryData) {
            // Créer la sous-catégorie
            $subCategory = new Category();
            $subCategory->category_name = $subCategoryData['name'];
            $subCategory->parent_id = $parentId;
            $subCategory->save();
    
            // Enregistrer les sous-catégories de niveau inférieur récursivement
            if (!empty($subCategoryData['sub_categories'])) {
                $this->saveSubCategories($subCategory->id, $subCategoryData['sub_categories']);
            }
        }
    }
    
  /**
     * Retourner toutes les catégories
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        // Récupérer toutes les catégories de la base de données
        $categories = Category::all();

        // Retourner les catégories sous forme de réponse JSON
        return response()->json($categories);
    }
    

}
