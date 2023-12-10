<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(Category $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
