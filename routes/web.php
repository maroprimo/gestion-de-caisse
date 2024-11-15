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

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/liste-vente', [AdminController::class, 'listevente'])->name('admin.listevente');
Route::get('/admin/caisse', [AdminController::class, 'caisse'])->name('admin.caisse');



// ajout produit

Route::get('admin/produit-vente',[ProductsController::class, 'index'])->name('admin.produitVente');
Route::post('admin/produit-vente', [ProductsController::class, 'sauverproduit'])->name('admin.sauverproduit');
Route::get('/admin/produits/search', [ProductsController::class, 'search'])->name('produits.search');
Route::post('admin/produit-vente/ajouterprix', [ProductsController::class, 'addPrice'])->name('admin.addPrice'); 
Route::get('admin/create-productingredients', [ProductsController::class, 'createproductingre'])->name('admin.productingredient');
Route::post('admin/create-productingredients', [ProductsController::class, 'storeProductIngredients'])->name('admin.createproductingredient');





// categories
Route::get('admin/categories', [CategoryController::class, 'ajoutercategory'])->name('admin.ajoutercategory');
Route::post('admin/categories', [CategoryController::class, 'sauvercategory'])->name('admin.sauvercategory');


//ingredient

Route::get('admin/create-ingredient', [IngredientController::class, 'index'])->name('ingredients.create');
Route::post('admin/index-ingredient', [IngredientController::class, 'sauveringredient'])->name('ingredients.store');




Route::get('admin/create-vente', [SaleController::class, 'create'])->name('sales.create');
Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
Route::get('admin/liste-vente', [SaleController::class, 'index'])->name('sales.index');



// categories
Route::get('admin/suppliers', [SuppliersController::class, 'create'])->name('supplier.create');
Route::post('admin/suppliers', [SuppliersController::class, 'store'])->name('supplier.store');


Route::get('admin/create-appro', [ApprovisionnementsController::class, 'index'])->name('appro.create');
Route::post('admin/index-appro', [ApprovisionnementsController::class, 'storeSupply'])->name('appro.store');
Route::get('/admin/ingredients/search', [ApprovisionnementsController::class, 'search'])->name('appro.search');
Route::get('/admin/depenses', [ApprovisionnementsController::class, 'showExpenses'])->name('showExpenses');

//affichage stock


Route::get('admin/stock', [StockController::class, 'showStock'])->name('admin.stock');
Route::get('admin/etat', [StockController::class, 'etat'])->name('admin.etat');



