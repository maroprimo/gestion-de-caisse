<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ApprovisionnementsController;
use App\Http\Controllers\StockIngredient;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminPasswordController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\StockController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', function () {
    return view('auth.login'); // Assurez-vous d'avoir un fichier login.blade.php dans resources/views/auth
})->name('login');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// proteger


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/liste-vente', [AdminController::class, 'listevente'])->name('admin.listevente');
    Route::get('/admin/caisse', [AdminController::class, 'caisse'])->name('admin.caisse');

    // Ajout produit
    Route::get('admin/produit-vente',[ProductsController::class, 'index'])->name('admin.produitVente');
    Route::post('admin/produit-vente', [ProductsController::class, 'sauverproduit'])->name('admin.sauverproduit');
    Route::get('/admin/produits/search', [ProductsController::class, 'search'])->name('produits.search');
    Route::post('admin/produit-vente/ajouterprix', [ProductsController::class, 'addPrice'])->name('admin.addPrice'); 
    Route::get('admin/create-productingredients', [ProductsController::class, 'createproductingre'])->name('admin.productingredient');
    Route::post('admin/create-productingredients', [ProductsController::class, 'storeProductIngredients'])->name('admin.createproductingredient');

    // Ajout clients
    Route::get('admin/clients', [ClientController::class, 'create'])->name('admin.createclient');
    Route::post('admin/clients', [ClientController::class, 'store'])->name('admin.storeclient');

    // Catégories
    Route::get('admin/categories', [CategoryController::class, 'ajoutercategory'])->name('admin.ajoutercategory');
    Route::post('admin/categories', [CategoryController::class, 'sauvercategory'])->name('admin.sauvercategory');

    // Ingrédients
    Route::get('admin/create-ingredient', [IngredientController::class, 'index'])->name('ingredients.create');
    Route::post('admin/index-ingredient', [IngredientController::class, 'sauveringredient'])->name('ingredients.store');

    // Ventes
    Route::get('admin/create-vente', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('admin/liste-vente', [SaleController::class, 'index'])->name('sales.index');

    // Fournisseurs
    Route::get('admin/suppliers', [SuppliersController::class, 'create'])->name('supplier.create');
    Route::post('admin/suppliers', [SuppliersController::class, 'store'])->name('supplier.store');

    // Approvisionnements
    Route::get('admin/create-appro', [ApprovisionnementsController::class, 'index'])->name('appro.create');
    Route::post('admin/index-appro', [ApprovisionnementsController::class, 'storeSupply'])->name('appro.store');
    Route::get('/admin/ingredients/search', [ApprovisionnementsController::class, 'search'])->name('appro.search');
    Route::get('/admin/depenses', [ApprovisionnementsController::class, 'showExpenses'])->name('showExpenses');

    // Stock
    Route::get('admin/stock', [StockController::class, 'showStock'])->name('admin.stock');
    Route::get('admin/etat', [StockController::class, 'etat'])->name('admin.etat');

    Route::get('/get-units/{productId}', [ProductsController::class, 'getUnits']);
});
