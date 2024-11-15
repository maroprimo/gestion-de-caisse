@extends('layouts.admin')

@section('title')

Liste des ventes
    
@endsection

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
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
                            <h4>Liste vente</h4>
                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                        <button class="btn btn-success"><i class="ti-files"></i>Exporter</button>
                        
                    
            </div>
        </div>
    </div>
    <!-- Page-header end -->
    
    <!-- Page-body start -->
    <div class="page-header card">
    <div class="page-body">
        <div class="card-block">
            <div class="row text-uppercase text-center">
                <div class="col-md-8 waves-effect waves-light p-b-10">
                    <div class="bg-success p-10"><i class="ti-import"></i> Entrée <br>
                        <span style="font-size: 30px">Vente</span></div>
                    </div>
            <div class="col-md-4 waves-effect waves-light p-b-10">
            <div class="bg-success p-10"><i class="ti-import"></i> Entrée <br>
                <span style="font-size: 30px">{{ number_format($totalvente, 2, '.', ' '); }} Ar</span></div>
            </div>
            </div>
        </div>
    </div>
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
                                <th>Designation</th>
                                <th>Quantité</th>
                                <th>PU</th>
                                <th>Sous total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            @foreach ($sale->saleItems as $saleItem)
                           
                                
                                 
                            <tr>
                                <th scope="row">
                                    @if($saleItem->product)
                                    {{ $saleItem->product->designation }}
                                @else
                                    Produit non disponible
                                @endif
                                </th>
                                <td>{{$saleItem->quantity}}</td>
                                <td>{{number_format($saleItem->price, 2, '.', ' ')}} Ar</td>
                                <td>{{number_format($saleItem->subtotal, 2, '.', ' ');}} Ar</td>
                            </tr>
                            @endforeach 
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Hover table card end -->
      
    </div>
    <!-- Page-body end -->
</div>
</div>

    
@endsection