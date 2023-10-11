<?php

namespace App\Http\Controllers;

use App\Helpers\ApiError;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class MasterController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $model;
    protected $request;

    public function index(Request $request) {
        $query = $this->model::query();
        $filters = $request->all();

        foreach ($filters as $field => $value) {
            if (in_array($field, $this->model->getFillable())) {
                if (gettype($value) == 'string') {
                    $query->where($field, 'like', '%'.trim($value).'%');
                } else {
                    $query->where($field, $value);
                }
            }
        }

        $data = $query->get();

        return response()->json($data, 200);
    }

    public function store(Request $request) {
        $request->validate($this->model::rules());

        $requestData = $request->all();

        $data = $this->model::create($requestData);

        return response()->json($data, 201);
    }

    public function show($id) {
        $data = $this->model::find($id);

        if (!$data) {
            return response()->json(new ApiError("CTRLMAST001", 'Registro não encontrado.', $this->request->path()), 404);
        }

        return response()->json($data, 200);
    }

    public function update(Request $request, $id) {
        $data = $this->model::find($id);

        if (!$data) {
            return response()->json(new ApiError("CTRLMAST001", 'Registro não encontrado.', $request->path()), 404);
        }

        $request->validate($this->model::rules());

        $requestData = $request->all();

        $data->update($requestData);

        return response()->json($data, 201);
    }

    public function destroy($id) {
        $data = $this->model::find($id);

        if (!$data) {
            return response()->json(new ApiError("CTRLMAST001", 'Registro não encontrado.', $this->request->path()), 404);
        }

        $data->delete();

        return response()->json('', 204);
    }
}
