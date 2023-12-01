<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
