<?php

namespace App\Http\Controllers;

use App\Models\LoginToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;

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
        if (!$request->hasValidSignature() || !$token->isValid()) {
            session()->flash('errors', new MessageBag(["invalidLink"=>"The link the brought you here has expired. You can use the form below to request a new link."]));
            return redirect()->route('email-login-landing');
        }

        $token->consume();
        Auth::login($token->user);

        return redirect()->route('home');
    }
}
