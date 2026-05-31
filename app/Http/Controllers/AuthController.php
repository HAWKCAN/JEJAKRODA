<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

    public function store (RegisterRequest $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pohone_number' => $request->phone_number,
            'role' => $request->role ?? 'user',
        ]);

        Auth::login($user);
        return redirect($this->redirectByRole($user->role));
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function authenticate(LoginRequest $request){
        if(!Auth::attempt($request->only('email','password'),$request->boolean('remember'))){
            return back()->withErrors([
                'email' => 'Email atau Password Salah.',
            ]);
        }
        $request->session()->regenerate();
        return redirect($this->redirectByRole(Auth::user()->role));
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function redirectByRole($role){
        return match($role){
            'superAdmin' => 'superAdmin/dashboard',
            'manager' => 'manager/dashboard',
            default => 'dashboard',
        };
    }

}
