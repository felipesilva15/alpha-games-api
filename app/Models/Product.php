<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "PRODUTO";
    protected $primaryKey = 'PRODUTO_ID';

    public function ProductImages() {
        return $this->hasMany('App\Models\ProductImage', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function Category() {
        return $this->belongsTo('App\Models\Category', 'CATEGORIA_ID', 'CATEGORIA_ID');
    }

    public function ProductStock() {
        return $this->hasOne('App\Models\ProductStock', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function OrderItems() {
        return $this->hasMany('App\Models\OrderItem', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    public function OrderedProductImages() {
        return $this->ProductImages->filter(function ($image) {
                                        return stristr($image->IMAGEM_URL, 'http');
                                    })
                                   ->sortBy('IMAGEM_ORDEM')->values()->all();
    }

    public function FormattedDiscountPrice(): string {
        if(isset($this->ProductStock->PRODUTO_QTD) && $this->ProductStock->PRODUTO_QTD != 0 && $this->PRODUTO_ATIVO == 1){
            return 'R$ ' . number_format($this->PRODUTO_PRECO - $this->PRODUTO_DESCONTO, 2, ',', '');
        }

        return 'R$ --,--';
    }

    public function FormattedPrice(): string {
        if(isset($this->ProductStock->PRODUTO_QTD) && $this->ProductStock->PRODUTO_QTD != 0 && $this->PRODUTO_ATIVO == 1){
            return 'R$ ' . number_format($this->PRODUTO_PRECO, 2, ',', '');
        }

        return 'R$ --,--';
    }

    public function DiscountPercentage() {
        return round($this->PRODUTO_DESCONTO / ($this->PRODUTO_PRECO / 100), 0);
    }

    public function DefaultProductImage() {
        return asset('images/produto-sem-foto.jpg');
    }

    public static function PerPageOptions() {
        return [24, 32, 48];
    }

    public static function SortOptions() {
        return [
            1 => 'Menor preço',
            2 => 'Maior preço',
            3 => 'Nome de A-Z',
            4 => 'Nome de Z-A',
            5 => 'Categoria',
            6 => 'Mais vendidos',
            7 => 'Melhores descontos'
        ];
    }
}
