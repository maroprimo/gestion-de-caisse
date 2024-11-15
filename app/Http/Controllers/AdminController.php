<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function dashboard(){
        return view('admin.dashboard');
    }


    public function listevente(){
        return view ('admin.liste-vente');
    }

    
    public function produitvente(){
        return view ('admin.produit-vente');
    }


    public function caisse(){
        return view('admin.caisse');
    }
}
