<?php

namespace App\Http\Controllers;

use App\Http\Clients\ViacepClient;
use Illuminate\Routing\Controller as BaseController;

class SearchCepController extends BaseController
{
    public function getAddressByCep(string $cep){
        $address = ViacepClient::getAddressByCep($cep);

        return response()->json($address->toArray(), 200);
    }
}
