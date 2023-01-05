<?php

namespace App\Http\Interfaces;

interface AuthInterfaces
{
    public function register($request);

    public function login($request);

}
