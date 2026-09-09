<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = \App\Models\Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);
        
        $role = \App\Models\Role::create($request->only('name'));
        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' berhasil ditambahkan!");
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
        $role = \App\Models\Role::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = \App\Models\Role::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,'.$id,
        ]);
        
        $role->update($request->only('name'));
        return redirect()->route('roles.index')->with('success', "Role '{$role->name}' berhasil diperbarui!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = \App\Models\Role::findOrFail($id);
        $name = $role->name;
        $role->delete();
        
        return redirect()->route('roles.index')->with('success', "Role '{$name}' berhasil dihapus!");
    }
}
