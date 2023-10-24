<?php

namespace App\Http\Clients;

use App\Exceptions\CustomValidationException;
use App\Exceptions\ExternalToolErrorException;
use App\Helpers\AddressDTO;
use Illuminate\Support\Facades\Http;

class ViacepClient
{
    public function __construct() { }

    /**
     * Realiza a consulta de um endereço através do CEP.
     * 
     * @param string $cep CEP do endereço
     * @return App\Helpers\AddressDTO DTO com os dados do endereço
     */
    public static function getAddressByCep(string $cep) {
        // Valida o CEP
        if (!$cep || strlen(str_replace('-', '', $cep)) < 8) {
            throw new CustomValidationException('CEP inválido!');
        }

        // Realiza a requisição
        $response = Http::retry(3, 100)->acceptJson()->get("https://viacep.com.br/ws/{$cep}/json");

        // Verifica se a requisição foi bem sucedida
        if (!$response->successful()) {
            throw new ExternalToolErrorException();
        }

        // Transforma o retorno em array
        $data = $response->json();

        if (!isset($data['cep']) || !$data['cep']) {
            throw new CustomValidationException('CEP não encontrado!');
        }

        // Prepara o objeto de retorno
        $address = new AddressDTO(
            isset($data['cep']) ? $data['cep'] : '',
            isset($data['logradouro']) ? $data['logradouro'] : '',
            isset($data['bairro']) ? $data['bairro'] : '',
            isset($data['localidade']) ? $data['localidade'] : '',
            isset($data['uf']) ? $data['uf'] : '',
        );

        return $address;
    }
}