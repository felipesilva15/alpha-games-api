<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @OA\Get(
     *      path="/api/user",
     *      tags={"User"},
     *      summary="List all users",
     *      @OA\Parameter(
     *         name="USUARIO_NOME",
     *         in="query",
     *         description="User name",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="USUARIO_EMAIL",
     *         in="query",
     *         description="User e-mail",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="USUARIO_CPF",
     *         in="query",
     *         description="User CPF",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="User list",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *                  @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *                  @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *                  @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *         )
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user"),
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
     * @OA\Post(
     *      path="/api/user",
     *      tags={"User"},
     *      summary="Registers an user",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_SENHA", type="string", example="123"),
     *             @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *         )
     *     ),
     *     @OA\Response(
     *          response="201", 
     *          description="Registered user data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *             @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     )
     * )
     */
    public function store(Request $request) {
        $request->validate(User::rules());

        $data = User::create([
            'USUARIO_NOME' => $request->USUARIO_NOME,
            'USUARIO_EMAIL' => $request->USUARIO_EMAIL,
            'USUARIO_SENHA' => Hash::make($request->USUARIO_SENHA),
            'USUARIO_CPF' => $request->USUARIO_CPF,
        ]);

        return response()->json($data, 201);
    }

    /**
     * @OA\Put(
     *      path="/api/user",
     *      tags={"User"},
     *      summary="Update an user",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for update user",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_SENHA", type="string", example="123"),
     *             @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *         )
     *     ),
     *     @OA\Response(
     *          response="200", 
     *          description="Updated user data",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *             @OA\Property(property="USUARIO_NOME", type="string", example="Username"),
     *             @OA\Property(property="USUARIO_EMAIL", type="string", example="example@example.com"),
     *             @OA\Property(property="USUARIO_CPF", type="string", example="12685963501")
     *             
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id) {
        $request->validate(User::rulesUpdate());

        $user = Auth::user();

        $data = $request->all();
        $data['USUARIO_SENHA'] = Hash::make($data['USUARIO_SENHA']);

        $user->update($data);

        return response()->json($data, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/user/{id}",
     *      tags={"User"},
     *      summary="Get a user by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
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
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user/1"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user/1"),
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
     * @OA\Get(
     *      path="/api/user/adresses",
     *      tags={"User"},
     *      summary="List all user adresses",
     *      @OA\Response(
     *          response="200", 
     *          description="User adresses list",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="ENDERECO_ID", type="integer", example=1),
     *                  @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *                  @OA\Property(property="ENDERECO_NOME", type="string", example="Casa"),
     *                  @OA\Property(property="ENDERECO_LOGRADOURO", type="string", example="Praça da Sé"),
     *                  @OA\Property(property="ENDERECO_NUMERO", type="string", example="2589"),
     *                  @OA\Property(property="ENDERECO_COMPLEMENTO", type="string", example="1º Andar, Apto 4"),
     *                  @OA\Property(property="ENDERECO_CEP", type="string", example="01001000"),
     *                  @OA\Property(property="ENDERECO_CIDADE", type="string", example="São Paulo"),
     *                  @OA\Property(property="USUARIO_EENDERECO_ESTADOMAIL", type="string", example="SP"),
     *         )
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user/adresses"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function adresses() {
        return response()->json(Auth::user()->adresses()->get(), 200);
    }

    public function cart() {
        $data = Auth::user()
                    ->cartItems()
                    ->with('product', 'product.category', 'product.images')
                    ->where('ITEM_QTD', '<>', '0')
                    ->get();

        return response()->json($data, 200);
    }

    /**
     * @OA\Get(
     *      path="/api/user/orders",
     *      tags={"User"},
     *      summary="List all user orders",
     *      @OA\Response(
     *          response="200", 
     *          description="User orders list",
     *          @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="PEDIDO_ID", type="integer", example=1),
     *                  @OA\Property(property="USUARIO_ID", type="integer", example=1),
     *                  @OA\Property(property="ENDERECO_ID", type="integer", example=1),
     *                  @OA\Property(property="STATUS_ID", type="integer", example=1),
     *                  @OA\Property(property="PEDIDO_DATA", type="string", format="date-time", example="2023-11-27T03:00:00.000000Z"),
     *                  @OA\Property(
     *                      property="status", 
     *                      type="object", 
     *                      @OA\Property(property="STATUS_ID", type="integer", example=1)
     *                  ),
     *                  @OA\Property(property="ENDERECO_CEP", type="string", example="01001000"),
     *                  @OA\Property(property="ENDERECO_CIDADE", type="string", example="São Paulo"),
     *                  @OA\Property(property="USUARIO_EENDERECO_ESTADOMAIL", type="string", example="SP"),
     *         )
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="code", type="string", example="EXCPHAND001"),
     *              @OA\Property(property="endpoint", type="string", example="api/user/orders"),
     *              @OA\Property(property="message", type="string", example="Token de acesso inválido.")
     *         )
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function orders() {
        $data = Auth::user()
                    ->orders()
                    ->with('status')
                    ->get()
                    ->sortByDesc('PEDIDO_ID')
                    ->values()
                    ->all();

        return response()->json($data, 200);
    }
}
