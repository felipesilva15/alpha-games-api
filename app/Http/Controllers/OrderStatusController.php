<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    public function __construct(OrderStatus $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}
