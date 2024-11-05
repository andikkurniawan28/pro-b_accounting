<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TaxRateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = TaxRate::latest()->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('tax_rate.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        return view('tax_rate.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tax_rates,name',
            'rate' => 'required',
        ]);

        TaxRate::create($request->all());
        return redirect()->route('tax_rate.index')->with('success', 'TaxRate has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaxRate $tax_rate)
    {
        $setting = Setting::init();
        return view('tax_rate.edit', compact('tax_rate', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaxRate $tax_rate)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tax_rates,name,' . $tax_rate->id,
            'rate' => 'required',
        ]);

        $tax_rate->update($request->all());
        return redirect()->route('tax_rate.index')->with('success', 'TaxRate has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tax_rate = TaxRate::findOrFail($id);
        $tax_rate->delete();
        return redirect()->back()->with("success", "TaxRate has been deleted.");
    }
}
