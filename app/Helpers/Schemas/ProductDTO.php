<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="ProductDTO",
 *      @OA\Property(property="PRODUTO_ID", type="integer", example=1),
 *      @OA\Property(property="PRODUTO_NOME", type="string", example="Nome"),
 *      @OA\Property(property="PRODUTO_DESC", type="string", example="Descrição do produto"),
 *      @OA\Property(property="PRODUTO_PRECO", type="number", format="float", maximum=999.99, minimum=0, example=10.00),
 *      @OA\Property(property="PRODUTO_DESCONTO", type="number", format="float", maximum=999.99, minimum=0, example=1.00),
 *      @OA\Property(property="PRODUTO_ATIVO", type="integer", maximum=1, minimum=0, example=1),
 *      @OA\Property(property="CATEGORIA_ID", type="integer", example="1"),
 *      @OA\Property(property="PRODUTO_QTD", type="string", example="8"),
 *      @OA\Property(property="category", ref="#/components/schemas/Category"),
 *      @OA\Property(
 *          property="images", 
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/ProductImage")
 *      )
 * )
 */
class ProductDTO {
}