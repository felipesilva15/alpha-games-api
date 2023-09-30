<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'CARRINHO_ITEM'; // nome da tabela no banco de dados
    protected $fillable = ['USUARIO_ID', 'PRODUTO_ID', 'ITEM_QTD'];
    public $timestamps = false;

    // Relacionamento com a tabela de produtos
    public function produto() {
        return $this->belongsTo('App\Models\Product', 'PRODUTO_ID', 'PRODUTO_ID');
    }

    // Relacionamento com a tabela de usuários
    public function usuario() {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function CartTotal() {
        return $this->sum('ITEM_QTD') * $this->produto->PRODUTO_PRECO;
    }

    public function QtyItems() {
        return $this->sum('ITEM_QTD');
    }

    public function FormattedItemTotal(): string {
        if(isset($this->produto->ProductStock->PRODUTO_QTD) && $this->produto->ProductStock->PRODUTO_QTD != 0 && $this->produto->PRODUTO_ATIVO == 1){
            return 'R$ ' . number_format(($this->produto->PRODUTO_PRECO - $this->produto->PRODUTO_DESCONTO) * $this->ITEM_QTD, 2, ',', '');
        }

        return 'R$ --,--';
    }

    protected function setKeysForSaveQuery($query) {
        $query->where('USUARIO_ID', $this->getAttribute('USUARIO_ID'))
              ->where('PRODUTO_ID', $this->getAttribute('PRODUTO_ID'));

        return $query;
    }
}
