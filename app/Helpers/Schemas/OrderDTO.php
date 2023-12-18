<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="OrderDTO",
 *      @OA\Property(property="PEDIDO_ID", type="integer", example=1),
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1),
 *      @OA\Property(property="STATUS_ID", type="integer", example=2),
 *      @OA\Property(property="PEDIDO_DATA", type="string", format="date-time", example="2023-11-27T03:00:00.000000Z"),
 *      @OA\Property(property="ENDERECO_ID", type="integer", example=1),
 *      @OA\Property(property="status", ref="#/components/schemas/OrderStatus")
 * )
 */
class OrderDTO {
}