<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="CartItem",
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="ITEM_QTD", type="integer", example=2)
 * )
 */
class CartItem extends Model
{
    use HasFactory;

    protected $table = 'CARRINHO_ITEM';
    public $timestamps = false;

    protected $fillable = [
        'USUARIO_ID', 
        'PRODUTO_ID',
        'ITEM_QTD'
    ];

    public function product() {
        return $this->belongsTo('App\Models\Product', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'USUARIO_ID');
    }

    protected function setKeysForSaveQuery($query) {
        $query->where('USUARIO_ID', $this->getAttribute('USUARIO_ID'))
              ->where('PRODUTO_ID', $this->getAttribute('PRODUTO_ID'));

        return $query;
    }
}
