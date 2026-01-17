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
        $user = auth()->user();
        abort_if(! $user, 403);

        $user->loadCount('books');

        $books = $user->books()
            ->latest()
            ->paginate(8);

        return view('auth.profile', compact('user', 'books'));
    }
}
