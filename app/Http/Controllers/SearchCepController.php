<?php

namespace App\Http\Controllers;

use App\Http\Clients\ViacepClient;

class SearchCepController extends Controller
{
    public function getAddressByCep(string $cep){
        $address = ViacepClient::getAddressByCep($cep);

        return response()->json($address->toArray(), 200);
    }
}
