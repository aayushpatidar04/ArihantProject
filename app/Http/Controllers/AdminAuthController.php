<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            if ($this->isAdmin(Auth::user()->email)) {
                return redirect()->to($this->redirectPath($request));
            }

            Auth::logout();
        }

        return view('admin.login', ['redirect' => $request->query('redirect')]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
            'redirect' => ['nullable', 'string'],
        ]);
        $email = strtolower(trim($credentials['email']));

        if (!$this->isAdmin($email) || !Auth::attempt([
            'email' => $email,
            'password' => $credentials['password'],
        ], $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match an admin account.'])
                ->withInput($request->only('email', 'redirect'));
        }

        $request->session()->regenerate();

        return redirect()->to($this->redirectPath($request));
    }

    protected function isAdmin(string $email): bool
    {
        return in_array(strtolower($email), array_map('strtolower', config('event.admin_emails', [])), true);
    }

    protected function redirectPath(Request $request): string
    {
        $redirect = $request->input('redirect', $request->query('redirect'));

        if (is_string($redirect) && str_starts_with($redirect, '/admin')) {
            return $redirect;
        }

        return route('admin.dashboard');
    }
}