<?php

// app/Http/Controllers/RoleController.php
namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Mostrar todos los roles
    public function index()
    {
        $roles = Role::all();
        return view('roles.index', compact('roles'));
    }

    // Mostrar el formulario para crear un nuevo rol
    public function create()
    {
        return view('roles.create');
    }

    // Almacenar un nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles|max:255',
        ]);

        Role::create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado con éxito.');
    }

    // Mostrar el formulario para editar un rol
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    // Actualizar un rol
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado con éxito.');
    }

    // Eliminar un rol
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado con éxito.');
    }
}

