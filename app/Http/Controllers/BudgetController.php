<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Setting;
use App\Models\Account;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = Budget::with(['account'])->latest()->get();
            return Datatables::of($data)
                ->editColumn('account_id', function($row) {
                    return $row->account ? $row->account->name : '-';
                })
                ->editColumn('start_date', function ($budget) {
                    return $budget->start_date ? Carbon::parse($budget->start_date)->format('d-m-Y') : '';
                })
                ->editColumn('end_date', function ($budget) {
                    return $budget->end_date ? Carbon::parse($budget->end_date)->format('d-m-Y') : '';
                })
                ->make(true);
        }
        return view('budget.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        $accounts = Account::all();
        return view('budget.create', compact('accounts', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'start_date'   => 'required|date|before_or_equal:end_date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);
        Budget::create($validated);
        return redirect()->route('budget.index')->with('success', 'Budget has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
        $setting = Setting::init();
        $accounts = Account::all();
        return view('budget.edit', compact('budget', 'accounts', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'account_id' => 'required|exists:accounts,id',
            'description'  => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'start_date'   => 'required|date|before_or_equal:end_date',
            'end_date'     => 'required|date|after_or_equal:start_date',
        ]);
        $budget->update($validated);
        return redirect()->route('budget.index')->with('success', 'Budget has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $budget = Budget::findOrFail($id);
        $budget->delete();
        return redirect()->back()->with("success", "Budget has been deleted.");
    }
}
