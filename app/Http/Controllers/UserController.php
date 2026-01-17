<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(){
        return view('auth.login');
    }


    public function profile()
    {
        $books = auth()->user()->books()->limit(10);

        return view('auth.profile', compact('books'));
    }
}
