<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="OrderItemDTO",
 *      @OA\Property(property="PEDIDO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="ITEM_PRECO", type="number", format="float", maximum=999.99, minimum=0),
 *      @OA\Property(property="ITEM_QTD", type="integer", example=20),
 *      @OA\Property(property="product", ref="#/components/schemas/ProductDTO")
 * )
 */
class OrderItemDTO {
}