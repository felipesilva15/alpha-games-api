<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'PEDIDO_ITEM';
    protected $fillable = ['PRODUTO_ID', 'PEDIDO_ID', 'ITEM_QTD', 'ITEM_PRECO'];
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Models\Product', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function order() {
        return $this->belongsTo('App\Models\Order', 'PEDIDO_ID', 'PEDIDO_ID');
    }
    
    protected function setKeysForSaveQuery($query) {
        $query->where('PEDIDO_ID', $this->getAttribute('PEDIDO_ID'))
              ->where('PRODUTO_ID', $this->getAttribute('PRODUTO_ID'));

        return $query;
    }
}
