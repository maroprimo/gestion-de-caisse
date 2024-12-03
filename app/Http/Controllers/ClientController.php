<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Http\JsonResponse;


class ClientController extends Controller
{
    //
    public function create(){

        $clients = Client::all();

        return view('admin.client', compact('clients'));

    }

    public function store(Request $request){
        //il faut valider les requettes venant de l'utilisateur
        $request->validate(['name'=>'required|string',
                            'firstname'=>'required|string',
                            'tel'=>'required|string',
                            'adresse'=>'required|string',
                            'info'=>'required|string',
    
                        ]);


        // Enregistrer une nouvelle instance dans model Client 
        $client = new Client();
        $client->name = $request->input('name');
        $client->firstname = $request->input('firstname');
        $client->tel = $request->input('tel');
        $client->adresse = $request->input('adresse');
        $client->info = $request->input('info');

        // il faut sauvegarder l'enregistrement

        $client->save();

        return redirect()->back()->with('success', 'client enregistrée avec succès');
        
    }



    // regrouper toutes les clients en json response
    public function index():JsonResponse
    {
        $clients = Client::all();

        // retourner les catégories sous forme jsonresponse

        return response()->json($clients);
    }
}
