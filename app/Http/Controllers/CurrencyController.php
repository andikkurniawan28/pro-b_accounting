<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = Currency::latest()->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('currency.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        return view('currency.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:currencys,name',
            'symbol' => 'required|string|max:255',
        ]);

        Currency::create($request->all());
        return redirect()->route('currency.index')->with('success', 'Currency has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Currency $currency)
    {
        $setting = Setting::init();
        return view('currency.edit', compact('currency', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:currencys,name,' . $currency->id,
            'symbol' => 'required|string|max:255',
        ]);

        $currency->update($request->all());
        return redirect()->route('currency.index')->with('success', 'Currency has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect()->back()->with("success", "Currency has been deleted.");
    }
}
