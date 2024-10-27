<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;
use App\Models\AccountGroup;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ["name" => ucwords(str_replace('_', ' ', 'admin'))],
            ["name" => ucwords(str_replace('_', ' ', 'user'))],
        ]);

        User::insert([
            ["name" => ucwords(str_replace('_', ' ', 'admin')), "email" => "admin@gmail.com", "password" => bcrypt("admin"), "is_active" => 1, "role_id" => 1],
            ["name" => ucwords(str_replace('_', ' ', 'user')), "email" => "user@gmail.com", "password" => bcrypt("user"), "is_active" => 1, "role_id" => 2],
        ]);

        AccountGroup::insert([
            ["name" => Str::title(str_replace('_', ' ', 'asset'))],       // 1: Asset
            ["name" => Str::title(str_replace('_', ' ', 'liability'))],   // 2: Liability
            ["name" => Str::title(str_replace('_', ' ', 'equity'))],      // 3: Equity
            ["name" => Str::title(str_replace('_', ' ', 'revenue'))],     // 4: Revenue
            ["name" => Str::title(str_replace('_', ' ', 'expense'))],     // 5: Expense
        ]);

        Account::insert([
            // Kelompok Akun Kas dan Setara Kas
            [
                'account_group_id' => 1, // Asset
                'name' => 'Kas',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'name' => 'Bank',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'name' => 'Deposito',
                'normal_balance' => 'Debit',
            ],
            // Kelompok Akun Piutang
            [
                'account_group_id' => 1, // Asset
                'name' => 'Piutang Usaha',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'name' => 'Piutang Lain-lain',
                'normal_balance' => 'Debit',
            ],
            // Kelompok Akun Hutang
            [
                'account_group_id' => 2, // Liability
                'name' => 'Hutang Usaha',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 2,
                'name' => 'Hutang Bank',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 2,
                'name' => 'Hutang Lain-lain',
                'normal_balance' => 'Credit',
            ],
            // Kelompok Akun Modal
            [
                'account_group_id' => 3, // Equity
                'name' => 'Modal Pemilik',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 3,
                'name' => 'Modal Saham',
                'normal_balance' => 'Credit',
            ],
            // Kelompok Akun Pendapatan
            [
                'account_group_id' => 4, // Revenue
                'name' => 'Pendapatan Penjualan',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 4,
                'name' => 'Pendapatan Jasa',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 4,
                'name' => 'Pendapatan Lain-lain',
                'normal_balance' => 'Credit',
            ],
        ]);
    }
}
