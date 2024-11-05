<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Setting;
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
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = Account::with(['account_group'])->latest()->get();
            return Datatables::of($data)
                ->editColumn('account_group_id', function($row) {
                    return $row->account_group ? $row->account_group->name : '-';
                })
                ->make(true);
        }
        return view('account.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        $account_groups = AccountGroup::all();
        return view('account.create', compact('account_groups', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_group_id' => 'required|exists:account_groups,id',
            'name' => 'required|string|max:255|unique:accounts,name',
            'code' => 'required|string|max:255|unique:accounts,code',
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
        $setting = Setting::init();
        $account_groups = AccountGroup::all();
        return view('account.edit', compact('account', 'account_groups', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        $request->validate([
            'account_group_id' => 'required|exists:account_groups,id',
            'name' => 'required|string|max:255|unique:accounts,name,' . $account->id,
            'code' => 'required|string|max:255|unique:accounts,code,' . $account->id,
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
