<?php

namespace App\Http\Controllers;

use App\Models\Parint;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ParintRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ParintController extends Controller
{
    public function index()
    {
        $parents = Parint::withCount('children')->paginate(10);
        return view('admin.parints.index', compact('parents'));
    }
    public function create()
    {
        $users = User::all();
        return view('admin.parints.create', compact('users'));
    }
    public function store(ParintRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('parent');

        $parent = new Parint([
            ...$request->except('image', 'email', 'password', 'password_confirmation'),
        ]);

        $parent->user_id = $user->id;

        if ($request->hasFile('image')) {
            $parent->image = $request->file('image')->store('Parents', 'public');
        }

        $parent->save();

        return redirect()->route('admin.parents.index')->with('success', 'Parent created successfully');
    }
    public function edit(Parint $parent)
    {
        $users = User::all();
        return view('admin.parints.edit', compact('parent', 'users'));
    }
    public function update(Request $request, Parint $parent)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $parent->user_id,
            'password' => 'nullable|min:6|confirmed',
            'Phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'image' => 'nullable|image',
        ]);
    
        // Update user information
        $user = User::findOrFail($parent->user_id);
        
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => !empty($validated['password']) 
                ? Hash::make($validated['password']) 
                : $user->password,
        ]);
        
        // Remove fields that belong to user model
        $parentData = collect($validated)
            ->except(['email', 'password', 'password_confirmation'])
            ->toArray();
        
        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($parent->image && Storage::disk('public')->exists($parent->image)) {
                Storage::disk('public')->delete($parent->image);
            }
            
            $parentData['image'] = $request->file('image')->store('Parent', 'public');
        }
    
        $parent->update($parentData);
    
        return redirect()
            ->route('admin.parents.index')
            ->with('success', 'Parent updated successfully');
    }
    public function show(Parint $parent)
    {
        $childrenNumber = $parent->children->count();
        return view('admin.parints.show', compact('parent', 'childrenNumber'));
    }
    public function destroy(Parint $parent)
    {
        if ($parent->image && Storage::disk('public')->exists($parent->image)) {
            Storage::disk('public')->delete($parent->image);
        }

        $user = User::findorfail($parent->user_id);
        $user->delete();
        return redirect()->route('admin.parents.index')->with('success', 'Parent deleted successfully');
    }
}
