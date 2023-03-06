<?php

namespace App\Http\Middleware;

use App\Base\OrderAcceptance;
use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductCountIsEnough extends OrderAcceptance
{

    public function handle(Request $request, Product $product)
    {
        if($product->count < $request->count){
            DB::rollBack();
            abort(422, "product count is not enough");
        }
        $this->next($request, $product);
    }

}
