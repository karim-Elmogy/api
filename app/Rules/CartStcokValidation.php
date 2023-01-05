<?php

namespace App\Rules;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Cart;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\If_;

class CartStcokValidation implements Rule
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
        $cartItem=Cart::where('user_id',Auth::user()->id)->with('product')->get();
        if (count($cartItem)==0)
        {
            return  false;
        }
        foreach ($cartItem as $item)
        {
            if ($item->product->stock < $item->count)
            {
                return false;
            }

        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Stock error .';
    }
}
