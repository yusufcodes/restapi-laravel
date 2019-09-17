<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function store(Request $request)
    {
        return "AuthController - Store: Works!";
    }

    public function signin(Request $request)
    {
        return "AuthController - SignIn: Works!";
    }
}
