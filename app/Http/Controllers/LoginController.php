<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\User;


class LoginController extends Controller
{
    public function loginProcess(Request $request): View|RedirectResponse
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $users = User::all();
        return view('usuarios.index', compact('users'))->with('success', 'Inicio de sesión exitoso');
    }

    return back()->withErrors([
        'email' => 'Las credenciales proporcionadas son incorrectas.',
    ])->onlyInput('email');
}
}
