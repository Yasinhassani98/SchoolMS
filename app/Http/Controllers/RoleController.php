<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ResponseNotification;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'nullable|string',
        ]);

        $role = Role::create(['name' => $request->name]);
        $permissions = explode(',', $request->permissions);
        if ($permissions) {
            $role->syncPermissions($permissions);
        }
        Auth::user()->notify(new ResponseNotification('success', 'Role created successfully'));
        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|string',
        ]);

        $role->update(['name' => $request->name]);
        $permissions = explode(',', $request->permissions);
        $role->syncPermissions($permissions ?? []);
        Auth::user()->notify(new ResponseNotification('success', 'Role updated successfully'));

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        if ($role->name === 'admin' || $role->name === 'superadmin' ) {
            Auth::user()->notify(new ResponseNotification('danger', 'Cannot delete this role'));
            return redirect()->route('admin.roles.index');
        }
        
        $role->delete();
        Auth::user()->notify(new ResponseNotification('success', 'Role deleted successfully'));
        return redirect()->route('admin.roles.index');
    }
}
