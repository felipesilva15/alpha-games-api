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
}
