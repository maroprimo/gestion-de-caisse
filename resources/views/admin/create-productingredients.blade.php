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

                          <div class="form-group row">
    <label class="col-sm-2 col-form-label">Type de produit</label>
    <div class="col-sm-10">
        <input type="radio" id="contactChoice1" name="produit" value="0" onclick="toggleForm(0)" />
        <label for="contactChoice1">Produits finis</label>

        <input type="radio" id="contactChoice2" name="produit" value="1" onclick="toggleForm(1)" />
        <label for="contactChoice2">Produits de marchandises</label>
    </div>
</div>

<!-- Formulaire pour Produits finis -->
<form id="productIngredientFormFinished" method="POST" action="{{route('admin.createproductingredient')}}" style="display: none;">
    @csrf
    <div class="form-group">
    <select name="product_id" id="productFinished" required>
        @foreach($products as $product)
            @if($product->type_produit == 0)
                <option value="{{ $product->id }}">{{ $product->designation }}</option>
            @endif
        @endforeach
    </select>
</div>

    <div id="ingredient-container">
        <div class="ingredient-row">
            <div class="form-group">
                <label for="ingredient">Ingrédient</label>
                <select name="ingredients[0][ingredient_id]" class="ingredient" required>
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

<!-- Formulaire pour Produits de marchandises -->
<form id="productIngredientFormMerchandise" method="POST" action="{{route('admin.createproductingredient')}}" style="display: none;">
    @csrf
    <div class="form-group">
    <label for="productMerchandise">Produit</label>
    <select name="product_id" id="productMerchandise" required>
        <option value="">-- Sélectionner un produit --</option>
        @foreach($products as $product)
            @if($product->type_produit == 1) 
                <option value="{{ $product->id }}" data-choice="{{ $product->type_produit }}">
                    {{ $product->designation }}
                </option>
            @endif
        @endforeach
    </select>
</div>

<div id="unit-container" style="display: none;">
    <div class="form-group">
        <label for="unites">Unité</label>
        <select name="unite" class="units" id="unites">
            <option value="">-- Sélectionner une unité --</option>
            <!-- Les unités seront chargées dynamiquement ici -->
        </select>
    </div>

    <div class="form-group">
        <label for="quantity">Quantité</label>
        <input type="number" name="quantity" class="quantity" step="0.001" required>
    </div>
</div>


    <button type="submit">Enregistrer le produit</button>
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
                              
                              
                                <td style="text-align: center; word-wrap: break-word;">
                                    <ul>
                                        @foreach($product->productIngredients as $productIngredient)
                                            <li>
                                                @if ($productIngredient->ingredient)
                                                    <label class="label label-danger">
                                                        {{ $productIngredient->ingredient->designation }} - Coût: {{ $productIngredient->ingredient_cost }}
                                                    </label>
                                                @else
                                                    <!-- Afficher l'unité ici si l'ingrédient est null -->
                                                    <label class="label label-warning">
                                                    {{ $productIngredient->unite ?? 'Pas d\'unité' }} <!-- Affiche l'unité ou un message alternatif -->
                                                    </label>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if ($product->type_produit == 1)
                                        {{ number_format($product->getPurchasePrice(), 2, ',', ' ') }} €
                                    @else
                                        {{ number_format($product->calculateIngredientCost(), 2, ',', ' ') }}
                                    @endif
                                </td>



                            
                            @foreach ($product->prices as $price)

                            
                                
                            <td style="text-align: center; vertical-align: middle;">{{number_format($price->main_unit_price, 2, ',', ' ')}} Ar</td>
                            @endforeach
                            @php
                            if ($product->type_produit == 1) {
                                $mainUnitPrice = $price->main_unit_price ?? 0;
                                $ingredientCost = $product->getPurchasePrice();
                                $benefice = $mainUnitPrice - $ingredientCost;
                            } else {
                                $mainUnitPrice = $price->main_unit_price ?? 0;
                                $ingredientCost = $product->calculateIngredientCost();
                                $benefice = $mainUnitPrice - $ingredientCost;
                            }
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

function toggleForm(value) {
    document.getElementById('productIngredientFormFinished').style.display = (value == 0) ? 'block' : 'none';
    document.getElementById('productIngredientFormMerchandise').style.display = (value == 1) ? 'block' : 'none';
}

function removeIngredient(element) {
    element.parentElement.remove();
}

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

document.addEventListener("DOMContentLoaded", function () {
    const productMerchandiseSelect = document.querySelector('#productMerchandise'); // Sélecteur du produit
    const unitContainer = document.getElementById("unit-container");
    const unitSelect = document.getElementById("unites"); // Sélecteur des unités

    if (productMerchandiseSelect) {
        productMerchandiseSelect.addEventListener("change", function () {
            const productId = this.value;
            const typeProduit = this.options[this.selectedIndex].dataset.choice; // Récupérer type_produit

            if (typeProduit === "1") { // Vérifie si c'est un produit de marchandise
                unitContainer.style.display = "block"; // Afficher le conteneur des unités

                // Récupérer dynamiquement les unités associées au produit sélectionné
                fetch(`/get-units/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        unitSelect.innerHTML = '<option value="">-- Sélectionner une unité --</option>';
                        if (data.main_unit) {
                            unitSelect.innerHTML += `<option value="${data.main_unit}">${data.main_unit}</option>`;
                        }
                        if (data.sub_unit) {
                            unitSelect.innerHTML += `<option value="${data.sub_unit}">${data.sub_unit}</option>`;
                        }
                    })
                    .catch(error => console.error('Erreur lors de la récupération des unités :', error));
            } else {
                unitContainer.style.display = "none"; // Cacher le conteneur si ce n'est pas une marchandise
            }
        });
    }
});
</script>
    
@endsection

