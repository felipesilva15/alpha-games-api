<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'PEDIDO';
    protected $primaryKey = 'PEDIDO_ID';
    protected $fillable = ['USUARIO_ID', 'STATUS_ID', 'PEDIDO_DATA'];
    public $timestamps = false;
    protected $casts = [
        'PEDIDO_DATA' => 'date'
    ];
    

    public function User() {
        return $this->belongsTo('App\Models\User', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function OrderStatus() {
        return $this->belongsTo('App\Models\OrderStatus', 'STATUS_ID', 'STATUS_ID');
    }

    public function OrderItems() {
        return $this->hasMany('App\Models\OrderItem', 'PEDIDO_ID', 'PEDIDO_ID');
    }

    public function OrderNumber() {
        return '#'.str_pad($this->PEDIDO_ID, 6, '0', STR_PAD_LEFT);
    }

    public function Date() {
        return date('d/m/Y', strtotime($this->PEDIDO_DATA));
    }

    public function OrderQtyItems() {
        return number_format($this->OrderItems->sum('ITEM_QTD'), 0, '', '.');
    }

    public function OrderTotal() {
        return number_format($this->OrderItems->sum(function ($item) {
            return $item->ITEM_QTD * $item->ITEM_PRECO;
        }), 2, ',', '.');
    }
}
