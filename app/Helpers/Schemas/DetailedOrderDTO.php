<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="DetailedOrderDTO",
 *      @OA\Property(property="PEDIDO_ID", type="integer", example=1),
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1),
 *      @OA\Property(property="STATUS_ID", type="integer", example=2),
 *      @OA\Property(property="PEDIDO_DATA", type="string", format="date-time", example="2023-11-27T03:00:00.000000Z"),
 *      @OA\Property(property="ENDERECO_ID", type="integer", example=1),
 *      @OA\Property(property="status", ref="#/components/schemas/OrderStatus"),
 *      @OA\Property(property="address", ref="#/components/schemas/Address"),
 *      @OA\Property(
 *          property="items", 
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/OrderItemDTO")
 *      )
 * )
 */
class DetailedOrderDTO {
}