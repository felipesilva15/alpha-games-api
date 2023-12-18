<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="ProductImage",
 *      @OA\Property(property="IMAGEM_ID", type="integer", example=1),
 *      @OA\Property(property="IMAGEM_ORDEM", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="IMAGEM_URL", type="string", example="https://www.google.com.br/image")
 * )
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $table = "PRODUTO_IMAGEM";

    public function product() {
        return $this->belongsTo('App\Models\Product', 'PRODUTO_ID', 'PRODUTO_ID');
    }
}
