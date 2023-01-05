<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\ProductInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Product;

class ProductRepository implements ProductInterface
{

    use ApiResponseTrait;

    public function products()
    {
        $products=Product::all();
        return $this->apiResponse(200,'Products',null,$products);
    }
}
