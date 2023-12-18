<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/login",
     *      tags={"Authentication"},
     *      summary="Log in",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Login details",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_SENHA", type="string", example="123")
     *         )
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Token details",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="access_token", type="string", example="access_token_123"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Invalid credentials",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Credenciais inválidas.")
     *         )
     *     )
     * )
     */
    public function login(Request $request) {
        $credentials = [
            'USUARIO_EMAIL' => $request->USUARIO_EMAIL, // Campo personalizado para o email
            'password' =>$request->USUARIO_SENHA, // Campo padrão para a senha
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(["message" => "Credenciais inválidas."], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     tags={"Authentication"},
     *     summary="Logged in user data",
     *     @OA\Response(
     *          response="200", 
     *          description="User data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *             @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function me() {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout",
     *     @OA\Response(
     *          response="200", 
     *          description="Logout",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="integer", example="Logout efetuado com sucesso.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'Logout efetuado com sucesso.']);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh-token",
     *     tags={"Authentication"},
     *     summary="Refresh the access token",
     *     @OA\Response(
     *          response="200", 
     *          description="Token details",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="access_token", type="string", example="access_token_123"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}