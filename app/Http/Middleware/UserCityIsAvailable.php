<?php

namespace App\Http\Middleware;

use App\Base\OrderAcceptance;
use App\Models\Product;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCityIsAvailable extends OrderAcceptance
{
    public function handle(Request $request, Product $product)
    {
        $user = User::find(1);
        if($request->location_id == 3){
            DB::rollBack();
            abort(422, "your location is not available");
        }
        return $this->next($request, $product);
    }
}
