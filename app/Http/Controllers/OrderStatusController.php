<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function __construct(OrderStatus $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @OA\Get(
     *      path="/api/order-status",
     *      tags={"Order status"},
     *      summary="List all order statuses",
     *      @OA\Parameter(
     *         name="STATUS_DESC",
     *         in="query",
     *         description="Order status description",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Order status list",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/OrderStatus")
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index() {
        return parent::index();
    }

    /**
     * @OA\Get(
     *      path="/api/order-status/{id}",
     *      tags={"Order status"},
     *      summary="List an order status by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order Status ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Order status data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Registro não encontrado.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function show($id) {
        return parent::show($id);
    }

    /**
     * @OA\Post(
     *      path="/api/order-status",
     *      tags={"Order status"},
     *      summary="Registers an order status",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new order status",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_DESC", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response="201", 
     *          description="Registered order status data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request) {
        return parent::store($request);
    }

    /**
     * @OA\Put(
     *      path="/api/order-status/{id}",
     *      tags={"Order status"},
     *      summary="Update an order status",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order status ID",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for update order status",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_DESC", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Updated order status data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="RRecord not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Registro não encontrado.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id) {
        return parent::update($request, $id);
    }

    /**
     * @OA\Delete(
     *      path="/api/order-status/{id}",
     *      tags={"Order status"},
     *      summary="Deletes an order status",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Order status ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Return message",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Registro deletado com sucesso!")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status/1"),
     *              @OA\Property(property="message", type="string", example="Registro não encontrado.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function destroy( $id) {
        return parent::destroy($id);
    }
}
