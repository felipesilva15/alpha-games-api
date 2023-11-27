<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
        public function show(Order $order){
        if($order->User->USUARIO_ID != Auth::user()->USUARIO_ID){
            throw new MasterNotFoundHttpException;
        }

        return response()->json($order, 200);
    }

    public function store(){
        $user = Auth::user();

        // Valida se existem itens no carrinho
        if(!$user->cart->sum('ITEM_QTD')){
            throw new CustomValidationException('Insira ao menos um item no carrinho para finalizar o pedido!');
        }

        // Valida os itens do pedido
        foreach ($user->cart as $item) {
            if($item->ITEM_QTD <= 0){
                continue;
            }

            if($item->product->PRODUTO_ATIVO == 0){
                throw new CustomValidationException('O produto {$item->produto->PRODUTO_NOME} está indisponível!');
            }
    
            if(!isset($item->product->stock->PRODUTO_QTD) || $item->ITEM_QTD > $item->product->stock->PRODUTO_QTD){
                throw new CustomValidationException('O produto {$item->produto->PRODUTO_NOME} não possui em estoque');
            }
        }

        // Cria o pedido
        $order = Order::create([
            'USUARIO_ID' => $user->USUARIO_ID,
            'STATUS_ID' => 1,
            'PEDIDO_DATA' => now()
        ]);

        // Realiza atualização dos itens e estoque
        foreach ($user->cart as $item) {
            if(!$item->ITEM_QTD){
                continue;
            }

            //Cria o item do pedido
            OrderItem::create([
                'PEDIDO_ID' => $order->PEDIDO_ID,
                'PRODUTO_ID' => $item->PRODUTO_ID,
                'ITEM_QTD' => $item->ITEM_QTD,
                'ITEM_PRECO' => ($item->product->PRODUTO_PRECO - $item->product->PRODUTO_DESCONTO)
            ]);

            // Atualiza a quantidade de estoque do produto
            if(isset($item->product->stock)){
                $item->product->stock->update([
                    'PRODUTO_QTD' => $item->product->stock->PRODUTO_QTD - $item->ITEM_QTD
                ]);
            }

            // Retira o item do carrinho
            $item->update([
                'ITEM_QTD' => 0
            ]);
        }

        return response()->json(['message' => 'Pedido registrado!'], 201);
    }
}