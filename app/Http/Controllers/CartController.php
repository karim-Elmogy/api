<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\CartInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface=$cartInterface;
    }

   public function index()
   {
       return $this->cartInterface->index();
   }

   public function store(Request $request)
   {
       return $this->cartInterface->store($request);
   }

   public function update(Request $request)
   {
       return $this->cartInterface->Update($request);
   }

   public function delete(Request $request)
   {
       return $this->cartInterface->delete($request);
   }
}
