<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\OrderInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $orderInterface;
    public function __construct(OrderInterface $orderInterface)
    {
        $this->orderInterface=$orderInterface;
    }

    public function checkout(Request $request)
    {
        return $this->orderInterface->checkout($request);
    }
}
