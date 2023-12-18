<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="CartItemDTO",
 *      @OA\Property(property="USUARIO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="ITEM_QTD", type="integer", example=2),
 *      @OA\Property(property="product", ref="#/components/schemas/ProductDTO")
 * )
 */
class CartItemDTO {
}