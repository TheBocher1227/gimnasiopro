<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Exception;

class AuthController extends Controller
{
    /**
     * Mostrar el formulario de login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:4'],
        ], [
            'username.required' => 'El usuario es obligatorio.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
        ]);

        try {
            $user = User::where('username', $request->username)->first();

            if (!$user) {
                return back()->withErrors([
                    'username' => 'Las credenciales no coinciden con nuestros registros.',
                ])->onlyInput('username');
            }

            // Convertir $2b$ (Node.js bcrypt) a $2y$ (PHP bcrypt) para compatibilidad
            $hash = $user->password;
            if (str_starts_with($hash, '$2b$')) {
                $hash = '$2y$' . substr($hash, 4);
            }

            if (password_verify($request->password, $hash)) {
                // Solo admins pueden acceder
                if ($user->rol !== 'admin') {
                    return back()
                        ->with('error', 'Acceso denegado. Solo administradores pueden ingresar.')
                        ->onlyInput('username');
                }

                Auth::login($user);
                $request->session()->regenerate();

                return redirect()->intended('/home')->with('success', 'Bienvenido, ' . $user->nombre);
            }

            return back()->withErrors([
                'username' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('username');

        } catch (QueryException $e) {
            Log::error('Error de base de datos en login: ' . $e->getMessage());

            return back()
                ->with('error', 'Servicio no disponible. Intente de nuevo más tarde.')
                ->onlyInput('username');

        } catch (Exception $e) {
            Log::error('Error inesperado en login: ' . $e->getMessage());

            return back()
                ->with('error', 'Ocurrió un error inesperado. Intente de nuevo más tarde.')
                ->onlyInput('username');
        }
    }

    /**
     * Cerrar sesión.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Sesión cerrada correctamente.');
    }
}
