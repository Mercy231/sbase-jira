<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            'password_confirmation' => 'required'
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $response = ['success' => false, 'error' => $validator->errors()->first()];
            return view('register', $response);
        }
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
            $response = ['success' => false, 'error' => 'Invalid email or username'];
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
