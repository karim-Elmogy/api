<?php

namespace App\Http\Interfaces;

interface CartInterface
{
    public function index();

    public function store($request);

    public function Update($request);

    public function delete($request);
}
