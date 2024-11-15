<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Ingredient;
use App\Models\SaleIngredientUsage;
use App\Models\ProductPrice;
use App\Models\Unit;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ProductIngredient;
use App\Models\StockIngredient;



class SaleController extends Controller
{
    public function create()
    {
        $products = Product::all();
        $units= Unit::all();
        return view('admin.create-vente', compact('products', 'units'));
    }

    public function store(Request $request)
    {
        // Validation des données reçues
        $validated = $request->validate([
            'sale_date' => 'required|date',
            'total_amount' => 'required|numeric',
            'items' => 'required|array',
        ]);

        try {
            // Insérer la vente dans la table 'sales'
            $sale_date = Carbon::parse($validated['sale_date'])->format('Y-m-d H:i:s');

            $sale = DB::table('sales')->insert([
                'sale_date' => $sale_date,
                'total_amount' => $validated['total_amount'],
            ]);

            // Récupérer l'ID de la vente
            $saleId = DB::getPdo()->lastInsertId();

            // Insérer les items associés à la vente dans 'sale_items'
            foreach ($validated['items'] as $item) {
                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'], // Assurez-vous d'inclure le champ 'price'
                    'subtotal' => $item['subtotal'],
                ]);
            }
            // Appeler la méthode processSale pour traiter le stock des ingrédients
            $this->processSale($saleId);
            // Retourner une réponse JSON de succès
            return response()->json(['success' => true, 'message' => 'Vente enregistrée avec succès']);
        } catch (\Exception $e) {
            // Retourner une réponse d'erreur avec le message d'exception
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de la vente: ' . $e->getMessage()], 500);
        }
    }


    public function index()
    {
        /*
        La méthode with('product') indique à Laravel de récupérer également les informations des produits associés aux ventes. Cela se fait grâce à une relation définie dans le modèle Sale.
                // Dans le modèle Sale
            public function product() {
                return $this->belongsTo(Product::class);
            }
        */
        
        $totalvente = SaleItem::sum('subtotal');
         
        $sales = Sale::with('saleItems.product')->get();
        return view('admin.liste-vente', compact('sales', 'totalvente'));
    }

// vente produit et reduction stock

        protected function processSale($saleId)

        {
            $saleItems = SaleItem::where('sale_id', $saleId)->get();

            foreach ($saleItems as $item) {
                // Récupérer les ingrédients pour chaque produit vendu
                $productIngredients = ProductIngredient::where('product_id', $item->product_id)->get();

                foreach ($productIngredients as $productIngredient) {
                    $stockingredient = StockIngredient::find($productIngredient->ingredient_id);

                    // Calculer la quantité totale à déduire
                    $requiredQuantity = $productIngredient->quantity * $item->quantity;

                    // Mettre à jour le stock d'ingrédient
                    $stockingredient->current_stock = max(0, $stockingredient->current_stock - $requiredQuantity);
                    $stockingredient->save();
                }
            }
        }



}
