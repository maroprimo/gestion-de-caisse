@extends('layouts.admin')

@section('title')

Catégories
    
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
                <span>Ajout produit categorie</span>
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
                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Produits</a>
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
                      <form method="POST" action="{{ route('admin.sauvercategory') }}" onsubmit="prepareFormData(event)">
                        @csrf
                    
                        <!-- Champ pour la catégorie principale -->
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label" for="main-category">Catégorie</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="main-category" placeholder="Nom de la catégorie principale" name="category_name">
                            </div>
                        </div>
                    
                        <!-- Conteneur pour les sous-catégories -->
                        <div id="sub-categories-container"></div>
                    
                        <!-- Bouton pour ajouter une sous-catégorie de premier niveau -->
                        <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="main-category">Sous catégorie</label>
                        <div class="col-sm-10">
                          <button type="button" class="form-control btn btn-secondary" onclick="addSubCategory()">+ Ajouter une Sous-catégorie</button>
                        </div>
                        </div>
                    
                        <!-- Champ caché pour stocker les données des sous-catégories en JSON -->
                        <input type="hidden" name="sub_categories" id="sub-categories-input">
                    
                        <!-- Bouton pour soumettre le formulaire -->
                        <div class="form-group row">
                            <button type="submit" class="btn btn-success"><i class="icofont icofont-save"></i>Enregistrer</button>
                        </div>
                    </form>
                    </div>
                    <div class="card">
                      <div class="card-header">
                        <h5>Liste catégories</h5>
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
                                <th>Catégories</th>
                                <th>Sous catégorie</th>
                                <th>Sous catégories</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr class="table-active">
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                                <td>
                                    <button class="btn btn-warning btn-outline-warning">
                                        <i class="icofont icofont-edit"></i>
                                    </button>
                                    <button class="btn btn-danger btn-outline-danger">
                                        <i class="icofont icofont-trash"></i>
                                    </button>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane" id="profile1" role="tabpanel">
                    <p class="m-0">2.Cras consequat in enim ut efficitur. Nulla posuere elit quis auctor interdum praesent sit amet nulla vel enim amet. Donec convallis tellus neque, et imperdiet felis amet.</p>
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
    let subCategories = [];

    // Fonction pour ajouter une sous-catégorie de niveau 1
    function addSubCategory(parentIndex = null) {
        const subCategoryName = prompt("Entrez le nom de la sous-catégorie:");
        if (!subCategoryName) return;

        const subCategory = { name: subCategoryName, sub_categories: [] };

        if (parentIndex === null) {
            // Ajouter une sous-catégorie de premier niveau
            subCategories.push(subCategory);
        } else {
            // Ajouter une sous-catégorie à une sous-catégorie existante
            subCategories[parentIndex].sub_categories.push(subCategory);
        }

        renderSubCategories();
    }

    // Fonction pour afficher les sous-catégories dans le formulaire
    function renderSubCategories() {
        const container = document.getElementById("sub-categories-container");
        container.innerHTML = ''; // Réinitialiser le conteneur

        subCategories.forEach((subCategory, index) => {
            const subCategoryDiv = document.createElement("div");
            subCategoryDiv.classList.add("sub-category");
            subCategoryDiv.innerHTML = `
                <label class="form-control">${subCategory.name}</label> 
                <button class="form-control btn-warning btn-outline-warning" type="button" onclick="addSubCategory(${index})">+ Ajouter une sous-catégorie de : <strong>${subCategory.name}</strong> </button>
            `;

            // Afficher les sous-catégories imbriquées
            if (subCategory.sub_categories.length > 0) {
                const nestedList = document.createElement("ul");
                subCategory.sub_categories.forEach(nestedSubCategory => {
                    const listItem = document.createElement("li");
                    listItem.classList.add("label-success");
                    listItem.textContent = nestedSubCategory.name;
                    nestedList.appendChild(listItem);
                });
                subCategoryDiv.appendChild(nestedList);
            }

            container.appendChild(subCategoryDiv);
        });

        // Mettre à jour le champ caché avec la structure JSON
        updateSubCategoriesInput();
    }

    // Fonction pour mettre à jour le champ caché avec les données JSON des sous-catégories
    function updateSubCategoriesInput() {
        document.getElementById('sub-categories-input').value = JSON.stringify(subCategories);
    }

    // Préparer les données du formulaire avant de soumettre
    function prepareFormData(event) {
        updateSubCategoriesInput();
    }
</script>  
  @endsection

  <style>
    .sub-category {
        margin-left: 20px;
        margin-top: 10px;
        padding-bottom: 20px;
    }
</style>

     

    
