<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     *购物车展示页面
     */
    public function cart(){
        return view(' cart.CartIndex ');
    }
}
