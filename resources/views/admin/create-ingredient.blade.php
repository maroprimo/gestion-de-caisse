@extends('layouts.admin')

@section('title')

Ajout Ingredient
    
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
                <span>Ajout produit à vendre</span>
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
                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Ingredient</a>
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
                      <form action="{{ route('ingredients.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Type</label>
                        <div class="col-sm-10">
                            <input type="radio" id="contactChoice1" name="produit" value="0" onchange="toggleFields()" />
                            <label for="contactChoice1">Ingrédient</label>

                            <input type="radio" id="contactChoice2" name="produit" value="1" onchange="toggleFields()" />
                            <label for="contactChoice2">Produit</label>
                        </div>
                      </div>

                      <!-- Champ Désignation (par défaut caché) -->
                      <div class="form-group row" id="designationField" style="display: none;">
                          <label class="col-sm-2 col-form-label">Désignation</label>
                          <div class="col-sm-10">
                              <input type="text" class="form-control" placeholder="Nom du produit" name="designation">
                          </div>
                      </div>

                      <!-- Sélection Produit (par défaut caché) -->
                      <!-- Sélection Produit -->
                      <div class="form-group row" id="productField" style="display: none;">
                          <label class="col-sm-2 col-form-label">Produit</label>
                          <div class="col-sm-10">
                              <select name="product_id" id="productMerchandise" class="form-control">
                                  <option value="">-- Sélectionner un produit --</option>
                                  @foreach($products as $product)
                                      @if($product->type_produit == 1) 
                                          <option value="{{ $product->id }}" data-designation="{{ $product->designation }}">
                                              {{ $product->designation }}
                                          </option>
                                      @endif
                                  @endforeach
                              </select>
                          </div>
                      </div>

                      <!-- Champ caché pour la désignation -->
                      <input type="hidden" name="designation" id="designationInput">



                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label" for="main-unit">Unité Principale</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="main-unit" placeholder="Entrez l'unité principale (ex. Cartouche)" name="main_unit">
                            <button onclick="addSubUnit(event)">+ Ajouter sous-unité</button>
                            <div id="sub-units"></div>
                            <div class="formula" id="formula-container">
                              <div id="formula-output" class="form-control">
                                1 <span id="main-unit-display"></span> = 
                                <input type="hidden" id="quantity" class="number-input" min="1" oninput="updateFormula()">
                                <span id="sub-unit-display"></span>
                              </div>
                            </div>
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
                          <label class="col-sm-2 col-form-label">Photo</label>
                          <div class="col-sm-10">
                            <input type="file" name="photo" class="form-control">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Descriptif</label>
                          <div class="col-sm-10">
                            <textarea rows="5" name="description" cols="5" class="form-control" placeholder="Description produit"></textarea>
                          </div>
                        </div>
                        <div class="form-group row">
                          <button class="btn btn-success btn-outline-success">
                            <i class="icofont icofont-save"></i>Sauver</button>
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

    fetch(`/admin/produits/search?query=${query}`)
        .then(response => response.json())
        .then(data => {
            let suggestions = document.getElementById('suggestions');
            suggestions.style.display = 'block';
            suggestions.innerHTML = '';

            data.forEach(produit => {
                // Créer un élément div pour chaque produit
                let option = document.createElement('div');
                
                // Afficher le nom du produit
                option.innerHTML = produit.designation;

              // Créer un champ input hidden pour stocker produit.id
              let produitIdInput = document.createElement('input');
              produitIdInput.type = 'hidden';
              produitIdInput.name = 'produit_id'; // Nom correspondant à votre formulaire
              produitIdInput.value = produit.id; // Valeur de produit.id

              // Ajouter l'input hidden à l'option
              option.appendChild(produitIdInput);

                // Si le produit a des sous-unités, afficher les noms des sous-unités
                // vérifie si c'est un tableau est ne pas vide*/
                if (Array.isArray(produit.units) && produit.units.length > 0) {
                    // Parcourir chaque élément unit du tableau units
                    produit.units.forEach((unit, index) => {


                        // Vérifier et afficher l'input pour l'unité principale si elle est définie
                        if (unit.main_unit) {
                            let inputMainUnit = document.createElement('input');
                            inputMainUnit.type = 'number';
                            inputMainUnit.name = `main_unit_price`; // Nom dynamique pour l'unité principale
                            inputMainUnit.placeholder = `Prix pour ${unit.main_unit}`; // Texte d'indication
                            inputMainUnit.value = unit.price || ''; // Valeur initiale du prix

                            // Ajouter le nom de l'unité principale et le champ de saisie à l'option
                            option.innerHTML += ` - ${unit.main_unit} `;
                            option.appendChild(inputMainUnit); // Ajouter l'input après le nom de l'unité principale
                        }
                        // Vérifier et afficher l'input pour la sous-unité si elle est définie
                        if (unit.sub_unit) {
                            let inputSubUnit = document.createElement('input');
                            inputSubUnit.type = 'number';
                            inputSubUnit.name = `sous_unites[${index}][prix]`; // Nom dynamique pour chaque sous-unité
                            inputSubUnit.placeholder = `Prix pour ${unit.sub_unit}`; // Texte d'indication
                            inputSubUnit.value = unit.price || ''; // Valeur initiale du prix

                            // Ajouter le nom de la sous-unité et le champ de saisie à l'option
                            option.innerHTML += ` - ${unit.sub_unit} `;
                            option.appendChild(inputSubUnit); // Ajouter l'input après le nom de la sous-unité
                        }


                    });
                }


                // Ajout de l'événement click pour sélectionner le produit
                option.onclick = () => selectProduit(produit);
                suggestions.appendChild(option);
            });
        });
}

/*function selectProduit(produit) {
    console.log(produit); // Vérifiez ici que `units` contient bien les sous-unités
    document.getElementById('produit').value = produit.designation;
    document.getElementById('produit_id').value = produit.id;
    document.getElementById('suggestions').style.display = 'none';

    // Si le produit a des sous-unités, les afficher dynamiquement
    let sousUnitesContainer = document.getElementById('sous_unites_container');
    sousUnitesContainer.innerHTML = ''; // Vider le conteneur avant d'ajouter les sous-unités

    // Afficher les champs de prix pour l'unité principale
    let mainUnitPriceContainer = document.getElementById('main_unit_price_container');
    mainUnitPriceContainer.innerHTML = `
        <label>Prix pour l'unité principale (${produit.main_unit}) :</label>
        <input type="number" name="main_unit_price" placeholder="Prix pour ${produit.main_unit}">
    `;

    // Vérifiez que les sous-unités existent et sont un tableau
    if (Array.isArray(produit.units) && produit.units.length > 0) {
        produit.units.forEach((unit, index) => {
            let div = document.createElement('div');
            div.innerHTML = `
                <label>Prix pour ${unit.name} :</label>
                <input type="hidden" name="sous_unites[${index}][id]" value="${unit.id}">
                <input type="number" name="sous_unites[${index}][prix]" value="${unit.price || ''}">
            `;
            sousUnitesContainer.appendChild(div);
        });
    } else {
        console.log("Aucune sous-unité trouvée pour ce produit.");
    }
}*/

</script>
<script>
    function toggleFields() {
        let typeValue = document.querySelector('input[name="produit"]:checked').value;
        document.getElementById("designationField").style.display = typeValue == "0" ? "block" : "none";
        document.getElementById("productField").style.display = typeValue == "1" ? "block" : "none";
    }

    document.getElementById('productMerchandise').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var designation = selectedOption.getAttribute('data-designation');

    document.getElementById('designationInput').value = designation;
});

</script>      
  @endsection
    
