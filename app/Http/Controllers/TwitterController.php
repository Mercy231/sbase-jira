<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{
    public function handle()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function handleCallback(Request $request)
    {
        $user = Socialite::driver('twitter')->user();

        $user = User::updateOrCreate([
            'twitter_id' => $user->id,
        ], [
            'email' => $user->nickname . '@mail.com',
            'twitter_id' => $user->id,
            'twitter_token' => $user->token,
            'password' => Hash::make('12345test'),
        ]);

        Auth::login($user);

        return redirect('/home');
    }
}
