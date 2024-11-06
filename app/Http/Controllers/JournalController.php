<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Budget;
use App\Models\Account;
use App\Models\Journal;
use App\Models\Setting;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class JournalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $setting = Setting::init();
        if ($request->ajax()) {
            $data = Journal::with(['user'])->latest()->get();
            return Datatables::of($data)
                ->editColumn('user_id', function($journal) {
                    return $journal->user ? $journal->user->name : '';
                })
                ->editColumn('date', function ($journal) {
                    return $journal->date ? Carbon::parse($journal->date)->format('d-m-Y') : '';
                })
                ->editColumn('created_at', function ($journal) {
                    return $journal->created_at ? $journal->created_at->format('d-m-Y H:i') : '';
                })
                ->make(true);
        }
        return view('journal.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $setting = Setting::init();
        $code = Journal::generateCode();
        $accounts = Account::all();
        return view('journal.create', compact('code', 'accounts', 'setting'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $setting = Setting::get()->first();
        $request->merge([
            'debit' => floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $request->debit))),
            'credit' => floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $request->credit))),
            'details' => array_map(function ($detail) use ($setting) {
                $detail['debit'] = floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $detail['debit'])));
                $detail['credit'] = floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $detail['credit'])));
                return $detail;
            }, $request->details)
        ]);

        $request->request->add(["user_id" => Auth()->user()->id]);
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string|max:255|unique:journals,code',
            'date' => 'required',
            'debit' => 'required',
            'credit' => 'required',
            'details' => 'required|array',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.description' => 'nullable|string|max:255',
            'details.*.debit' => 'required|numeric',
            'details.*.credit' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $journal = Journal::create([
                'user_id' => $request->user_id,
                'code' => $request->code,
                'date' => $request->date,
                'debit' => $request->debit,
                'credit' => $request->credit,
            ]);
            foreach ($request->details as $detail) {
                $journal->journal_entry()->create([
                    'account_id' => $detail['account_id'],
                    'description' => $detail['description'],
                    'debit' => $detail['debit'],
                    'credit' => $detail['credit'],
                ]);
            }
            DB::commit();
            return redirect()->route('journal.index')->with('success', 'Journal has been created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['fail' => 'Failed to create journal: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journal $journal)
    {
        $setting = Setting::init();
        $accounts = Account::all();
        return view('journal.edit', compact('journal', 'accounts', 'setting'));
    }

    public function show(Journal $journal)
    {
        $setting = Setting::init();
        return view('journal.show', compact('journal', 'setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::init();
        $request->merge([
            'debit' => floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $request->debit))),
            'credit' => floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $request->credit))),
            'details' => array_map(function ($detail) use ($setting) {
                $detail['debit'] = floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $detail['debit'])));
                $detail['credit'] = floatval(str_replace($setting->decimal_separator, '.', str_replace($setting->thousand_separator, '', $detail['credit'])));
                return $detail;
            }, $request->details)
        ]);

        $request->validate([
            'date' => 'required|date',
            'debit' => 'required|numeric',
            'credit' => 'required|numeric',
            'details' => 'required|array',
            'details.*.account_id' => 'required|exists:accounts,id',
            'details.*.description' => 'required|string',
            'details.*.debit' => 'required|numeric',
            'details.*.credit' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $journal = Journal::findOrFail($id);
            $journal->date = $request->date;
            $journal->debit = $request->debit;
            $journal->credit = $request->credit;
            $journal->save();
            $journal->journal_entry()->delete();
            foreach ($request->details as $detail) {
                $journal->journal_entry()->create([
                    'account_id' => $detail['account_id'],
                    'description' => $detail['description'],
                    'debit' => $detail['debit'],
                    'credit' => $detail['credit'],
                ]);
            }
            DB::commit();
            return redirect()->route('journal.index')->with('success', 'Journal updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['fail' => 'Failed to update journal: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $journal = Journal::findOrFail($id);
        foreach($journal->journal_entry as $journal_entry){
            $journal_entry->delete();
        }
        $journal->delete();
        return redirect()->back()->with("success", "Journal has been deleted.");
    }
}
