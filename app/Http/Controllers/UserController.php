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
     *              )
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
     *         )
     *     ),
     *     @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
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
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *     ),
     *     @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
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
     *             @OA\Items(ref="#/components/schemas/Address")
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
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
     *             @OA\Items(ref="#/components/schemas/OrderDTO")
     *          )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
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
