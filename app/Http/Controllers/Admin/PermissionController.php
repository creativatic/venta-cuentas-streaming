<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:manage permissions');
    }

    public function index()
    {
        $permissions = Permission::all();
                
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('title', 'id');

        return view('admin.permissions.create', compact('roles'));
    }

    public function store(StorePermissionRequest $request)
    {
        
        $permission = Permission::create($request->validated());

        if ($request->has('roles')) {
            $permission->roles()->sync($request->input('roles'));
        }
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permiso creado correctamente');
            
    }

    public function show(Permission $permission)
    {
        // Cargar roles asociados a este permiso
        $permission->load('roles');
        
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        $roles = Role::all()->pluck('title', 'id');
        $permission->load('roles');

        return view('admin.permissions.edit', compact('permission', 'roles'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update($request->validated());
        
        if ($request->has('roles')) {
            $permission->roles()->sync($request->input('roles'));
        } else {
            $permission->roles()->detach();
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permiso actualizado correctamente');
    }

    public function destroy(Permission $permission)
    {
        // Verificar si es un permiso crítico del sistema
        if ($permission->title === 'admin_access') {
            return redirect()->route('permissions.index')
                ->with('error', 'No puedes eliminar un permiso crítico del sistema.');
        }
        
        // Eliminar las relaciones antes de eliminar el permiso
        $permission->roles()->detach();
        $permission->delete();
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permiso eliminado correctamente');
    }
}