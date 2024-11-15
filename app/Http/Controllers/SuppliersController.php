<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;


class SuppliersController extends Controller
{
    //


    public function create(){

        return view('admin.createsupplier');
    }





    public function store(Request $request)
    {
        // validation des données
        $request->validate([
            'name' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
        ]);
        // Créer la catégorie principale
        $supplier = new Supplier();
        $supplier->name = $request->input('name');
        $supplier->contact = $request->input('contact');
        $supplier->address = $request->input('address');
        $supplier->save();
    
    
        return redirect()->back()->with('success', 'Fournisseur enregistrées avec succès.');
    }
    
    
}
