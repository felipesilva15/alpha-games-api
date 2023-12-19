<?php

namespace App\Helpers\Schemas;

/**
 * @OA\Schema(
 *      schema="AccessTokenDTO",
 *      @OA\Property(property="access_token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c"),
 *      @OA\Property(property="token_type", type="string", example="bearer"),
 *      @OA\Property(property="expires_in", type="integer", example=3600)
 * )
 */
class AccessTokenDTO {
}