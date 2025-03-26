<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $users = User::with('roles')->paginate(10);
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Auth::user()->notify(new ResponseNotification('success', 'Subject created successfully'));
        if(Auth::user()->hasRole('admin')){
            $roles = Role::whereNotIn('name', ['superadmin','admin'])->get();
        }elseif(Auth::user()->hasRole('superadmin')){
            $roles  = Role::all();
        }
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|string',
        ]);
        $roles = explode(',', $request->roles);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole($roles);
        Auth::user()->notify(new ResponseNotification('success', 'User created successfully'));
        return redirect()->route('admin.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit',[
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' =>'nullable|string|min:8|confirmed',
            'roles' =>'required|string',
        ]);
        $roles = explode(',', $request->roles);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);
        $user->syncRoles($roles);
        Auth::user()->notify(new ResponseNotification('success', 'User updated successfully'));
        return redirect()->route('admin.users.index');
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        Auth::user()->notify(new ResponseNotification('success', 'User deleted successfully'));
        return redirect()->route('admin.users.index');
    }
}
