@extends('layouts.admin')

@section('title')

Liste des clients
    
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
                <span>Ajout client</span>
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
                    <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Clients</a>
                  </li>
                </ul>
                <div class="tab-content tabs card-block">
                  <div class="tab-pane active" id="home1" role="tabpanel">
                    <div class="card-block">
                      <form action="{{route('admin.storeclient')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                placeholder="Nom du client" name="name" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Prenom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control"
                                placeholder="Prenom" name="firstname" required>
                            </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Tel</label>
                          <div class="col-sm-10">
                              <input type="number" class="form-control" id="alert-threshold" placeholder="Tel" name="tel" required>
                          </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Adresse</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control"
                            placeholder="Adresse exact" name="adresse" required>
                        </div>
                    </div>
                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Commentaire</label>
                          <div class="col-sm-10">
                            <textarea rows="5" name="info" cols="5" class="form-control" placeholder="info"></textarea>
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
                        <h5>Liste des clients</h5>
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
                                <th>Nom</th>
                                <th>Prenom</th>
                                <th>Tel</th>
                                <th>adresse</th>
                                <th>Commentaire</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach ($clients as $client)
                              <tr class="table-active">
                                
                                  
                                       
                                   
                                
                                <th scope="row">{{$client->firstname}}</th>
                                
                                
                                <td>{{$client->name}}</td>
                                  <td>{{$client->tel}}</td> <!-- Affiche la catégorie associée -->
                                
                                  <td>{{$client->adresse}}
                                </td>
                                
                                
                                <td>{{$client->info}}</td>
                                <td>
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
        </div>
      </div>
    </div>
  </div>
  @endsection

  @section('script')

        
  @endsection
    
