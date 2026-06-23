<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\RentalOwner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm(){
        return view('auth.register');
    }

   public function store (RegisterRequest $request){
        // dd($request->only(['role', 'business_name', 'business_address']));
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'role' => $request->role ?? 'user',
        ]);

        if ($user->role === 'manager') {
            RentalOwner::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'business_address' => $request->business_address,
                'tax_number' => $request->tax_number,
                'verification_status' => 'pending',
            ]);
        }

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
            'superAdmin' => 'superadmin/dashboard',
            'manager' => 'manager/dashboard',
            default => 'dashboard',
        };
    }
}