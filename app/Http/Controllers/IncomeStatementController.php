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
            'cogs' => [], // Cost of Goods Sold
            'other_income' => [],
            'other_expense' => [],
            'totals' => [
                'revenues' => 0,
                'expenses' => 0,
                'cogs' => 0,
                'other_income' => 0,
                'other_expense' => 0,
                'gross_profit' => 0,
                'operating_profit' => 0,
                'net_profit' => 0,
                'all_revenue' => 0,
                'all_expense' => 0,
            ]
        ];

        // Define account groups
        $account_groups = [
            'revenues' => Account::where('account_group_id', 4)->get(),
            'expenses' => Account::where('account_group_id', 5)->get(),
            'cogs' => Account::where('account_group_id', 6)->get(),
            'other_income' => Account::where('account_group_id', 7)->get(),
            'other_expense' => Account::where('account_group_id', 8)->get(),
        ];

        // Calculate each group balance
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

        // Calculate Income Statement components
        $grossProfit = $data['totals']['revenues'] - $data['totals']['cogs'];
        $operatingProfit = $grossProfit - $data['totals']['expenses'];
        $netProfit = $operatingProfit + $data['totals']['other_income'] - $data['totals']['other_expense'];
        $all_revenue = $data['totals']['revenues'] + $data['totals']['other_income'];
        $all_expense = $data['totals']['expenses'] + $data['totals']['other_expense'];

        // Format totals and add calculated values
        foreach ($data['totals'] as $key => $total) {
            $data['totals'][$key] = $this->formatNumber($total, $setting);
        }

        // Adding calculated values for gross profit, operating profit, and net profit
        $data['totals']['gross_profit'] = $this->formatNumber($grossProfit, $setting);
        $data['totals']['operating_profit'] = $this->formatNumber($operatingProfit, $setting);
        $data['totals']['net_profit'] = $this->formatNumber($netProfit, $setting);
        $data['totals']['all_revenue'] = $this->formatNumber($all_revenue, $setting);
        $data['totals']['all_expense'] = $this->formatNumber($all_expense, $setting);

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

    public static function export($year, $month) {
        $setting = Setting::first();

        $data = [
            'revenues' => [],
            'expenses' => [],
            'cogs' => [], // Cost of Goods Sold
            'other_income' => [],
            'other_expense' => [],
            'totals' => [
                'revenues' => 0,
                'expenses' => 0,
                'cogs' => 0,
                'other_income' => 0,
                'other_expense' => 0,
                'gross_profit' => 0,
                'operating_profit' => 0,
                'net_profit' => 0,
                'all_revenue' => 0,
                'all_expense' => 0,
            ]
        ];

        // Define account groups
        $account_groups = [
            'revenues' => Account::where('account_group_id', 4)->get(),
            'expenses' => Account::where('account_group_id', 5)->get(),
            'cogs' => Account::where('account_group_id', 6)->get(),
            'other_income' => Account::where('account_group_id', 7)->get(),
            'other_expense' => Account::where('account_group_id', 8)->get(),
        ];

        // Calculate each group balance
        foreach ($account_groups as $group_key => $group) {
            foreach ($group as $account) {
                $debit = self::getJournalSumExport($account->id, 'debit', $year, $month);
                $credit = self::getJournalSumExport($account->id, 'credit', $year, $month);
                $balance = ($account->normal_balance == "Debit") ? $debit - $credit : $credit - $debit;
                $account->debit = self::formatNumberExport($debit, $setting);
                $account->credit = self::formatNumberExport($credit, $setting);
                $account->balance = self::formatNumberExport($balance, $setting);
                $data['totals'][$group_key] += $balance;
                $data[$group_key][] = $account;
            }
        }

        // Calculate Income Statement components
        $grossProfit = $data['totals']['revenues'] - $data['totals']['cogs'];
        $operatingProfit = $grossProfit - $data['totals']['expenses'];
        $netProfit = $operatingProfit + $data['totals']['other_income'] - $data['totals']['other_expense'];
        $all_revenue = $data['totals']['revenues'] + $data['totals']['other_income'];
        $all_expense = $data['totals']['expenses'] + $data['totals']['other_expense'];

        // Format totals and add calculated values
        foreach ($data['totals'] as $key => $total) {
            $data['totals'][$key] = self::formatNumberExport($total, $setting);
        }

        // Adding calculated values for gross profit, operating profit, and net profit
        $data['totals']['gross_profit'] = self::formatNumberExport($grossProfit, $setting);
        $data['totals']['operating_profit'] = self::formatNumberExport($operatingProfit, $setting);
        $data['totals']['net_profit'] = self::formatNumberExport($netProfit, $setting);
        $data['totals']['all_revenue'] = $all_revenue;
        $data['totals']['all_expense'] = $all_expense;

        return $data;
    }

    public static function getJournalSumExport($accountId, $type, $year, $month) {
        return JournalEntry::where('account_id', $accountId)
            ->whereHas('journal', function($query) use ($year, $month) {
                $query->whereYear('date', $year)
                      ->whereMonth('date', $month);
            })
            ->sum($type);
    }

    public static function formatNumberExport($number, $setting) {
        if ($number > 0) {
            return number_format($number, 2, $setting->decimal_separator, $setting->thousand_separator);
        }
        return '('.number_format(abs($number), 2, $setting->decimal_separator, $setting->thousand_separator).')';
    }
}
