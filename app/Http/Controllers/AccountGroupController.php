<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccountGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AccountGroup::latest()->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('account_group.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('account_group.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        AccountGroup::create($request->all());
        return redirect()->route('account_group.index')->with('success', 'AccountGroup has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AccountGroup $account_group)
    {
        return view('account_group.edit', compact('account_group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AccountGroup $account_group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $account_group->update($request->all());
        return redirect()->route('account_group.index')->with('success', 'AccountGroup has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account_group = AccountGroup::findOrFail($id);
        $account_group->delete();
        return redirect()->back()->with("success", "AccountGroup has been deleted.");
    }
}
