<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="ProductStock",
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_QTD", type="integer", example=20)
 * )
 */
class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'PRODUTO_ESTOQUE';
    protected $fillable = ['PRODUTO_QTD'];
    public $timestamps = false;

    protected function setKeysForSaveQuery($query) {
        $query->where('PRODUTO_ID', $this->getAttribute('PRODUTO_ID'));

        return $query;
    }
}
