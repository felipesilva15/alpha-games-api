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

    /**
     * @OA\Get(
     *      path="/api/product",
     *      tags={"Product"},
     *      summary="List all products",
     *      @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Product name",
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="price",
     *         in="query",
     *         description="Max product price",
     *         @OA\Schema(type="number", format="float", maximum=999.99, minimum=0)
     *      ),
     *      @OA\Parameter(
     *         name="categories[]",
     *         in="query",
     *         description="Product categories IDs",
     *         style="form",
     *         explode=true,
     *         @OA\Schema(type="array", @OA\Items(type="integer"))
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Category list",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/ProductDTO")
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      )
     * )
     */
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

    /**
     * @OA\Get(
     *      path="/api/product/{id}",
     *      tags={"Product"},
     *      summary="List an product by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Product data",
     *          @OA\JsonContent(ref="#/components/schemas/ProductDTO")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      )
     * )
     */
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

    /**
     * @OA\Post(
     *      path="/api/product",
     *      tags={"Product"},
     *      summary="Registers an product",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new product",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response="201", 
     *          description="Registered product data",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request) {
        return parent::store($request);
    }

    /**
     * @OA\Put(
     *      path="/api/product/{id}",
     *      tags={"Product"},
     *      summary="Update an product",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for update product",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Updated product data",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="RRecord not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id) {
        return parent::update($request, $id);
    }

    /**
     * @OA\Delete(
     *      path="/api/product/{id}",
     *      tags={"Product"},
     *      summary="Deletes an product",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Return message",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Registro deletado com sucesso!")
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function destroy( $id) {
        return parent::destroy($id);
    }
}
