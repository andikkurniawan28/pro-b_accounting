<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Account;
use App\Models\Setting;
use App\Models\JournalEntry;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    public function index() {
        return view('cash_flow.index');
    }

    public function data($year, $month) {
        $setting = Setting::first();

        $data = [
            'operating' => [],
            'investing' => [],
            'financing' => [],
            'totals' => [
                'operating' => 0,
                'investing' => 0,
                'financing' => 0,
                'net_cash_flow' => 0,
            ]
        ];

        // Define account groups based on activity type
        $account_groups = [
            'operating' => Account::whereHas('account_group', function ($query) {
                $query->where('activity_type', 'Operating');
            })->get(),
            'investing' => Account::whereHas('account_group', function ($query) {
                $query->where('activity_type', 'Investing');
            })->get(),
            'financing' => Account::whereHas('account_group', function ($query) {
                $query->where('activity_type', 'Financing');
            })->get(),
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

        // Calculate Net Cash Flow
        $data['totals']['net_cash_flow'] = $data['totals']['operating'] + $data['totals']['investing'] + $data['totals']['financing'];


        // Format totals
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

    // Fungsi untuk mendapatkan data bulanan untuk cash flow
    public static function monthlyData($year) {
        $setting = Setting::first();

        $monthlyData = [
            'cash_inflow' => array_fill(0, 12, 0), // Mengisi array dengan 0 untuk setiap bulan
            'cash_outflow' => array_fill(0, 12, 0),
        ];

        // Loop untuk menghitung inflow dan outflow setiap bulan
        for ($month = 1; $month <= 12; $month++) {
            $data = self::calculateMonthlyCashFlow($year, $month); // Memanggil fungsi yang menghitung cash flow
            $monthlyData['cash_inflow'][$month - 1] = $data['totals']['operating']; // Menggunakan total inflow
            $monthlyData['cash_outflow'][$month - 1] = abs($data['totals']['financing']); // Menggunakan total outflow
        }

        return $monthlyData;
    }

    // Fungsi public untuk menghitung cash flow untuk bulan tertentu
    public static function calculateMonthlyCashFlow($year, $month) {
        $data = [
            'totals' => [
                'operating' => 0,
                'financing' => 0,
            ],
        ];

        // Define account groups berdasarkan jenis aktivitas
        $account_groups = [
            'operating' => Account::whereHas('account_group', function ($query) {
                $query->where('activity_type', 'Operating');
            })->get(),
            'financing' => Account::whereHas('account_group', function ($query) {
                $query->where('activity_type', 'Financing');
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
                if ($group_key == 'operating') {
                    $data['totals']['operating'] += $balance;
                } elseif ($group_key == 'financing') {
                    $data['totals']['financing'] += $balance;
                }
            }
        }

        return $data; // Mengembalikan hasil perhitungan
    }

}
