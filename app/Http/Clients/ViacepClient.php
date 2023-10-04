<?php

namespace App\Http\Clients;

use Illuminate\Support\Facades\Http;

class ViacepClient
{
    public function __construct() { }

    public static function getAddressByCep(string $cep) {
        $response = Http::retry(3, 100)->get("https://viacep.com.br/ws/{$cep}/json");

        return $response;
    }
}