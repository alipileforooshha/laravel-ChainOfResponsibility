<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ProductCountIsEnough;
use App\Http\Middleware\UserCityIsAvailable;
use App\Http\Middleware\UserHasEnoughCredit;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(1);
        DB::beginTransaction();
        $productCount = new ProductCountIsEnough();
        $userCityIsAvailable = new UserCityIsAvailable();
        $userCreditIsEnough = new UserHasEnoughCredit();

        $productCount->succeedWith($userCityIsAvailable);
        $userCityIsAvailable->succeedWith($userCreditIsEnough);

        $product = Product::find($request->product_id);

        $productCount->handle($request, $product);
        
        Order::create([
            'product_id' => $product->id,
            'user_id' => $user->id
        ]);
        DB::commit();
    }
}
