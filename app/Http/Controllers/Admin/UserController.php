<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')
                    ->where('company_id', auth()->user()->company_id) // Restringir usuarios por empresa
                    ->get();

        return view('admin.users.index', compact('users'));
    }

    // public function editRoles(User $user)
    // {
    //     if ($user->company_id !== auth()->user()->company_id) {
    //         return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para modificar los roles de este usuario.');
    //     }
    
    //     $roles = Role::all();
    //     return view('admin.users.roles', compact('user', 'roles'));
    // }

    public function editRoles(User $user)
    {
        $roles = Role::all();
        return view('admin.users.roles', compact('user', 'roles'));
    }

    /**
     * Update roles for the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRoles(Request $request, User $user)
    {
        $roles = $request->has('roles') ? $request->roles : [];
        $user->roles()->sync($roles);

        return redirect()->route('admin.users.index')->with('success', 'Roles actualizados exitosamente para ' . $user->name);
    }

    /**
     * Get permissions for selected roles (AJAX endpoint).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPermissionsForRoles(Request $request)
    {
        $roles = Role::whereIn('id', $request->roles)->with('permissions')->get();
        
        // Extraer todos los permisos únicos de los roles seleccionados
        $permissions = collect();
        foreach ($roles as $role) {
            $permissions = $permissions->merge($role->permissions);
        }
        $uniquePermissions = $permissions->unique('id')->values();

        return response()->json(['permissions' => $uniquePermissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $companies = Company::all(); // Obtener todas las compañías
        return view('admin.users.create', compact('roles', 'companies'));
    }
        
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_id' => 'required|exists:companies,id', // Validar que la compañía exista
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'company_id' => $request->company_id, // Asignar company_id
        ]);

        if ($request->has('roles')) {
            $user->roles()->sync($request->roles);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function show(User $user)
    {
        if ($user->company_id !== auth()->user()->company_id) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para ver este usuario.');
        }

        $user->load('roles.permissions');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->company_id !== auth()->user()->company_id) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para editar este usuario.');
        }

        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => $request->filled('password') ? 'string|min:8|confirmed' : '',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Verificar si el usuario pertenece a la misma compañía
        if ($user->company_id !== auth()->user()->company_id) {
            return redirect()->route('admin.users.index')->with('error', 'No tienes permiso para eliminar este usuario.');
        }

        // Verificar si el usuario es el Super Admin
        if ($user->email === 'admin@gmail.com') { // Cambia 'admin@gmail.com' por el email del Super Admin
            return redirect()->route('admin.users.index')->with('error', 'No se puede eliminar al Super Admin.');
        }

        // Autorizar la eliminación del usuario
        $this->authorize('delete', $user);

        // Desvincular roles y eliminar el usuario
        $user->roles()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}