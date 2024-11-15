@extends('layouts.admin')

@section('title')
    
@endsection

@section('content')

<h1>Historique des Ventes</h1>

<table>
    <thead>
        <tr>
            <th>Produit</th>
            <th>Quantité Vendue</th>
            <th>Prix Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>@foreach ($sales as $sale)
        @foreach ($sale->saleItems as $saleItem)
            <td>
                @if($saleItem->product)
                    {{ $saleItem->product->designation }}
                @else
                    Produit non disponible
                @endif
            </td>
        @endforeach
    @endforeach
    
    </tbody>
</table>

    
@endsection