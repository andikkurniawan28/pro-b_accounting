<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Setting;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class BalanceSheetController extends Controller
{
    public function index(){
        $assets = Account::where('account_group_id', 1)->get();
        $liabilities = Account::where('account_group_id', 2)->get();
        $equities = Account::where('account_group_id', 3)->get();
        return view('balance_sheet.index', compact('assets', 'liabilities', 'equities'));
    }

    public function data($year, $month) {
        $setting = Setting::first();

        $data = [
            'assets' => [],
            'liabilities' => [],
            'equities' => [],
            'totals' => [
                'assets' => 0,
                'liabilities' => 0,
                'equities' => 0,
                'passiva' => 0,
                'imbalance' => 0,
            ]
        ];

        $account_groups = [
            'assets' => Account::where('account_group_id', 1)->get(),
            'liabilities' => Account::where('account_group_id', 2)->get(),
            'equities' => Account::where('account_group_id', 3)->get(),
        ];

        foreach ($account_groups as $group_key => $group) {
            foreach ($group as $account) {
                $debit = $this->getJournalSum($account->id, 'debit', $year, $month);
                $credit = $this->getJournalSum($account->id, 'credit', $year, $month);
                $balance = ($account->normal_balance == "Debit") ? $debit - $credit : $credit - $debit;
                $account->debit = $this->formatNumber($debit, $setting);
                $account->credit = $this->formatNumber($credit, $setting);
                $account->balance = $this->formatNumber($balance, $setting);
                $data['totals'][$group_key] += $balance;
                $data[$group_key][] = $account;
            }
        }

        $data['totals']['passiva'] = $data['totals']['liabilities'] + $data['totals']['equities'];
        $data['totals']['imbalance'] = $data['totals']['assets'] - $data['totals']['passiva'];

        foreach ($data['totals'] as $key => $total) {
            $data['totals'][$key] = $this->formatNumber($total, $setting);
        }

        return $data;
    }

    private function getJournalSum($accountId, $type, $year, $month) {
        return JournalEntry::where('account_id', $accountId)
            ->whereHas('journal', function($query) use ($year, $month) {
                $query->whereYear('date', $year)
                      ->whereMonth('date', $month);
            })
            ->sum($type);
    }

    private function formatNumber($number, $setting) {
        if ($number > 0) {
            return number_format($number, 2, $setting->decimal_separator, $setting->thousand_separator);
        }
        return '('.number_format(abs($number), 2, $setting->decimal_separator, $setting->thousand_separator).')';
    }
}
