<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:assign roles');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        
        return view('admin.users.roles', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);
        
        $user->roles()->sync($request->input('roles', []));
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Roles asignados correctamente');
    }
}