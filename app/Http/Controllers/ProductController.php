<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(Product $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function index(){
        $builder = Product::query();

        // Only active
        $builder->where('PRODUTO_ATIVO', '1');

        // Product name
        if(request('search')){
            $builder->where('PRODUTO_NOME', 'like', '%'.request('search').'%');
        }

        // Price
        if(request('price')){
            $builder->where('PRODUTO_PRECO', '<=', request('price'));
        }

        // Categories
        if(request('categories')){
            $builder->whereIn('CATEGORIA_ID', request('categories'));
        }

        $data = $builder->with("category")
                        ->with('images')
                        ->withSum('stock as PRODUTO_QTD', 'produto_qtd')
                        ->get();

        return response()->json($data, 200);
    }

    public function show($id){
        $data = Product::with("category")
                        ->with('images')
                        ->withSum('stock as PRODUTO_QTD', 'produto_qtd')
                        ->find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException();
        }

        return response()->json($data, 200);
    }
}
