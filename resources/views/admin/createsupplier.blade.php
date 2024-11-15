@extends('layouts.admin')

@section('title')

Ajouter ingredient
    
@endsection

@section('content')
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

                        <form action="{{ route('supplier.store') }}" method="POST">
                            @csrf
                            <label for="name">Nom :</label>
                            <input type="text" name="name" required>
                        
                            <label for="unit_id">Contact :</label>
                            <input type="text" name="contact" required>
                        
                            <label for="supplier_id">Adresse :</label>
                            <input type="text" name="address" required>
                        
                            <button type="submit">Ajouter fournisseur</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
        

    </div>
</div>
    
@endsection

