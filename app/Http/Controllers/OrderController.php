<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomValidationException;
use App\Exceptions\MasterForbiddenHttpException;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(int $order){
        $data = Order::with('items', 'items.product', 'items.product.category', 'items.product.images')
                        ->find($order);

        if (!$data) {
            throw new MasterNotFoundHttpException();
        }

        if($data->USUARIO_ID != Auth::user()->USUARIO_ID){
            throw new MasterForbiddenHttpException();
        }

        return response()->json($data, 200);
    }

    public function store(Request $request){
        $request->validate(Order::rules());

        $order = $request->all();
        $address = Address::find($order['ENDERECO_ID']);
        $user = Auth::user();

        // Valida se existem itens no carrinho
        if (!$user->cartItems->sum('ITEM_QTD')) {
            throw new CustomValidationException('Insira ao menos um item no carrinho para finalizar o pedido!');
        }

        // Valida se o endereço informado pertence ao usuário
        if (!$address) {
            throw new MasterNotFoundHttpException('Endereço não encontrado!');
        }

        if ($address->USUARIO_ID != Auth::user()->USUARIO_ID) {
            throw new MasterForbiddenHttpException();
        }

        // Valida os itens do pedido
        foreach ($user->cartItems as $item) {
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

        if (!isset($order['PEDIDO_DATA']) || !$order['PEDIDO_DATA']) {
            $order['PEDIDO_DATA'] = now();
        }

        if (!isset($order['STATUS_ID']) || !$order['STATUS_ID']) {
            $order['STATUS_ID'] = 1;
        }

        $order['USUARIO_ID'] = $user->USUARIO_ID;

        // Cria o pedido
        $order = Order::create($order);

        // Realiza atualização dos itens e estoque
        foreach ($user->cartItems as $item) {
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