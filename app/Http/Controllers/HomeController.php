<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $productsBestSellings = Product::where('PRODUTO_ATIVO', '1')
                                        ->withSum('OrderItems', 'item_qtd')
                                        ->withSum('ProductStock', 'produto_qtd')
                                        ->orderByRaw('case when `product_stock_sum_produto_qtd` > 0 then 1 else 0 end DESC')
                                        ->orderByDesc('order_items_sum_item_qtd')
                                        ->take(8)
                                        ->get();

        $productsBestDiscounts = Product::where('PRODUTO_ATIVO', '1')
                                        ->withSum('ProductStock', 'produto_qtd')
                                        ->orderByRaw('case when `product_stock_sum_produto_qtd` > 0 then 1 else 0 end DESC')
                                        ->orderByRaw('PRODUTO_DESCONTO / (PRODUTO_PRECO / 100) DESC')
                                        ->take(8)
                                        ->get();

        return view('home', [
            'productsBestDiscounts' => $productsBestDiscounts,
            'productsBestSellings' => $productsBestSellings
        ]);
    }
}


