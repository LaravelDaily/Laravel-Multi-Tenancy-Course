<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
}
