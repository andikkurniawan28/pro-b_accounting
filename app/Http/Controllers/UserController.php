<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::with(['role'])->latest()->get();
            return Datatables::of($data)
                ->editColumn('role_id', function($row) {
                    return $row->role ? $row->role->name : '-';
                })
                ->make(true);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id', // Validate role_id to ensure it exists in the roles table
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Ensure the email is unique
            'password' => 'required|string|min:8', // Password must be at least 8 characters
            'is_active' => 'boolean', // Validate is_active as a boolean
        ]);

        User::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_active' => $request->is_active ? 1 : 0,
        ]);

        return redirect()->route('user.index')->with('success', 'User has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with("success", "User has been deleted.");
    }
}
