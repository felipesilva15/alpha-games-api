<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="Product",
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_NOME", type="string", example="Nome"),
 *      @OA\Property(property="PRODUTO_DESC", type="string", example="Descrição do produto"),
 *      @OA\Property(property="PRODUTO_PRECO", type="number", format="float", maximum=999.99, minimum=0),
 *      @OA\Property(property="PRODUTO_DESCONTO", type="number", format="float", maximum=999.99, minimum=0),
 *      @OA\Property(property="PRODUTO_ATIVO", type="integer", maximum=1, minimum=0),
 *      @OA\Property(property="CATEGORIA_ID", type="integer")
 * )
 */
class Product extends Model
{
    use HasFactory;

    protected $table = "PRODUTO";
    protected $primaryKey = 'PRODUTO_ID';
    protected $fillable = ["PRODUTO_NOME", "PRODUTO_DESC", "PRODUTO_PRECO", "PRODUTO_DESCONTO", "PRODUTO_ATIVO", "CATEGORIA_ID"];
    public $timestamps = false;

    public function images() {
        return $this->hasMany('App\Models\ProductImage', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category', 'CATEGORIA_ID', 'CATEGORIA_ID');
    }

    public function stock() {
        return $this->hasOne('App\Models\ProductStock', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function orderItems() {
        return $this->hasMany('App\Models\OrderItem', 'PRODUTO_ID', 'PRODUTO_ID');
    }
}
