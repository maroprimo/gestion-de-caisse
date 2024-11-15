@extends('layouts.admin')

@section('title')

Vente indirect
    
@endsection

@section('content')

<form action="{{ route('sales.store') }}" method="POST">
    @csrf
    <label for="product_id">Produit :</label>
    <select name="product_id" id="product_id" required>
        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->designation }}</option>
        @endforeach
    </select>

    <label for="product_id">Unités :</label>
    
        @foreach($units as $unit)
            <div>
                {{$unit->main_unit}} <br>
                {{$unit->sub_unit}}
            </div>
        @endforeach
    

    <label for="quantity">Quantité vendue :</label>
    <input type="number" name="quantity" required min="1">

        <!-- Sélection du type d'unité (main ou sub) -->
        <label for="unit_type">Type d'unité :</label>
        <select name="unit_type" id="unit_type" required>
            <option value="main">Unité Principale</option>
            <option value="sub">Sous-unité</option>
        </select>

    <button type="submit">Enregistrer la vente</button>
</form>

    
@endsection