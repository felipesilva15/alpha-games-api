<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        // Buscar os itens do carrinho na tabela CARRINHO_ITEM
        $cartItems = CartItem::where([
            ['USUARIO_ID', auth()->id()],
            ['ITEM_QTD', '<>', 0]
        ])->get();

        $totalizer = [
            'TOTAL_PRODUTO' => 0,
            'TOTAL_DESCONTO' => 0,
            'TOTAL' => 0 
        ];

        foreach ($cartItems as $item){
            $totalizer['TOTAL_PRODUTO'] += ($item->produto->PRODUTO_PRECO) * $item->ITEM_QTD;
            $totalizer['TOTAL_DESCONTO'] += ($item->produto->PRODUTO_DESCONTO) * $item->ITEM_QTD;
            $totalizer['TOTAL'] += ($item->produto->PRODUTO_PRECO - $item->produto->PRODUTO_DESCONTO) * $item->ITEM_QTD;
        }

        $validator =  [
            'hasError' => false,
            'cartItems' => [],
            'user' => []
        ];

        if(!Auth::user()->activeAddress()) {
            $validator['user']['address'] = ['icon' => 'home', 'description' => 'Endereço não cadastrado!'];
        }

        foreach ($cartItems as $item) {
            if($item->produto->PRODUTO_ATIVO != 1) {
                array_push($validator['cartItems'], ['product_id' => $item->PRODUTO_ID, 'icon' => 'production_quantity_limits', 'description' => 'Produto indisponível!']);
            }

            if(!isset($item->produto->ProductStock->PRODUTO_QTD) || $item->produto->ProductStock->PRODUTO_QTD <= 0 || $item->ITEM_QTD > $item->produto->ProductStock->PRODUTO_QTD) {
                array_push($validator['cartItems'], ['product_id' => $item->PRODUTO_ID, 'icon' => 'production_quantity_limits', 'description' => 'Quantidade em estoque indisponível!']);
            }
        }

        $validator['hasError'] = count($validator['user']) || count($validator['cartItems']) ? true : false;
        $validator = json_decode(json_encode($validator), false);

        // Retornar a view do carrinho de compras com os itens encontrados
        return view('cart.cart', [
            'cartItems' => $cartItems,
            'totalizer' => $totalizer,
            'validator' => $validator
        ]);
    }

    public function store(Product $product, Request $request){
        $item = CartItem::where([
            ['USUARIO_ID', Auth::user()->USUARIO_ID],
            ['PRODUTO_ID', $product->PRODUTO_ID]
        ])->first();

        $qtyItem = $request->qtyItem ? $request->qtyItem : 1;
        $message = '';
        
        if($product->PRODUTO_ATIVO == 0){
            return back()->with('error', 'Produto indisponível');
        }

        if(!isset($product->ProductStock->PRODUTO_QTD) || $qtyItem > $product->ProductStock->PRODUTO_QTD){
            return back()->with('error', 'Quantidade em estoque indisponível');
        }

        if($item){
            if(!$item->ITEM_QTD){
                $message = 'Item adicionado ao carrinho';
            } else{
                $message = 'Quantidade do item atualizada';
            }

            $item->update([
                'ITEM_QTD' => $qtyItem
            ]);
        } else{
            CartItem::create([
                'USUARIO_ID' => Auth::user()->USUARIO_ID,
                'PRODUTO_ID' => $product->PRODUTO_ID,
                'ITEM_QTD' => $qtyItem
            ]);

            $message = 'Item adicionado ao carrinho';
        }

        return redirect(route('cart'))->with('message', $message);
    }

    public function destroy(Product $product){
        $cartItem = CartItem::where([
            ['PRODUTO_ID', $product->PRODUTO_ID],
            ['USUARIO_ID', Auth::user()->USUARIO_ID]
        ]);

        $cartItem->update([
            'ITEM_QTD' => 0
        ]);

        return redirect(route('cart'))->with('error', 'Item removido do carrinho');
    }
}
