<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct(Address $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    /**
     * @OA\Get(
     *      path="/api/address",
     *      tags={"Address"},
     *      summary="List all adresses",
     *      @OA\Parameter(
     *          name="ENDERECO_NOME",
     *          in="query",
     *          description="Address name",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_CEP",
     *          in="query",
     *          description="Address CEP",
     *          @OA\Schema(type="string", maxLength=8)
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_LOGRADOURO",
     *          in="query",
     *          description="Address street",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_NUMERO",
     *          in="query",
     *          description="Address number",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_COMPLEMENTO",
     *          in="query",
     *          description="Address complement",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_CIDADE",
     *          in="query",
     *          description="Address city",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="ENDERECO_ESTADO",
     *          in="query",
     *          description="Address state",
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="USUARIO_ID",
     *          in="query",
     *          description="User ID",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Address list",
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
    public function index() {
        return parent::index();
    }

    /**
     * @OA\Get(
     *      path="/api/address/{id}",
     *      tags={"Address"},
     *      summary="List an address by ID",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Address ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Address data",
     *          @OA\JsonContent(ref="#/components/schemas/Address")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function show($id) {
        return parent::show($id);
    }

    /**
     * @OA\Post(
     *      path="/api/address",
     *      tags={"Address"},
     *      summary="Registers an address",
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for creating a new address",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *      ),
     *      @OA\Response(
     *          response="201", 
     *          description="Registered address data",
     *          @OA\JsonContent(ref="#/components/schemas/Address")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function store(Request $request) {
        $request->validate(Address::rules());

        $data = $request->all();
        $data['USUARIO_ID'] = Auth::user()->USUARIO_ID;

        $data = Address::create($data);

        return response()->json($data, 201);
    } 

    /**
     * @OA\Put(
     *      path="/api/address/{id}",
     *      tags={"Address"},
     *      summary="Update an address",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Address ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         description="Data for update address",
     *         @OA\JsonContent(ref="#/components/schemas/Address")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Updated address data",
     *          @OA\JsonContent(ref="#/components/schemas/Address")
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="RRecord not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function update(Request $request, $id) {
        $address = Address::find($id);

        if (!$address) {
            throw new MasterNotFoundHttpException;
        }

        $request->validate(Address::rules());

        $data = $request->all();
        $data['USUARIO_ID'] = Auth::user()->USUARIO_ID;

        $address->update($data);

        return response()->json($address, 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/address/{id}",
     *      tags={"Address"},
     *      summary="Deletes an address",
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Address ID",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response="200", 
     *          description="Return message",
     *          @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Registro deletado com sucesso!")
     *         )
     *      ),
     *      @OA\Response(
     *          response="401", 
     *          description="Unauthorized",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      @OA\Response(
     *          response="404", 
     *          description="Record not found",
     *          @OA\JsonContent(ref="#/components/schemas/ApiError")
     *      ),
     *      security={{"bearerAuth":{}}}
     * )
     */
    public function destroy($id) {
        return parent::destroy($id);
    }
}
