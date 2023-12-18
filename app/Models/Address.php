<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Address",
 *      @OA\Property(property="ENDERECO_ID", type="integer", example=1),
 *      @OA\Property(property="ENDERECO_NOME", type="string", example="Casa"),
 *      @OA\Property(property="ENDERECO_CEP", type="string", example="01001000"),
 *      @OA\Property(property="ENDERECO_LOGRADOURO", type="string", example="Praça da Sé"),
 *      @OA\Property(property="ENDERECO_NUMERO", type="string", example="2589"),
 *      @OA\Property(property="ENDERECO_COMPLEMENTO", type="string", example="1º Andar, Apto 4"),
 *      @OA\Property(property="ENDERECO_CIDADE", type="string", example="São Paulo"),
 *      @OA\Property(property="ENDERECO_ESTADO", type="string", example="SP"),
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1)
 * )
 */
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
        return $this->belongsTo('App\Models\User', 'USUARIO_ID');
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
