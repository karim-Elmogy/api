<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\ProductInterface;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public $productsInterface;
    public function __construct(ProductInterface $productsInterface)
    {
        $this->productsInterface=$productsInterface;
    }

    public function products()
    {
        return $this->productsInterface->products();
    }
}
