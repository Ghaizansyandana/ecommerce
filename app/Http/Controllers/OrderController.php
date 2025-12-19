<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function show($order)
    {
        return view('admin.orders.show', ['order' => $order]);
    }
}
