@extends('layouts.admin')

@section('title')

Approvissionnement
    
@endsection

@section('content')
<div class="main-body">
    <div class="page-wrapper">
      <div class="page-header card">
        <div class="row align-items-end">
          <div class="col-lg-8">
            <div class="page-header-title">
              <i class="ti-pencil-alt bg-c-blue"></i>
              <div class="d-inline">
                <h4>Ajouter</h4>
                <span>Aprovissionnement</span>
                @if (Session::has('success'))
                <div class="alert alert-success">
                  {{Session::get('success')}}
      
                </div>
              
                @endif
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="page-header-breadcrumb">
              <ul class="breadcrumb-title">
                <li class="breadcrumb-item">
                  <a href="index.html">
                    <i class="icofont icofont-home"></i>
                  </a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#!">Form Components</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="#!">Form Components</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="page-body">
        <div class="row">
          <div class="col-sm-12">
            <div class="card">
              <div class="col-lg-12 col-xl-12">
                <ul class="nav nav-tabs tabs" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Approvissionnement</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile1" role="tab">Prix</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#messages1" role="tab">Code barre</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#settings1" role="tab">Settings</a>
                  </li>
                </ul>
                <div class="tab-content tabs card-block">
                  <div class="tab-pane active" id="home1" role="tabpanel">
                    <div class="card-block">
                      <form action="{{ route('appro.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Designation</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                placeholder="Nom du produit" id='designation' name="designation" onkeyup="searchProduit(this.value)">
                            </div>
                        </div>
                        <div id="suggestions" style="display: none;">
                          
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Quantité</label>
                          <div class="col-sm-10">
                              <input id="quantity" type="number" class="form-control"
                              placeholder="" name="quantity">
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">date</label>
                        <div class="col-sm-10">
                            <input id="date" type="date" class="form-control"
                            placeholder="" name="date">
                        </div>
                    </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Prix unitaire</label>
                        <div class="col-sm-10">
                            <input id="prix_unitaire" type="number" class="form-control"
                            placeholder="" name="price">
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Amont</label>
                      <div class="col-sm-10">
                          <input type="text" class="form-control" placeholder="" name="total_amount" id="total" readonly>
                      </div>
                  </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Seuil d'alerte</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" id="alert-threshold" placeholder="Seuil d'alerte" name="seuil" oninput="updateAlertThreshold()">
                              <span class="form-bg-primary" id="alert-threshold-display"></span>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Fournisseur</label>
                            <div class="col-sm-10">
                                <select name="supplier_id"  class="form-control">
                                  <option value="">Sélectionnez fournisseur</option>
                                  @foreach ($suppliers as $supplier)
                                  <option value="{{$supplier->id}}">{{$supplier->name}}</option>   
                                  @endforeach
                                </select>
                          </div>
                      </div>
                        <div class="form-group row">
                          <button class="btn btn-success btn-outline-success">
                            <i class="icofont icofont-save"></i>Approvisionner
                          </button>
                        </div>
                      </form>
                    </div>
                    <div class="card">
                      <div class="card-header">
                        <h5>Liste des ingredients</h5>
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
                                <th>#</th>
                                <th>Designation</th>
                                <th>Fournisseur</th>
                                <th>Unité</th>
                                <th>Seuil alert</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                             {{-- @foreach ($produits as $produit)
                              <tr class="table-active">
                                
                                    
                                
                                <th scope="row">1</th>
                                
                                
                                <td>{{$produit->designation}}</td>
                                  <td>{{ $produit->category ? $produit->category->category_name : 'Aucune catégorie' }}</td> <!-- Affiche la catégorie associée -->
                                
                                  <td>1 {{ $produit->main_unit }}
                                    @if ($produit->units->isNotEmpty())
                                        = 
                                        @foreach ($produit->units as $unit)
                                            {{ $unit->conversion_rate }} {{ $unit->name }}
                                            @if (!$loop->last)
                                                , 
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                
                                
                                <td>{{$produit->seuil}} {{$produit->main_unit}}</td>
                                <td>
                                    <button class="btn btn-warning btn-outline-warning">
                                        <i class="icofont icofont-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-outline-danger">
                                        <i class="icofont icofont-trash"></i>
                                    </button>
                                </td>
                                
                                
                              </tr>
                              @endforeach--}}
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="profile1" role="tabpanel">
                     {{-- @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    <form action="{{ route('admin.addPrice') }}" method="POST">
                      @csrf
                      <label for="produit">Désignation :</label>
                      <input type="text" id="produit" name="produit" onkeyup="searchProduit(this.value)">
                      
                  
                      <div id="suggestions" style="display: none;"></div>
                  
                      
                  
                      <button type="submit">Enregistrer le prix</button>--}}
                  </form>

                  <div class="card-block table-border-style">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Designation</th>
                            <th>Prix unitaire</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach ($produits as $produit)
                          <tr class="table-active">
                            
                                
                            
                            <th scope="row">1</th>
                            
                            
                            <td>{{$produit->designation}}</td>
                            <td>
                              @foreach($produit->prices as $price)
                                  <!-- Afficher le prix principal -->
                                  @foreach ($produit->units as $unit)
                                  @if ($price->main_unit_price !== null)
                                  <div>{{ $unit->main_unit }} = {{ $price->main_unit_price }} Ar</div>     
                                  @endif
                                  
                                  
                                  <!-- Afficher les prix des sous-unités seulement si sub_unit_price n'est pas null -->
                                  
                                      @if($price->sub_unit_price !== null)
                                          <div>{{ $unit->sub_unit }} = {{ $price->sub_unit_price }} Ar</div>
                                      @endif
                                  @endforeach
                                  
                                  @if (!$loop->last)
                                      <hr> <!-- Séparateur entre les prix -->
                                  @endif
                              @endforeach
                          </td>
                            <td>
                                <button class="btn btn-warning btn-outline-warning">
                                    <i class="icofont icofont-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-outline-danger">
                                    <i class="icofont icofont-trash"></i>
                                </button>
                            </td>
                            
                            
                          </tr>
                          @endforeach--}}
                        </tbody>
                      </table>                                             
                    </div>
                  </div>
                  
                  </div>
                  <div class="tab-pane" id="messages1" role="tabpanel">
                    <p class="m-0">3. This is Photoshop's version of Lorem IpThis is Photoshop's version of Lorem Ipsum. Proin gravida nibh vel velit auctor aliquet. Aenean sollicitudin, lorem quis bibendum auctor, nisi elit consequat ipsum, nec sagittis sem nibh id elit. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean mas Cum sociis natoque penatibus et magnis dis.....</p>
                  </div>
                  <div class="tab-pane" id="settings1" role="tabpanel">
                    <p class="m-0">4.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
                  </div>
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
    function addSubUnit(event) {
      event.preventDefault();
      document.getElementById("formula-container").style.display = "block";
    
      const subUnitInput = document.createElement("input");
      subUnitInput.type = "text";
      subUnitInput.placeholder = "Entrez la sous-unité (ex. Paquet)";
      subUnitInput.classList.add("form-control");
      subUnitInput.name = "subUnit[]";  // Utiliser un tableau pour soumettre plusieurs sous-unités
      subUnitInput.id = "sub-unit-" + Date.now();
    
      const quantityInput = document.createElement("input");
      quantityInput.type = "number";
      quantityInput.placeholder = "Quantité par unité";
      quantityInput.classList.add("form-control");
      quantityInput.name = "conversionRate[]";  // Tableau pour les quantités
    
      const container = document.getElementById("sub-units");
      container.appendChild(subUnitInput);
      container.appendChild(quantityInput);
    
      subUnitInput.addEventListener("input", updateFormula);
      quantityInput.addEventListener("input", updateFormula);
      updateFormula();
    }
    
    function updateFormula() {
      const mainUnit = document.getElementById("main-unit").value;
      document.getElementById("main-unit-display").textContent = mainUnit;
    
      const subUnits = document.querySelectorAll("#sub-units input[type='text']");
      const quantities = document.querySelectorAll("#sub-units input[type='number']");
    
      let formulaText = "";
      subUnits.forEach((input, index) => {
        const unitName = input.value;
        const quantity = quantities[index].value;
        if (unitName && quantity) {
          formulaText += `${quantity} ${unitName} = `;
        }
      });
    
      document.getElementById("sub-unit-display").textContent = formulaText.slice(0, -3); // Retire le dernier '='
    
        // Mettre à jour le seuil d'alerte affiché avec la nouvelle unité
        updateAlertThreshold();
    }
    
    function updateAlertThreshold() {
      const thresholdValue = document.getElementById("alert-threshold").value;
      const mainUnit = document.getElementById("main-unit").value;
      const alertThresholdDisplay = document.getElementById("alert-threshold-display");
    
      // Mettre à jour le texte affiché pour le seuil d'alerte avec l'unité principale
      alertThresholdDisplay.textContent = thresholdValue ? `${thresholdValue} ${mainUnit}` : "";
    }
    
  </script>      
<script>
function searchProduit(query) {
    if (query.length < 2) return;

    fetch(`/admin/ingredients/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            let suggestions = document.getElementById('suggestions');
            suggestions.style.display = 'block';
            suggestions.innerHTML = '';

            data.forEach(ingredient => {
                // Créer un conteneur pour le groupe de formulaire
                let formGroup = document.createElement('div');
                formGroup.classList.add('form-group', 'row');

                // Créer un élément label pour chaque ingrédient
                let label = document.createElement('label');
                label.classList.add('col-sm-2', 'col-form-label');
                label.textContent = 'Unité';
                // Valeur de produit.id

                // Ajouter l'input hidden à l'option
              

                // Ajouter l'élément label au groupe de formulaire
                formGroup.appendChild(label);
                

                // Créer un conteneur pour le select avec la classe col-sm-10
                let selectContainer = document.createElement('div');
                selectContainer.classList.add('col-sm-10');

                // Créer un élément select pour l'unité principale et la sous-unité
                let unitSelect = document.createElement('select');
                unitSelect.classList.add('form-control'); // Classe Bootstrap pour le style
                unitSelect.name = `unit_ingredient_id`;

                // Ajouter une option par défaut
                let defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Sélectionnez une unité';
                unitSelect.appendChild(defaultOption);

                // Vérifier si l'ingrédient contient des sous-unités et les ajouter
                if (Array.isArray(ingredient.unit_ingredient) && ingredient.unit_ingredient.length > 0) {
                    ingredient.unit_ingredient.forEach(unit_ingredient => {
                        // Option pour l'unité principale
                        if (unit_ingredient.main_unit) {
                            let mainUnitOption = document.createElement('option');
                            mainUnitOption.value = unit_ingredient.id;
                            mainUnitOption.textContent = unit_ingredient.main_unit;
                            unitSelect.appendChild(mainUnitOption);
                        }
                        // Option pour la sous-unité
                        if (unit_ingredient.sub_unit) {
                            let subUnitOption = document.createElement('option');
                            subUnitOption.value = unit_ingredient.id;
                            subUnitOption.textContent = unit_ingredient.sub_unit;
                            unitSelect.appendChild(subUnitOption);
                        }
                    });
                }

                // Ajouter le select au conteneur
                selectContainer.appendChild(unitSelect);
                formGroup.appendChild(selectContainer);

                // Créer un champ input hidden pour stocker ingredient.id
                let ingredientIdInput = document.createElement('input');
                ingredientIdInput.type = 'hidden';
                ingredientIdInput.name = 'ingredient_id';
                ingredientIdInput.value = ingredient.id;

                // Ajouter l'input hidden au groupe de formulaire
                formGroup.appendChild(ingredientIdInput);

                // Ajouter un événement pour sélectionner le produit lors du clic
                formGroup.onclick = () => selectProduit(ingredient);

                // Ajouter le groupe de formulaire au conteneur de suggestions
                suggestions.appendChild(formGroup);
            });
        });
}
function selectProduit(ingredient) {
    // Logique pour gérer la sélection d'un ingrédient
    console.log("Produit sélectionné :", ingredient);
    // Ajoutez ici la logique pour traiter le produit sélectionné
}



</script>
<script>
  // Sélectionner les champs de quantité, prix unitaire et total
const quantityInput = document.getElementById('quantity');
const prixUnitaireInput = document.getElementById('prix_unitaire');
const totalInput = document.getElementById('total');

// Fonction pour calculer et afficher le total
function calculateTotal() {
    const quantity = parseFloat(quantityInput.value) || 0;
    const prixUnitaire = parseFloat(prixUnitaireInput.value) || 0;
    const total = quantity * prixUnitaire;
    
    // Mettre à jour le champ total avec le résultat
    totalInput.value = `${total.toFixed(2)}`
}

// Ajouter des écouteurs d'événements pour recalculer chaque fois qu'une entrée est modifiée
quantityInput.addEventListener('input', calculateTotal);
prixUnitaireInput.addEventListener('input', calculateTotal);

</script>
        
  @endsection
    
