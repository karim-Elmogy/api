<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CartInterface;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use App\Models\Product;
use App\Rules\StockRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartRepository implements CartInterface
{
    use ApiResponseTrait;


    public function index()
    {
        $carts=Cart::where('user_id',Auth::user()->id)->get();

//        $array=[
//            "id"=> $carts->id,
//            "user_id"=> Auth::user()->id,
//            'product_id'=>$carts->product()->name,
//            "count"=> $carts->count,
//        ];
        return $this->apiResponse(200,'carts',null,$carts);
    }

    public function store($request)
    {
        $validation=Validator::make($request->all(),[
            'product_id'=>'required|exists:products,id',
            'count'=>['required',new StockRule()]
        ]);



        if ($validation->fails())
        {
            return $this->apiResponse(400,'Not Found',$validation->errors());
        }
        $cart=Cart::where([['user_id',Auth::user()->id],['product_id',$request->product_id]])->first();


        if ($cart)
        {
            $cart->update([
                'count'=>($cart->count+$request->count)
            ]);
        }
        else
        {
            Cart::create([
                'user_id'=>Auth::user()->id,
                'product_id'=>$request->product_id,
                'count'=>$request->count
            ]);
        }

        return $this->apiResponse(200,'Add To Cart');
    }

    public function Update($request)
    {
        $validation=Validator::make($request->all(),[
            'product_id'=>'required|exists:products,id',
            'count'=>['required',new StockRule()]
        ]);
        $cart=Cart::where('id',$request->id)->where('user_id',Auth::user()->id)->first();

        if ($validation->fails())
        {
            return $this->apiResponse(400,'Not Found',$validation->errors());
        }


        $cart->update([
            'count'=>$request->count
        ]);


        return $this->apiResponse(200,'The Cart Was Updated');

    }

    public function delete($request)
    {
        $cart=Cart::where('id',$request->id)->where('user_id',Auth::user()->id)->first();
        if ($cart)
        {
            $cart->delete();
            return $this->apiResponse(200,'Cart Was Deleted');
        }
        else
        {
            return $this->apiResponse(400,'Cart Not Found');
        }

    }
}
