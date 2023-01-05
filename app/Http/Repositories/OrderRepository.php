<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\OrderInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Rules\CartStcokValidation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class OrderRepository implements OrderInterface
{

    use ApiResponseTrait;
    public function checkout($request)
    {

        $validation=Validator::make($request->header(),[
            'authorization'=>new CartStcokValidation()
        ]);

        if ($validation->fails())
        {
            return $this->apiResponse(400,'Validation Error',$validation->errors());
        }

        $cartItem=Cart::where('user_id',Auth::user()->id)->with('product')->get();


        $totalPrice=$cartItem->sum(function ($item){
            return $item->count * $item->product->price;
        });

        DB::transaction(function () use ($totalPrice , $cartItem) {
            $order=Order::create([
                'user_id'=>Auth::user()->id,
                'total_price'=>$totalPrice
            ]);

            foreach ($cartItem as $item)
            {
                OrderItem::create([
                   'order_id'=>$order->id,
                    'product_id'=>$item->product->id,
                    'count'=>$item->count,
                    'unit_price'=>$item->product->price,
                    'net_price'=>$item->count * $item->product->price
                ]);
                $product=Product::find($item->product->id);
                $product->update([
                    'stock'=>$product->stock - $item->count
                ]);
                $item->delete();
            }
        });

        return $this->apiResponse(200,'Order Was Created');
    }
}
