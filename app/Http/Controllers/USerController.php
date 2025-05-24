<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 


class USerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            return view('usuarios');

    }
    public function login()
    {
            return view('login');

    }
     public function loginProcess()
    {
        $users = User::all();

        return view('usuarios.index', compact('users'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
    ]);

    \App\Models\User::create($validated);

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
{
    $user = User::findOrFail($id);
    return view('usuarios.edit', compact('user'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
    ]);

    $user = User::findOrFail($id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    return redirect()->route('usuarios.login')->with('success', 'Usuario actualizado correctamente.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);  
        $user->delete();

return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
