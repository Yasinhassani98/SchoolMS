<?php

namespace App\Http\Controllers;

use App\Models\Parint;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ParintRequest;
use Illuminate\Support\Facades\Hash;

class ParintController extends Controller
{
    public function index()
    {
        $parints = Parint::paginate(10);
        return view('admin.parints.index', compact('parints'));
    }
    public function create()
    {
        $users = User::all();
        return view('admin.parints.create', compact('users'));
    }
    public function store(ParintRequest $request)
    {
        dd($request->all());

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('parint');

        $parint = new Parint([
            ...$request->except('image', 'email', 'password', 'password_confirmation'),
        ]);

        $parint->user_id = $user->id;

        if ($request->hasFile('image')) {
            $parint->image = $request->file('image')->store('Parints', 'public');
        }

        $parint->save();

        return redirect()->route('admin.parints.index')->with('success', 'Parint created successfully');
    }
    public function edit(Parint $parint)
    {
        $users = User::all();
        return view('admin.parints.edit', compact('parint', 'users'));
    }
    public function update(Request $request, Parint $parint)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);
        $parint->update($validatedData);
        return redirect()->route('admin.parints.index')->with('success', 'Parint updated successfully');
    }
    public function destroy(Parint $parint)
    {
        $parint->delete();
        return redirect()->route('admin.parints.index')->with('success', 'Parint deleted successfully');
    }
}
