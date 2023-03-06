<?php

namespace App\Http\Middleware;

use App\Base\OrderAcceptance;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserHasEnoughCredit extends OrderAcceptance
{
    public function handle(Request $request, Product $product)
    {
        $user = User::find(1);
        if(auth()->user()->balance < $request->count * $product->price)
        {
            DB::rollBack();
            abort(422, "user credit is not enough!");
        }
        return $this->next($request, $product);
    }
}
