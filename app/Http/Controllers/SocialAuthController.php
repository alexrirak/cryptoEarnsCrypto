<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;

class SocialAuthController extends Controller
{
    public function landing()
    {
        return view('auth.login');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider, Request $request)
    {
        // Try to catch errors coming back from the providers
        if (!$request->has('code') || $request->has('error')) {
            return redirect('login')->withErrors([__('auth.external-error')]);
        }

        $userSocial =   Socialite::driver($provider)->user();

        // If we did not get an email send the user back with an error - we only expect this from facebook
        if ($userSocial->getEmail() == null) {

            // if the provider is facebook, delete the connection so that user can try again
            // we dont expect to get other provider here but if we do user will have to sever connection manually
            if ($provider == "facebook") {
                $http = new Client();
                $http->delete("https://graph.facebook.com/v3.0/".$userSocial->getId()."/permissions?access_token=".$userSocial->token);
            }

            return redirect('login')->withErrors([__('auth.no-email-error')]);
        }

        // Find the user by email, provider is not currently checked
        $user       =   User::where(['email' => $userSocial->getEmail()])->first();

        // As per guidelines regenerate session
        $request->session()->regenerate();

        if($user){
            // If the user is found log them in
            Auth::login($user); //pass true as 2nd param to stay logged in indefinitely
        }else{
            // If the user is not found create an account
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
            Auth::login($user);
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
