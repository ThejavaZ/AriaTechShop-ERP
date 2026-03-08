<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email|string",
            "password" => "required|string"
        ]);

        // Buscamos al usuario activo
        $user = User::where("email", $data["email"])
                    ->where('status', 1)
                    ->where('is_active', 1)
                    ->first();

        $remember = $request->has('remember');

        if ($user && Hash::check($data['password'], $user->password)) {
            Auth::login($user, $remember);

            // Retornamos respuesta exitosa para tu API
            return response()->json([
                'message' => 'Login exitoso',
                'user' => $user
            ], 200);
        }

        return response()->json(['message' => 'Credenciales incorrectas'], 401);
    }

    public function register(Request $request)
    {

        // AQUÍ APLICAS TU TARJETA DE SEGURIDAD (Validación robusta)
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)     // Mínimo 8 caracteres
                    ->letters()      // Debe tener letras
                    ->mixedCase()   // Mayúsculas y minúsculas
                    ->numbers()     // Al menos un número
                    ->symbols()     // Al menos un símbolo
                    ->uncompromised() // Verifica que no haya sido filtrada en internet
            ],
            "role" => "required|integer",
            "language" => "required|integer"
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            "role" => $data['role'],
            "language" => $data['language'],
            'status' => 1,
            'is_active' => 1
        ]);

        Auth::login($user);

        return response()->json([
            'message' => 'Usuario registrado con éxito',
            'user' => $user
        ], 201);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Sesión cerrada correctamente']);
    }
}
