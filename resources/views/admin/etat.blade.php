@extends('layouts.admin')

@section('title')

Stock des ingredients
    
@endsection

@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="page-header card">
                                        
            <div class="pcoded-search">
                <span class="searchbar-toggle">  </span>
                <div class="pcoded-search-box ">
                    <input type="text" placeholder="Search">
                    <span class="search-icon"><i class="ti-search" aria-hidden="true"></i></span>
                </div>
            </div>
            <hr>
            <div class="row align-items-end">
                <div class="col-lg-10">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>Etat de caisse</h4>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">

                <button class="btn btn-success"><i class="ti-search"></i>Recherche</button>
                        
                    
            </div>
        </div>
    </div>
    <!-- Page-header end -->

    <div class="card-block">
    <div class="row text-uppercase text-center">
    <div class="col-md-4 waves-effect waves-light p-b-10">
    <div class="bg-primary p-10 "><i class="ti-money"></i> Solde <br>
        <span style="font-size: 30px">{{ number_format($solde, 2, '.', ' '); }} Ar</span></div>
    </div>
    <div class="col-md-4 waves-effect waves-light p-b-10">
    <div class="bg-success p-10"><i class="ti-import"></i> Entrée <br>
        <span style="font-size: 30px">{{ number_format($totalvente, 2, '.', ' '); }} Ar</span></div>
    </div>
    <div class="col-md-4 waves-effect waves-light p-b-10">
    <div class="bg-danger p-10"><i class="ti-export"></i> Sortie <br>
        <span style="font-size: 30px">{{ number_format($totalExpense, 2, '.', ' '); }} Ar</span></div>
    </div>
    </div>
    </div>
    
        <div class="page-body">
 <!-- Page-body start -->
 <div class="page-body">

    <!-- Inverse table card end -->
    <!-- Hover table card start -->
    <div class="card">
        <div class="card-header">
            <div class="card-header-right">    <ul class="list-unstyled card-option">        <li><i class="icofont icofont-simple-left "></i></li>        <li><i class="icofont icofont-maximize full-card"></i></li>        <li><i class="icofont icofont-minus minimize-card"></i></li>        <li><i class="icofont icofont-refresh reload-card"></i></li>        <li><i class="icofont icofont-error close-card"></i></li>    </ul></div>
        </div>
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>Jacob</td>
                            <td>Thornton</td>
                            <td>@fat</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>@twitter</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Hover table card end -->
  
</div>
        </div>


    </div>
</div>
@endsection
