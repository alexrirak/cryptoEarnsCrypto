<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EmailAuthController extends Controller
{
    public function landing()
    {
        return view('auth.email-login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
                                       'email' => ['required', 'email', 'exists:users,email'],
                                   ]);

        User::whereEmail($data['email'])->first()->sendLoginLink();
        session()->flash('success', true);
        return redirect()->back();
    }
}
