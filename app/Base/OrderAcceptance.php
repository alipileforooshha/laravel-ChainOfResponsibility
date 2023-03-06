<?php

namespace App\Base;

use App\Models\Product;
use Illuminate\Http\Request;

abstract class OrderAcceptance{
    
    protected $successor;

    abstract public function handle(Request $request, Product $product);

    public function succeedWith(OrderAcceptance $successor)
    {
        $this->successor = $successor;
    }

    public function next(Request $request, Product $product)
    {
        if($this->successor){
            $this->successor->handle();
        }
    }
}