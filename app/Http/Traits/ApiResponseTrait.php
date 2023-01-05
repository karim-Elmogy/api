<?php

namespace App\Http\Traits;




trait ApiResponseTrait
{

    /**
     * [
     * code    => default 200 and dataType is int.
     * message => default null and dataType is String.
     * errors  => default null and dataType is Array.
     * data    => default null and dataType is Array.
     * ]
     */


    public  function apiResponse($code = 200 , $message = null , $errors = null , $data = null)
    {


        $array = [
            'status'  => $code,
            'message' => $message,
        ];

        if(is_null($data) && !is_null($errors))
        {
            $array['errors'] = $code;
        }
        elseif (!is_null($data) && is_null($errors))
        {
            $array['data'] = $data;
        }
        else
        {
            $array['data'] = $data;
            $array['errors'] = $code;
        }



        return response($array , 200);
    }



}
