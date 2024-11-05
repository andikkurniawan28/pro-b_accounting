<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Role;
use App\Models\Setting;
use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = Role::latest()->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('role.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        $menus = Menu::all();
        return view('role.create', compact('menus', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create($validated);

        if ($request->has('menu_ids')) {
            Permission::where("role_id", $role->id)->delete();
            $menus = $request->input('menu_ids');
            foreach ($menus as $menu_id) {
                if (Menu::where('id', $menu_id)->exists()) {
                    Permission::create(['menu_id' => $menu_id, 'role_id' => $role->id]);
                }
            }
        }
        return redirect()->route('role.index')->with('success', 'Role has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $setting = Setting::init();
        $menus = Menu::all();
        $permissions = Permission::where('role_id', $role->id)->get();
        return view('role.edit', compact('role', 'menus', 'permissions', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
        ]);

        $role->update($validated);

        if ($request->has('menu_ids')) {
            Permission::where("role_id", $role->id)->delete();
            $menus = $request->input('menu_ids');
            foreach ($menus as $menu_id) {
                if (Menu::where('id', $menu_id)->exists()) {
                    Permission::create(['menu_id' => $menu_id,'role_id' => $role->id]);
                }
            }
        }

        return redirect()->route('role.index')->with('success', 'Role has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with("success", "Role has been deleted.");
    }
}
