<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Category",
 *      @OA\Property(property="CATEGORIA_ID", type="integer", example=1),
 *      @OA\Property(property="CATEGORIA_NOME", type="integer", example="Nome"),
 *      @OA\Property(property="CATEGORIA_DESC", type="integer", example="Descrição da categoria"),
 *      @OA\Property(property="CATEGORIA_ATIVO", type="integer", maximum=1, minimum=0)
 * )
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'CATEGORIA';
    protected $primaryKey = 'CATEGORIA_ID';
    protected $fillable = ['CATEGORIA_NOME', 'CATEGORIA_DESC', 'CATEGORIA_ATIVO'];
    public $timestamps = false;

    public static function rules(): Array {
        return [
            'CATEGORIA_NOME' => 'string|required',
            'CATEGORIA_DESC' => 'string',
            'CATEGORIA_ATIVO' => 'int'
        ];
    }

    public function products() {
        return $this->hasMany('App\Models\Product', 'CATEGORIA_ID', 'CATEGORIA_ID');
    }
}
