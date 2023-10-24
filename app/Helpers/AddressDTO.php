<?php

namespace App\Helpers;

class AddressDTO 
{
    private $cep;
    private $logradouro;
    private $bairro;
    private $cidade;
    private $uf;

    public function __construct($cep, $logradouro, $bairro, $cidade, $uf) 
    {
        $this->cep = $cep;
        $this->logradouro = $logradouro;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
        $this->uf = $uf;
    }

    public function getCep(): string {
        return (string) $this->cep;
    }

    public function getLogradouro(): string {
        return (string) $this->logradouro;
    }

    public function getBairro(): string {
        return (string) $this->bairro;
    }

    public function getCidade(): string {
        return (string) $this->cidade;
    }

    public function getUf(): string {
        return (string) $this->uf;
    }

    public function toArray(): array {
        return [
            "cep" => $this->getCep(),
            "logradouro" => $this->getLogradouro(),
            "bairro" => $this->getBairro(),
            "cidade" => $this->getCidade(),
            "uf" => $this->getUf(),
        ];
    }
}