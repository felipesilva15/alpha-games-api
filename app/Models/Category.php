<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'CATEGORIA';
    protected $primaryKey = 'CATEGORIA_ID';
    protected $fillable = ['CATEGORIA_NOME', 'CATEGORIA_DESC', 'CATEGORIA_ATIVO'];
    public $timestamps = false;

    public static function rules(): Array {
        return [
            'CATEGORIA_NOME' => 'string|required',
            'CATEGORIA_DESC' => 'string',
            'CATEGORIA_ATIVO' => 'int'
        ];
    }

    public function products() {
        return $this->hasMany('App\Models\Product', 'CATEGORIA_ID', 'CATEGORIA_ID');
    }
}
