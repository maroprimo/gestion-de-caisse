@extends('layouts.admin')

@section('title')

Stock des ingredients
    
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="card">
                    <div class="col-lg-12 col-xl-12">
                        <div class="card-block">
                            <form action="" method="POST" enctype="multipart/form-data">
                              @csrf
                              <div class="form-group row">
                                  <label class="col-sm-2 col-form-label">Raison</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control"
                                       id='designation' name="designation">
                                  </div>
                              </div>
                              
                                
                            
                              <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Montant</label>
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
                              <label class="col-sm-2 col-form-label">PDV</label>
                                  <div class="col-sm-10">
                                      <select name="supplier_id"  class="form-control">
                                        <option value="">Sélectionnez fournisseur</option>
                                        
                                        <option></option>   
                                       
                                      </select>
                                </div>
                            </div>
                              <div class="form-group row">
                                <button class="btn btn-success btn-outline-success">
                                  <i class="icofont icofont-save"></i>Valider
                                </button>
                              </div>
                            </form>
                          </div>
                        <div class="card-block">
                            <div class="row text-uppercase text-center">
                            <div class="col-md-8 waves-effect waves-light p-b-10">
                              <h3>Gestion des Dépenses </h3>
                            </div>
                            <div class="col-md-4 waves-effect waves-light p-b-10">
                            <div class="bg-danger p-10"><i class="ti-export"></i> Sortie <br>
                                <span style="font-size: 30px">{{ number_format($totalExpense, 2, '.', ' '); }} Ar</span></div>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                              <h5>Liste des dépenses</h5>
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
                                      <th>Raison</th>
                                      <th>Designation</th>
                                      <th>Montant</th>
                                      <th>Date</th>
                                      <th>Vendeur</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    @foreach ($ingredients as $ingredient)
                                    <tr class="table-info">
                                      <th scope="row">Appro</th>                                     
                                      <td>{{$ingredient->designation}}</td>                                      
                                      <td>{{$ingredient->total_amount}}</td>
                                      <td>{{$ingredient->date}}</td>
                                      <td>@mdo</td>
                                      
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>


    <!-- Dépenses Journalières -->
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Date</th>
                <th>Dépense Journalière (€)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyExpenses as $expense)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                    <td>{{ number_format($expense->daily_total, 2, '.', ' '); }} Ar</td>
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
@endsection
