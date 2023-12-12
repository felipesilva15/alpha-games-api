<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    public function __construct(Administrator $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function store(Request $request) {
        if (method_exists($this->model, 'rules')){
            $request->validate($this->model::rules());
        }

        $data = $request->all();
        $data['ADM_SENHA'] = Hash::make($data['ADM_SENHA']);
        
        $data = $this->model::create($data);

        return response()->json($data, 201);
    }
}
