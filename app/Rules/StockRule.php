<?php

namespace App\Rules;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StockRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
       $product= Product::where([['id',request('product_id')],['stock','>=',$value]])->first();
       if ($product)
       {
           $cart=Cart::where([['user_id',Auth::user()->id],['product_id',$product->id]])->first();
           if ($cart)
           {
               if ($cart->count+$value <= $product->stock)
               {
                   return true;
               }
               else
               {
                   return false;
               }
           }
           return true;
       }

       return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stock Not Found';
    }
}
