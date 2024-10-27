<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Account::with(['account_group'])->latest()->get();
            return Datatables::of($data)
                ->editColumn('account_group_id', function($row) {
                    return $row->account_group ? $row->account_group->name : '-';
                })
                ->make(true);
        }
        return view('account.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $account_groups = AccountGroup::all();
        return view('account.create', compact('account_groups'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_group_id' => 'required|exists:account_groups,id', // Validate account_group_id to ensure it exists in the account_groups table
            'name' => 'required|string|max:255',
        ]);

        Account::create([
            'account_group_id' => $request->account_group_id,
            'name' => $request->name,
        ]);

        return redirect()->route('account.index')->with('success', 'Account has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        $account_groups = AccountGroup::all();
        return view('account.edit', compact('account', 'account_groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'account_group_id' => 'required|exists:account_groups,id',
            'name' => 'required|string|max:255',
        ]);

        $data = $request->all();

        $account->update($data);

        return redirect()->route('account.index')->with('success', 'Account has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();
        return redirect()->back()->with("success", "Account has been deleted.");
    }
}
