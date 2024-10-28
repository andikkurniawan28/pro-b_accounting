<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Support\Str;
use App\Models\AccountGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Setting::insert([
            ["app_name" => "Pro-B Accounting", "company_name" => Str::title(str_replace('_', ' ', 'pg_kebon_agung'))],
        ]);

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
            // Cash and Cash Equivalents Accounts Group
            [
                'account_group_id' => 1, // Asset
                'code' => '101',
                'name' => 'Cash',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'code' => '102',
                'name' => 'Bank',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'code' => '103',
                'name' => 'Deposit',
                'normal_balance' => 'Debit',
            ],
            // Accounts Receivable Group
            [
                'account_group_id' => 1, // Asset
                'code' => '104',
                'name' => 'Accounts Receivable',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'code' => '105',
                'name' => 'Other Receivables',
                'normal_balance' => 'Debit',
            ],
            // Liabilities Accounts Group
            [
                'account_group_id' => 2, // Liability
                'code' => '201',
                'name' => 'Accounts Payable',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 2,
                'code' => '202',
                'name' => 'Bank Loan',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 2,
                'code' => '203',
                'name' => 'Other Liabilities',
                'normal_balance' => 'Credit',
            ],
            // Equity Accounts Group
            [
                'account_group_id' => 3, // Equity
                'code' => '301',
                'name' => 'Owner\'s Equity',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 3,
                'code' => '302',
                'name' => 'Share Capital',
                'normal_balance' => 'Credit',
            ],
            // Revenue Accounts Group
            [
                'account_group_id' => 4, // Revenue
                'code' => '401',
                'name' => 'Sales Revenue',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 4,
                'code' => '402',
                'name' => 'Service Revenue',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 4,
                'code' => '403',
                'name' => 'Other Revenue',
                'normal_balance' => 'Credit',
            ],
        ]);

    }
}
