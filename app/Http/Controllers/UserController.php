<?php

namespace App\Http\Controllers;

use App\Exceptions\MasterNotFoundHttpException;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return response()->json(User::all(), 200);
    }

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

    public function show($id) {
        $data = User::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException();
        }

        return response()->json($data, 200);
    }

    public function adresses() {
        return response()->json(Auth::user()->Adresses()->get(), 200);
    }

    public function cart() {
        $data = Auth::user()
                    ->cartItems()
                    ->with('product', 'product.category', 'product.images')
                    ->where('ITEM_QTD', '<>', '0')
                    ->get();

        return response()->json($data, 200);
    }
}
