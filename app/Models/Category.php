<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'CATEGORIA';

    public function products() {
        return $this->hasMany('App\Models\Product', 'CATEGORIA_ID', 'CATEGORIA_ID');
    }

    public static function AvaiableCategories() {
        return Category::where('CATEGORIA_ATIVO', 1)->get();
    }

    public function AvaiableProducts(int $qtyToTake = 0) {
        if($qtyToTake) {
            return $this->products->where('PRODUTO_ATIVO', 1)->take($qtyToTake);
        } else {
            return $this->products->where('PRODUTO_ATIVO', 1);
        }
    } 
}
