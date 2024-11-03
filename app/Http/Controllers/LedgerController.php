<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\JournalEntry;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LedgerController extends Controller
{
    public function index(Request $request) {
        $accounts = Account::all();
        return view("ledger.index", compact('accounts'));
    }

    public function getData($accountId, $fromDatetime, $toDatetime) {

        $yesterday = Carbon::parse($fromDatetime)->subDay()->format('Y-m-d');
        $account = Account::findOrFail($accountId);

        // Ambil data JournalEntry sebelum periode yang diminta untuk saldo awal
        $initialBalanceQuery = JournalEntry::with('journal')
            ->where('account_id', $accountId)
            ->whereHas('journal', function ($query) use ($fromDatetime) {
                $query->where('date', '<', $fromDatetime);
            });

        // Hitung total debit dan credit sebelum periode yang diminta
        $totalDebitBefore = $initialBalanceQuery->sum('debit');
        $totalCreditBefore = $initialBalanceQuery->sum('credit');

        // Ambil data JournalEntry dalam periode yang diminta
        $data = JournalEntry::join('journals', 'journal_entries.journal_id', '=', 'journals.id')
            ->with('account')
            ->where('journal_entries.account_id', $accountId)
            ->whereBetween('journals.date', [$fromDatetime, $toDatetime])
            ->orderBy('journals.date', 'asc')
            ->orderBy('journals.id', 'asc')
            ->get(['journal_entries.*']);

        // Mulai dengan saldo awal
        $initialBalance = 0;
        if ($account) {
            if ($account->normal_balance == 'Debit') {
                $initialBalance = ($totalDebitBefore - $totalCreditBefore);
            } elseif ($account->normal_balance == 'Credit') {
                $initialBalance = ($totalCreditBefore - $totalDebitBefore);
            }
        }
        $runningBalance = $initialBalance;

        // Menyiapkan data termasuk saldo awal sebagai baris pertama
        $results = [];
        $results[] = [
            'date' => date("d F Y", strtotime($yesterday)),
            'description' => 'Saldo Awal',
            'debit' => $totalDebitBefore,
            'credit' => $totalCreditBefore,
            'balance' => $initialBalance,
            'user' => "",
            'is_closing_entry' => '-',
            'code' => '-',
        ];

        // Variabel untuk menyimpan total debit dan credit selama periode
        $totalDebitDuring = 0;
        $totalCreditDuring = 0;

        foreach ($data as $row) {
            if ($row->account) {
                if ($row->account->normal_balance == 'Debit') {
                    $runningBalance += ($row->debit - $row->credit);
                } elseif ($row->account->normal_balance == 'Credit') {
                    $runningBalance += ($row->credit - $row->debit);
                }
            }

            $debit = $row->debit != 0 ? $row->debit : '-';
            $credit = $row->credit != 0 ? $row->credit : '-';

            $results[] = [
                'date' => date("d F Y", strtotime($row->journal->date)),
                'description' => $row->description,
                'debit' => $debit,
                'credit' => $credit,
                'balance' => $runningBalance,
                'user' => $row->journal->user->name,
                'is_closing_entry' => $row->is_closing_entry,
                'code' => $row->journal->code,
            ];

            // Update total debit dan credit selama periode
            $totalDebitDuring += $row->debit;
            $totalCreditDuring += $row->credit;
        }

        // Hitung saldo akhir berdasarkan normal_balance dari akun
        $finalBalance = $initialBalance;
        if ($account) {
            if ($account->normal_balance == 'Debit') {
                $finalBalance = $runningBalance;
            } elseif ($account->normal_balance == 'Credit') {
                $finalBalance = $runningBalance;
            }
        }

        // Tambahkan saldo akhir sebagai baris terakhir
        $results[] = [
            'date' => date("d F Y", strtotime($toDatetime)),
            'description' => 'Saldo Akhir',
            'debit' => $totalDebitDuring,
            'credit' => $totalCreditDuring,
            'balance' => $finalBalance,
            'user' => "",
            'is_closing_entry' => '-',
            'code' => '-',
        ];

        return Datatables::of(collect($results))
            ->addIndexColumn()
            ->make(true);
    }
}
