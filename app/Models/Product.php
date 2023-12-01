<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "PRODUTO";
    protected $primaryKey = 'PRODUTO_ID';

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
