<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role; // Asegúrate de importar el modelo Role
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\Registered;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Muestra el formulario de registro de usuario.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Maneja el registro de un nuevo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Aquí asignamos un rol por defecto. Cambia 'user' por el nombre de rol que desees asignar
        $role = Role::where('name', 'user')->first(); // Asignamos el rol 'user'

        // Si el rol no existe, podemos crear uno por defecto o retornar un error
        if (!$role) {
            return redirect()->back()->with('error', 'El rol no existe.');
        }

        // Crear el usuario con el rol asignado
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id, // Asignar el role_id al nuevo usuario
        ]);

        // Disparar evento de registro
        event(new Registered($user));

        // Iniciar sesión automáticamente
        Auth::login($user);

        // Redirigir al dashboard o la página que desees
        return redirect(route('dashboard', absolute: false));
    }
}
