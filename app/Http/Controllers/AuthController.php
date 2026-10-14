<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    #private internal redirect function
    private function safeRedirect(Request $request): string {
        #grab inputted url from the larger function's request
        $redirect = $request->input('redirect');

        if (!$redirect) {
            return route('home');
        }
        $url = parse_url($redirect);
        #check for internal urls
        if (!isset($url['host'])) {
            if (str_starts_with($redirect, '/') && !str_starts_with($redirect, '//')) {
                return $redirect;
            }
            return route('home');
        }
        #check for appropriate absolute urls
        if (
            isset($url['scheme'], $url['host']) &&
            $url['scheme'] === $request->getScheme() &&
            $url['host'] === $request->getHost()
        ) {
            return $redirect;
        }

        #if everything fails
        return route('home');

    }
    #show login page on GET
    public function showLogin() {
        return view('auth.login');
    }
    #login POST request
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if ($request->input('redirect')) {
                return redirect()->to(
                    $this->safeRedirect($request)
                );
            }
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'username' => 'Username or Pasword is incorrect',
        ])->onlyInput('username');
    }
    #register page view
    public function showRegister() {
        return view('auth.register');
    }
    #handle register post
    public function register(Request $request) {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:45', 'unique:users,username'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        $user = User::create([
            'username' =>$validated['username'],
            'password' => Hash::make($validated['password']),
        ]);
        Auth::login($user);
        $request->session()->regenerate();
        if ($request->input('redirect')) {
            return redirect()->to(
                $this->safeRedirect($request)
            )->with('success', 'Account created successfully!');
        }
        return redirect()->intended(route('home'))
            ->with('success', 'Account created successfully!');

    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

}
