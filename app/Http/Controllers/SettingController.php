<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Currency;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::init();
        $currencies = Currency::all();
        return view('setting.index', compact('currencies', 'setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $setting = Setting::get()->first();

        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_phone' => 'required|string|max:15',
            'company_email' => 'required|email|max:255',
            'company_street' => 'required|string|max:255',
            'company_city_and_province' => 'required|string|max:255',
            'company_country' => 'required|string|max:255',
            'currency_id' => 'required|exists:currencies,id',
            'thousand_separator' => 'required|string|max:1',
            'decimal_separator' => 'required|string|max:1',
            'locale_string' => 'required|string|max:5',
        ]);

        if ($request->hasFile('company_logo')) {
            $image_name = time() . '.' . $request->company_logo->extension();
            $request->company_logo->move(public_path('settings'), $image_name);
            $validated["company_logo"] = 'settings/' . $image_name;
            if ($setting->company_logo && file_exists(public_path($setting->company_logo))) {
                @unlink(public_path($setting->company_logo));
            }
        }

        Setting::whereId($setting->id)->update($validated);
        return redirect()->route('setting.index')->with('success', 'Setting has been updated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
