<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
