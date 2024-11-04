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

    // Fungsi untuk mendapatkan data bulanan untuk income statement
    public static function monthlyData($year) {
        $setting = Setting::first();

        $monthlyData = [
            'revenue' => array_fill(0, 12, 0),
            'expenses' => array_fill(0, 12, 0),
        ];

        // Loop untuk menghitung revenue dan expenses setiap bulan

        for ($month = 1; $month <= 12; $month++) {
            $data = self::calculateMonthlyRevenueExpenses($year, $month); // Memanggil fungsi yang menghitung income statement
            $monthlyData['revenue'][$month - 1] = $data['totals']['revenue']; // Menggunakan total revenue
            $monthlyData['expenses'][$month - 1] = $data['totals']['expenses']; // Menggunakan total expenses
        }

        return $monthlyData;
    }

    // Fungsi public untuk menghitung income statement untuk bulan tertentu
    public static function calculateMonthlyRevenueExpenses($year, $month) {
        $data = [
            'totals' => [
                'revenue' => 0,
                'expenses' => 0,
            ],
        ];

        // Define account groups berdasarkan jenis aktivitas
        $account_groups = [
            'revenue' => Account::whereHas('account_group', function ($query) {
                $query->whereIn('id', [4, 7]);
            })->get(),
            'expenses' => Account::whereHas('account_group', function ($query) {
                $query->whereIn('id', [6, 8]);
            })->get(),
        ];

        // Hitung saldo untuk setiap grup
        foreach ($account_groups as $group_key => $group) {
            foreach ($group as $account) {
                // Ambil total debit dan kredit untuk akun
                $debit = (new self())->getJournalSum($account->id, 'debit', $year, $month);
                $credit = (new self())->getJournalSum($account->id, 'credit', $year, $month);
                $balance = ($account->normal_balance == "Debit") ? $debit - $credit : $credit - $debit;

                // Tambahkan ke total sesuai grup
                if ($group_key == 'revenue') {
                    $data['totals']['revenue'] += $balance;
                } elseif ($group_key == 'expenses') {
                    $data['totals']['expenses'] += $balance;
                }
            }
        }

        return $data; // Mengembalikan hasil perhitungan
    }
}
