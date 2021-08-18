<?php

namespace App\Http\Controllers;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailAuthController extends Controller
{
    /**
     * Displays the landing page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function landing()
    {
        return view('auth.email-login');
    }

    /**
     * Handles the login request by generating a token and sending the user an email with a link
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $data = $request->validate([
                                       'email' => ['required', 'email', 'exists:users,email'],
                                   ]);

        User::whereEmail($data['email'])->first()->sendLoginLink();
        session()->flash('success', true);
        return redirect()->back();
    }

    /**
     * Verifies the login token
     *
     * @param Request $request
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyLogin(Request $request, $token)
    {
        $token = LoginToken::whereToken(hash('sha256', $token))->firstOrFail();
        abort_unless($request->hasValidSignature() && $token->isValid(), 401);

        $token->consume();
        Auth::login($token->user);

        return redirect()->route('home');
    }
}
