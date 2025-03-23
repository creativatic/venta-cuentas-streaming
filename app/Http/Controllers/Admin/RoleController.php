<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage roles');
    }

    public function index()
    {
        $roles = Role::with('permissions')->get();
        
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = Role::create($request->validated());
        $role->permissions()->sync($request->input('permissions', []));
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol creado correctamente');
    }

    public function show(Role $role)
    {
        $role->load('permissions');
        // Obtener usuarios con este rol
        $users = $role->users()->get();
        
        return view('admin.roles.show', compact('role', 'users'));
    }


    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions');
        
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $role->permissions()->sync($request->input('permissions', []));
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol actualizado correctamente');
    }

    public function destroy(Role $role)
    {
        if ($role->title === 'Super Admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'No es posible eliminar el rol de Super Admin');
        }
        // Eliminar la relación con usuarios y permisos
        $role->users()->detach();
        $role->permissions()->detach();
        $role->delete();
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente');
    }
}