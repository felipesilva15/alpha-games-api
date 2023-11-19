<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'ENDERECO';
    protected $primaryKey = 'ENDERECO_ID';
    public $timestamps = false;

    protected $fillable = [
        'ENDERECO_CEP',
        'ENDERECO_NOME',
        'ENDERECO_LOGRADOURO',
        'ENDERECO_NUMERO',
        'ENDERECO_COMPLEMENTO',
        'ENDERECO_CIDADE',
        'ENDERECO_ESTADO',
        'USUARIO_ID',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    //Método para montar o endereço completo formatado
    public function FormattedAddress() {
        $formattedAddress = $this->ENDERECO_LOGRADOURO . ', ' . $this->ENDERECO_NUMERO;

        if ($this->ENDERECO_COMPLEMENTO) {
            $formattedAddress .= ' - ' . $this->ENDERECO_COMPLEMENTO;
        }

        $formattedAddress .= ' - ' . $this->ENDERECO_CIDADE . ', ' . $this->ENDERECO_ESTADO . ' - CEP ' . $this->ENDERECO_CEP;

        return $formattedAddress;
    }

    public static function rules(): array {
        return [
            'ENDERECO_CEP' => 'required|string|max:8',
            'ENDERECO_NOME' => 'required|string',
            'ENDERECO_LOGRADOURO' => 'required|string',
            'ENDERECO_NUMERO' => 'required|string',
            'ENDERECO_COMPLEMENTO' => 'nullable|string',
            'ENDERECO_CIDADE' => 'required|string',
            'ENDERECO_ESTADO' => 'required|string'
        ];
    } 
}
