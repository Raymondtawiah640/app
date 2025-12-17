<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller{

        public function showRegister(){
            return view('register');
        }

        public function showLogin(){
            return view('login');
        }


        public function login(Request $request){
        $incomingFields = $request->validate([
            'loginemail' => 'required',
            'loginpassword' => 'required'
        ]);

        if (Auth::attempt(['email' => $incomingFields['loginemail'], 'password' => $incomingFields['loginpassword']])){
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return back()->withErrors(['login' => 'Invalid credentials']);
        }
    }
     public function logout(Request $request){
         Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         return redirect('/')->with('success', 'You have been logged out successfully.');
     }

    public function register(Request $request){
        $incomingFields = $request->validate([
            'name' => ['required', 'min:3',  Rule::unique('users', 'name')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:20', 'confirmed'],
            'terms' => 'accepted'
        ]);
        $userData = [
            'name' => $incomingFields['name'],
            'email' => $incomingFields['email'],
            'password' => bcrypt($incomingFields['password'])
        ];
        $user = User::create($userData);

        Auth::login($user);
        return redirect('/')->with('success', 'Registration successful! Welcome to our platform.');

        
    }
}

