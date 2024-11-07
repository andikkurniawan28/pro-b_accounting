<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\PaymentTerm;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PaymentTermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = PaymentTerm::latest()->get();
            return Datatables::of($data)
                ->make(true);
        }
        return view('payment_term.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        return view('payment_term.create', compact('setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_terms,name',
            'day' => 'required',
        ]);

        PaymentTerm::create($request->all());
        return redirect()->route('payment_term.index')->with('success', 'PaymentTerm has been created.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentTerm $payment_term)
    {
        $setting = Setting::init();
        return view('payment_term.edit', compact('payment_term', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentTerm $payment_term)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:payment_terms,name,' . $payment_term->id,
            'day' => 'required',
        ]);

        $payment_term->update($request->all());
        return redirect()->route('payment_term.index')->with('success', 'PaymentTerm has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $payment_term = PaymentTerm::findOrFail($id);
        $payment_term->delete();
        return redirect()->back()->with("success", "PaymentTerm has been deleted.");
    }
}
