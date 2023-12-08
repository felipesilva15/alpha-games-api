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

    public function index() {
        $builder = Address::query();

        // User filter
        if(isset($this->request->USUARIO_ID) && $this->request->USUARIO_ID) {
            $builder->where('USUARIO_ID', $this->request->USUARIO_ID);
        }

        // CEP filter
        if(isset($this->request->ENDERECO_CEP) && $this->request->ENDERECO_CEP) {
            $builder->where('ENDERECO_CEP', 'like', '%'.$this->request->ENDERECO_CEP.'%');
        }

        // City filter
        if(isset($this->request->ENDERECO_CIDADE) && $this->request->ENDERECO_CIDADE) {
            $builder->where('ENDERECO_CIDADE', 'like', '%'.$this->request->ENDERECO_CIDADE.'%');
        }

        // State/UF filter
        if(isset($this->request->ENDERECO_ESTADO) && $this->request->ENDERECO_ESTADO) {
            $builder->where('ENDERECO_ESTADO', 'like', '%'.$this->request->ENDERECO_ESTADO.'%');
        }

        $data = $builder->get();

        return response()->json($data, 200);
    }

    public function show($id) {
        $data = Address::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        return response()->json($data, 200);
    }

    public function store(Request $request) {
        $request->validate(Address::rules());

        $data = $request->all();
        $data['USUARIO_ID'] = Auth::user()->USUARIO_ID;

        $data = Address::create($data);

        return response()->json($data, 201);
    } 

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

    public function destroy($id) {
        $address = Address::find($id);

        if (!$address) {
            throw new MasterNotFoundHttpException;
        }

        $address->delete();

        return response()->json('', 204);
    }
}
