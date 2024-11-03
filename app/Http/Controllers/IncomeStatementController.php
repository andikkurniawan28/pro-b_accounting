<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Setting;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class IncomeStatementController extends Controller
{
    public function index(){
        return view('income_statement.index');
    }

    public function data($year, $month) {
        $setting = Setting::first();

        $data = [
            'revenues' => [],
            'expenses' => [],
            'totals' => [
                'revenues' => 0,
                'expenses' => 0,
            ]
        ];

        $account_groups = [
            'revenues' => Account::where('account_group_id', 4)->get(),
            'expenses' => Account::where('account_group_id', 5)->get(),
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
