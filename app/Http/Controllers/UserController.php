<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register (Request $request)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation');
        $validator = Validator::make($credentials, [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $response = ['success' => false, 'error' => $validator->errors()->first(), 'countries' => Country::get(['name','id'])];
            return view('register', $response);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country' => null,
            'state' => null,
            'city' => null
        ]);
        if (Country::where('id', $request->country)->first()) {
            User::where('email', $request->email)->update([
                'country' => Country::where('id', $request->country)->first()->name,
            ]);
        }
        if (State::where('id', $request->state)->first()) {
            User::where('email', $request->email)->update([
                'state' => State::where('id', $request->state)->first()->name,
            ]);
        }
        if (City::where('id', $request->city)->first()) {
            User::where('email', $request->email)->update([
                'city' => city::where('id', $request->city)->first()->name,
            ]);
        }
        event(new Registered($user));
        if (!Auth::attempt($request->only('email', 'password'))) {
            $response = ['success' => false, 'error' => 'Invalid email or username', 'countries' => Country::get(['name','id'])];
            return view('register', $response);
        }
        return redirect('home');
    }
    public function login (Request $request)
    {
        $validator = Validator::make($request->only(['email', 'password']), [
            'email' => 'required|email',
            'password' => 'required|alpha_num',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $response = ['success' => false, 'error' => $validator->errors()->first()];
            return view('login', $response);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            $response = ['success' => false, 'error' => 'Invalid email or username'];
            return view('login', $response);
        }
        return redirect('home');
    }
}
