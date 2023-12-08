<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller as BaseController;

class CartController extends BaseController
{
    public function store(Product $product, Request $request){
        $qtyItem = $request->ITEM_QTD ? $request->ITEM_QTD : 0;
        
        // Valida disponibilidade do produto
        if($product->PRODUTO_ATIVO == 0){
            throw new CustomValidationException("Produto indisponível!");
        }

        // Valida a quantidade em estoque 
        if(!isset($product->stock->PRODUTO_QTD) || $qtyItem > $product->stock->PRODUTO_QTD){
            throw new CustomValidationException("Quantidade em estoque indisponível!");
        }

        // Carrega o item do carrinho do usuário para o produto em questão
        $item = CartItem::where([
            ['USUARIO_ID', Auth::user()->USUARIO_ID],
            ['PRODUTO_ID', $product->PRODUTO_ID]
        ])->first();

        // Verifica se deve atualizar ou criar o item no carrinho
        if($item){
            $item->update([
                'ITEM_QTD' => $qtyItem
            ]);
        } else{
            CartItem::create([
                'USUARIO_ID' => Auth::user()->USUARIO_ID,
                'PRODUTO_ID' => $product->PRODUTO_ID,
                'ITEM_QTD' => $qtyItem
            ]);
        }

        return response()->json(['message' => 'Carrinho atualizado!'], 200);
    }

    public function destroy(Product $product){
        $cartItem = CartItem::where([
            ['PRODUTO_ID', $product->PRODUTO_ID],
            ['USUARIO_ID', Auth::user()->USUARIO_ID]
        ]);

        $cartItem->update([
            'ITEM_QTD' => 0
        ]);

        return response()->json(['message' => 'Item removido do carrinho.'], 200);
    }
}
