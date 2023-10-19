<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(){
        // Conditions / Where
        $conditions = [
            ['PRODUTO_ATIVO', '1']
        ];

        // Product name
        if(request('search')){
            array_push($conditions, ['PRODUTO_NOME', 'like', '%'.request('search').'%']);
        }

        // Price
        if(request('price')){
            array_push($conditions, ['PRODUTO_PRECO', '<=', request('price')]);
        }

        if(request('categories')){
            $categories = Category::whereIn('CATEGORIA_ID', request('categories'))->get();
        }

        // if($categories){
        //     $products = Product::where($conditions)
        //                         ->addSelect(['CATEGORIA_NOME' => Category::select('CATEGORIA_NOME')
        //                             ->whereColumn('CATEGORIA.CATEGORIA_ID', 'PRODUTO.CATEGORIA_ID')
        //                             ->orderByDesc('CATEGORIA_NOME')
        //                             ->limit(1)
        //                         ])
        //                         ->whereIn('CATEGORIA_ID', request('categories'))
        //                         ->withSum('OrderItems', 'item_qtd')
        //                         ->withSum('ProductStock', 'produto_qtd')
        //                         ->orderByRaw('case when `product_stock_sum_produto_qtd` > 0 then 1 else 0 end DESC')
        //                         ->orderByRaw($sortOption)
        //                         ->paginate($per_page);
        // } else{
        //     $products = Product::where($conditions)
        //                         ->addSelect(['CATEGORIA_NOME' => Category::select('CATEGORIA_NOME')
        //                             ->whereColumn('CATEGORIA.CATEGORIA_ID', 'PRODUTO.CATEGORIA_ID')
        //                             ->orderByDesc('CATEGORIA_NOME')
        //                             ->limit(1)
        //                         ])
        //                         ->withSum('OrderItems', 'item_qtd')
        //                         ->withSum('ProductStock', 'produto_qtd')
        //                         ->orderByRaw('case when `product_stock_sum_produto_qtd` > 0 then 1 else 0 end DESC')
        //                         ->orderByRaw($sortOption)
        //                         ->paginate($per_page);
        // }

        $data = Product::where($conditions)
                        ->with("category")
                        ->with('images')
                        ->withSum('stock as PRODUTO_QTD', 'produto_qtd')
                        ->get();

        return response()->json($data, 200);
    }

    public function show(int $id){
        $data = Product::with("category")
                        ->with('images')
                        ->withSum('stock as PRODUTO_QTD', 'produto_qtd') // Quantida
                        ->find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException();
        }

        return response()->json($data, 200);
    }
}
