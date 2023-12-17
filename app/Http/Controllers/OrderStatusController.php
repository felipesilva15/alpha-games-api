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
     *      summary="Lista todos os status de pedidos",
     *      @OA\Parameter(
     *         name="STATUS_DESC",
     *         in="query",
     *         description="Descrição do status do pedido",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Lista de status de pedidos",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="STATUS_ID", type="integer", example=1),
     *                 @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Não autorizado",
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
     *      summary="Lista um status do pedido pelo ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do status do pedido",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Dados do status do pedido",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Não autorizado",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Registro não encontrado",
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
     *      summary="Registra um status de pedido",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Dados para criar um novo status de pedido",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_DESC", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response="201", 
     *          description="Dados do status do pedido registrado",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Não autorizado",
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
     *      summary="Altera um status do pedido",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do status do pedido",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\RequestBody(
     *         required=true,
     *         description="Dados para alterar o status do pedido",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_DESC", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Dados do status do pedido alterado",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="STATUS_ID", type="integer", example=1),
     *             @OA\Property(property="STATUS_DESC", type="string", example="Em andamento")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Não autorizado",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/order-status"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Registro não encontrado",
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
}
