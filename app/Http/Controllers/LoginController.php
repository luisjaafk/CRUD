<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Notifications\UserNotification;

class LoginController extends Controller
{
    /**
     * Procesa el inicio de sesión y devuelve un token JWT.
     */
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Activa una cuenta de usuario usando el token enviado por correo.
     */
    public function validateAccount($token)
    {
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token inválido o cuenta ya activada.'], 404);
        }

        $user->email_verified_at = now();
        $user->remember_token = null;
        $user->save();

        return response()->json(['message' => 'Cuenta activada correctamente. Ya puedes iniciar sesión.']);
    }

    /**
     * Cierra sesión del usuario (invalida el token actual).
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Sesión cerrada correctamente.']);
    }

    /**
     * Devuelve la información del usuario autenticado.
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
}
