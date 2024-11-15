@extends('layouts.admin')

@section('title')

Ajouter ingredient
    
@endsection

@section('content')
<style>








    select, input[type="number"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s;
        font-size: 14px;
    }

    select:focus, input[type="number"]:focus {
        border-color: #4CAF50;
    }

    .ingredient-row {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }

    .ingredient-row .form-group {
        flex: 1;
    }

    #add-ingredient, .remove-ingredient, [type="submit"] {
        background-color: #4CAF50;
        color: #ffffff;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
        font-size: 14px;
    }

    #add-ingredient:hover, .remove-ingredient:hover, [type="submit"]:hover {
        background-color: #45a049;
    }

    .remove-ingredient {
        background-color: #e74c3c;
        margin-top: 15px;
    }

    .remove-ingredient:hover {
        background-color: #c0392b;
    }

    #add-ingredient {
        display: block;
        margin: 20px 0;
        width: 100%;
    }

    [type="submit"] {
        width: 100%;
        font-size: 16px;
        margin-bottom: 20px;
    }

    /* Animation for adding/removing rows */
    .ingredient-row {
        transition: opacity 0.3s ease-in-out;
    }

    .ingredient-row.removed {
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }
</style>
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="col-lg-12 col-xl-12">
                        @if (Session::has('success'))
                        <div class="alert alert-success">
                        {{Session::get('success')}}
            
                        </div>
                    
                        @endif

                        <div class="card-header">
                            <h5>Ajouter ingredients</h5>

                          </div>

                        <form id="productIngredientForm" method="POST" action="{{route('admin.createproductingredient')}}">
                            @csrf
                            <div class="form-group">
                                
                                <select name="product_id" id="product" required>
                                    <!-- Remplissez les options avec vos produits depuis le backend -->
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->designation }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div id="ingredient-container">
                                <div class="ingredient-row">
                                    <div class="form-group">
                                        <label for="ingredient">Ingrédient</label>
                                        <select name="ingredients[0][ingredient_id]" class="ingredient" required>
                                            <!-- Remplissez les options avec vos ingrédients depuis le backend -->
                                            @foreach($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}">{{ $ingredient->designation }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="quantity">Quantité</label>
                                        <input type="number" name="ingredients[0][quantity]" class="quantity" step="0.001" required>
                                    </div>
                                    <button type="button" class="remove-ingredient" onclick="removeIngredient(this)">Supprimer</button>
                                </div>
                            </div>
                        
                            <button type="button" id="add-ingredient">Ajouter un ingrédient</button>
                            <button type="submit">Enregistrer le produit avec ses ingrédients</button>
                        </form>
                        
                    </div>
                    
                </div>

                <div class="card">
                    <div class="card-header">
                      <h5>Liste produits</h5>
                      <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                          <li>
                            <i class="icofont icofont-simple-left"></i>
                          </li>
                          <li>
                            <i class="icofont icofont-maximize full-card"></i>
                          </li>
                          <li>
                            <i class="icofont icofont-minus minimize-card"></i>
                          </li>
                          <li>
                            <i class="icofont icofont-refresh reload-card"></i>
                          </li>
                          <li>
                            <i class="icofont icofont-error close-card"></i>
                          </li>
                        </ul>
                      </div>
                    </div>
                    <div class="card-block table-border-style">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>Nom du produit</th>
                              <th>Ingredients</th>
                              <th>Coût ingrédients</th>
                              <th>Prix de vente</th>
                              <th>Bénéfice</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($products as $product) 
                            <tr class="table-active">
                              <th style="text-align: center; vertical-align: middle;" scope="row">
                                <div class="label-main">
                                    <label style="font-size:15px" class="label label-warning">{{$product->designation}}</label>
                                </div></th>
                              
                              
                            <td style="text-align: center; word-wrap: break-word; ">
                                <ul>
                                    @foreach($product->productIngredients as $productIngredient)
                                    
                                       <li> <label class="label label-danger">{{ $productIngredient->ingredient->designation }} - Coût: {{ $productIngredient->ingredient_cost }}</label></li>
                                                                      
                                    @endforeach
                                </ul>
                              </td>
                            <td style="text-align: center; vertical-align: middle;">{{ number_format($product->calculateIngredientCost(), 2, ',', ' ') }}</td> <!-- Affiche la catégorie associée -->                             
                            @foreach ($product->prices as $price)
                                
                            
                            <td style="text-align: center; vertical-align: middle;">{{number_format($price->main_unit_price, 2, ',', ' ')}} Ar</td>
                            @endforeach
                            @php
                                    $mainUnitPrice = $price->main_unit_price ?? 0;
                                    $ingredientCost = $product->calculateIngredientCost();
                                    $benefice = $mainUnitPrice - $ingredientCost;
                            @endphp
                            <td style="text-align: center; vertical-align: middle;">{{ number_format($benefice, 2, ',', ' ') }} Ar</td>
                              <td style="text-align: center; vertical-align: middle;">
                                  <button class="btn btn-warning btn-outline-warning">
                                      <i class="icofont icofont-edit"></i>
                                  </button>
                                  <button class="btn btn-danger btn-outline-danger">
                                      <i class="icofont icofont-trash"></i>
                                  </button>
                              </td>
                              
                             
                            </tr>
                            @endforeach 
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

            </div>
        </div>
    </div>
        

    </div>
</div>
    
@endsection

@section('script')
<script>
document.getElementById('add-ingredient').addEventListener('click', addIngredient);

function addIngredient() {
    const container = document.getElementById('ingredient-container');
    const index = container.children.length; // Compter le nombre actuel de lignes d'ingrédients

    // Créer une nouvelle ligne pour les ingrédients
    const ingredientRow = document.createElement('div');
    ingredientRow.classList.add('ingredient-row');

    ingredientRow.innerHTML = `
        <div class="form-group">
            <label for="ingredient">Ingrédient</label>
            <select name="ingredients[${index}][ingredient_id]" class="ingredient" required>
                @foreach($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}">{{ $ingredient->designation }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantité</label>
            <input type="number" name="ingredients[${index}][quantity]" class="quantity" step="0.001" required>
        </div>
        <button type="button" class="remove-ingredient" onclick="removeIngredient(this)">Supprimer</button>
    `;

    container.appendChild(ingredientRow);
}

function removeIngredient(button) {
    // Supprimer la ligne d'ingrédient
    button.parentElement.remove();
}

</script>
    
@endsection

