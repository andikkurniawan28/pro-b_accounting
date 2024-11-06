<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\Journal;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Permission;
use Illuminate\Support\Str;
use App\Models\AccountGroup;
use App\Models\JournalEntry;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Currency::insert([
            ['name' => 'Indonesian Rupiah', 'symbol' => 'Rp'],
            ['name' => 'US Dollar', 'symbol' => '$'],
            ['name' => 'Euro', 'symbol' => '€'],
            ['name' => 'British Pound', 'symbol' => '£'],
            ['name' => 'Japanese Yen', 'symbol' => '¥'],
            ['name' => 'Australian Dollar', 'symbol' => 'A$'],
            ['name' => 'Canadian Dollar', 'symbol' => 'C$'],
            ['name' => 'Swiss Franc', 'symbol' => 'CHF'],
            ['name' => 'Chinese Yuan', 'symbol' => '¥'],
            ['name' => 'Indian Rupee', 'symbol' => '₹'],
            ['name' => 'Mexican Peso', 'symbol' => 'MX$'],
            ['name' => 'Brazilian Real', 'symbol' => 'R$'],
            ['name' => 'South African Rand', 'symbol' => 'R'],
            ['name' => 'Russian Ruble', 'symbol' => '₽'],
            ['name' => 'South Korean Won', 'symbol' => '₩'],
            ['name' => 'Turkish Lira', 'symbol' => '₺'],
            ['name' => 'Singapore Dollar', 'symbol' => 'S$'],
            ['name' => 'Malaysian Ringgit', 'symbol' => 'RM'],
            ['name' => 'Philippine Peso', 'symbol' => '₱'],
            ['name' => 'Thai Baht', 'symbol' => '฿'],
            ['name' => 'Vietnamese Dong', 'symbol' => '₫'],
            ['name' => 'Saudi Riyal', 'symbol' => '﷼'],
            ['name' => 'United Arab Emirates Dirham', 'symbol' => 'د.إ'],
            ['name' => 'Hong Kong Dollar', 'symbol' => 'HK$'],
            ['name' => 'New Zealand Dollar', 'symbol' => 'NZ$'],
            ['name' => 'Norwegian Krone', 'symbol' => 'kr'],
            ['name' => 'Swedish Krona', 'symbol' => 'kr'],
            ['name' => 'Danish Krone', 'symbol' => 'kr'],
            ['name' => 'Egyptian Pound', 'symbol' => 'E£'],
            ['name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            ['name' => 'Pakistani Rupee', 'symbol' => '₨'],
            ['name' => 'Sri Lankan Rupee', 'symbol' => 'Rs'],
            ['name' => 'Chilean Peso', 'symbol' => 'CLP$'],
            ['name' => 'Peruvian Sol', 'symbol' => 'S/'],
            ['name' => 'Colombian Peso', 'symbol' => 'COP$'],
            ['name' => 'Argentine Peso', 'symbol' => 'ARS$'],
            ['name' => 'Kuwaiti Dinar', 'symbol' => 'KD'],
            ['name' => 'Qatari Riyal', 'symbol' => 'QR'],
            ['name' => 'Omani Rial', 'symbol' => '﷼'],
        ]);

        Setting::insert([
            [
                'app_name' => 'Pro-B',
                'company_name' => 'PT Kebon Agung',
                'company_phone' => '021-12345678',
                'company_email' => 'info@kebonagung.com',
                'company_street' => 'Jl. Raya Kebon Agung No.1',
                'company_city_and_province' => 'Malang, Jawa Timur',
                'company_country' => 'Indonesia',
                'currency_id' => 1,
                'thousand_separator' => '.',
                'decimal_separator' => ',',
                'locale_string' => 'id-ID',
            ]
        ]);

        Role::insert([
            ["name" => ucwords(str_replace('_', ' ', 'admin'))],
            ["name" => ucwords(str_replace('_', ' ', 'user'))],
        ]);

        User::insert([
            ["name" => ucwords(str_replace('_', ' ', 'admin')), "email" => "admin@gmail.com", "password" => bcrypt("admin"), "is_active" => 1, "role_id" => 1],
            ["name" => ucwords(str_replace('_', ' ', 'user')), "email" => "user@gmail.com", "password" => bcrypt("user"), "is_active" => 1, "role_id" => 2],
        ]);

        Menu::insert([
            ["name" => Str::title(str_replace('_', ' ', 'dashboard')), "route" => "dashboard"],
            ["name" => Str::title(str_replace('_', ' ', 'view_setting')), "route" => "setting.index"],
            ["name" => Str::title(str_replace('_', ' ', 'save_setting')), "route" => "setting.store"],
            ["name" => Str::title(str_replace('_', ' ', 'role_list')), "route" => "role.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_role')), "route" => "role.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_role')), "route" => "role.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_role')), "route" => "role.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_role')), "route" => "role.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_role')), "route" => "role.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'user_list')), "route" => "user.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_user')), "route" => "user.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_user')), "route" => "user.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_user')), "route" => "user.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_user')), "route" => "user.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_user')), "route" => "user.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'currency_list')), "route" => "currency.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_currency')), "route" => "currency.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_currency')), "route" => "currency.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_currency')), "route" => "currency.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_currency')), "route" => "currency.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_currency')), "route" => "currency.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'tax_rate_list')), "route" => "tax_rate.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_tax_rate')), "route" => "tax_rate.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_tax_rate')), "route" => "tax_rate.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_tax_rate')), "route" => "tax_rate.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_tax_rate')), "route" => "tax_rate.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_tax_rate')), "route" => "tax_rate.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'account_group_list')), "route" => "account_group.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_account_group')), "route" => "account_group.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_account_group')), "route" => "account_group.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_account_group')), "route" => "account_group.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_account_group')), "route" => "account_group.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_account_group')), "route" => "account_group.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'account_list')), "route" => "account.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_account')), "route" => "account.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_account')), "route" => "account.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_account')), "route" => "account.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_account')), "route" => "account.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_account')), "route" => "account.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'budget_list')), "route" => "budget.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_budget')), "route" => "budget.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_budget')), "route" => "budget.store"],
            ["name" => Str::title(str_replace('_', ' ', 'view_budget')), "route" => "budget.show"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_budget')), "route" => "budget.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'update_budget')), "route" => "budget.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_budget')), "route" => "budget.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'journal_list')), "route" => "journal.index"],
            ["name" => Str::title(str_replace('_', ' ', 'create_journal')), "route" => "journal.create"],
            ["name" => Str::title(str_replace('_', ' ', 'save_journal')), "route" => "journal.store"],
            ["name" => Str::title(str_replace('_', ' ', 'edit_journal')), "route" => "journal.edit"],
            ["name" => Str::title(str_replace('_', ' ', 'journal_detail')), "route" => "journal.show"],
            ["name" => Str::title(str_replace('_', ' ', 'update_journal')), "route" => "journal.update"],
            ["name" => Str::title(str_replace('_', ' ', 'delete_journal')), "route" => "journal.destroy"],
            ["name" => Str::title(str_replace('_', ' ', 'view_ledger')), "route" => "ledger.index"],
            ["name" => Str::title(str_replace('_', ' ', 'view_balance_sheet')), "route" => "balance_sheet.index"],
            ["name" => Str::title(str_replace('_', ' ', 'view_income_statement')), "route" => "income_statement.index"],
            ["name" => Str::title(str_replace('_', ' ', 'view_cash_flow')), "route" => "cash_flow.index"],
        ]);

        $menus = Menu::select(['id'])->orderBy('id')->get();
        foreach($menus as $menu){
            Permission::insert(['menu_id' => $menu->id, 'role_id' => 1]);
        }

        Permission::insert([
            ["menu_id" => 34, "role_id" => 2],
            ["menu_id" => 35, "role_id" => 2],
            ["menu_id" => 36, "role_id" => 2],
            ["menu_id" => 38, "role_id" => 2],
        ]);

        AccountGroup::insert([
            ["name" => Str::title(str_replace('_', ' ', 'asset')), "activity_type" => Str::title(str_replace('_', ' ', 'investing'))],                  // 1: Asset
            ["name" => Str::title(str_replace('_', ' ', 'liability')), "activity_type" => Str::title(str_replace('_', ' ', 'financing'))],              // 2: Liability
            ["name" => Str::title(str_replace('_', ' ', 'equity')), "activity_type" => Str::title(str_replace('_', ' ', 'financing'))],                 // 3: Equity
            ["name" => Str::title(str_replace('_', ' ', 'revenue')), "activity_type" => Str::title(str_replace('_', ' ', 'operating'))],                // 4: Revenue
            ["name" => Str::title(str_replace('_', ' ', 'cost_of_goods_sold')), "activity_type" => Str::title(str_replace('_', ' ', 'operating'))],     // 5: Cost of Goods Sold (HPP)
            ["name" => Str::title(str_replace('_', ' ', 'expense')), "activity_type" => Str::title(str_replace('_', ' ', 'operating'))],                // 6: Expense
            ["name" => Str::title(str_replace('_', ' ', 'other_income')), "activity_type" => Str::title(str_replace('_', ' ', 'operating'))],           // 7: Other Income
            ["name" => Str::title(str_replace('_', ' ', 'other_expense')), "activity_type" => Str::title(str_replace('_', ' ', 'operating'))],          // 8: Other Expense
            ["name" => Str::title(str_replace('_', ' ', 'contra_account')), "activity_type" => null],                                                   // 9: Contra Account (tidak termasuk dalam arus kas)
        ]);

        Account::insert([
            // Asset Accounts Group
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
            [
                'account_group_id' => 1,
                'code' => '104',
                'name' => 'Accounts Receivable',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'code' => '105',
                'name' => 'Inventory',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 1,
                'code' => '106',
                'name' => 'Prepaid Expenses',
                'normal_balance' => 'Debit',
            ],

            // Liability Accounts Group
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
                'name' => 'Accrued Expenses',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 2,
                'code' => '204',
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
            [
                'account_group_id' => 3,
                'code' => '303',
                'name' => 'Retained Earnings',
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
                'name' => 'Interest Revenue',
                'normal_balance' => 'Credit',
            ],

            // Cost of Goods Sold (HPP) Accounts Group
            [
                'account_group_id' => 5, // Cost of Goods Sold (HPP)
                'code' => '501',
                'name' => 'Cost of Goods Sold',
                'normal_balance' => 'Debit',
            ],

            // Expense Accounts Group
            [
                'account_group_id' => 6, // Expense
                'code' => '601',
                'name' => 'Salaries Expense',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 6,
                'code' => '602',
                'name' => 'Rent Expense',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 6,
                'code' => '603',
                'name' => 'Utilities Expense',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 6,
                'code' => '604',
                'name' => 'Depreciation Expense',
                'normal_balance' => 'Debit',
            ],

            // Other Income Accounts Group
            [
                'account_group_id' => 7, // Other Income
                'code' => '701',
                'name' => 'Interest Income',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 7,
                'code' => '702',
                'name' => 'Dividend Income',
                'normal_balance' => 'Credit',
            ],

            // Other Expense Accounts Group
            [
                'account_group_id' => 8, // Other Expense
                'code' => '801',
                'name' => 'Interest Expense',
                'normal_balance' => 'Debit',
            ],
            [
                'account_group_id' => 8,
                'code' => '802',
                'name' => 'Loss on Disposal of Assets',
                'normal_balance' => 'Debit',
            ],

            // Contra Account Group
            [
                'account_group_id' => 9, // Contra Account
                'code' => '901',
                'name' => 'Accumulated Depreciation',
                'normal_balance' => 'Credit',
            ],
            [
                'account_group_id' => 9,
                'code' => '902',
                'name' => 'Allowance for Doubtful Accounts',
                'normal_balance' => 'Credit',
            ],
        ]);


        // $accounts = Account::pluck('id')->toArray();
        // $users = User::pluck('id')->toArray();

        // // Generate 100 journals untuk setiap bulan di tahun 2024
        // for ($month = 1; $month <= 12; $month++) {
        //     // Tentukan tanggal mulai dan akhir untuk bulan tersebut
        //     $startDate = Carbon::create(2024, $month, 1);
        //     $endDate = $startDate->copy()->endOfMonth();

        //     for ($i = 1; $i <= 100; $i++) {
        //         // Tentukan nilai total debit dan kredit yang sama
        //         $totalAmount = rand(100000, 1000000);

        //         // Pilih tanggal acak dalam rentang yang ditentukan
        //         $journalDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));

        //         // Buat jurnal
        //         $journal = Journal::create([
        //             'user_id' => $users[array_rand($users)], // random user ID
        //             'code' => 'JN' . str_pad(($month - 1) * 100 + $i, 4, '0', STR_PAD_LEFT), // Code yang unik untuk setiap bulan
        //             'date' => $journalDate,
        //             'debit' => $totalAmount,
        //             'credit' => $totalAmount,
        //             'is_closing_entry' => rand(0, 1),
        //         ]);

        //         // Hitung total debit dan kredit untuk journal entries
        //         $totalDebit = 0;
        //         $totalCredit = 0;

        //         // Buat beberapa entri jurnal (misalnya, 2-4 entri)
        //         $numEntries = rand(2, 4);
        //         for ($j = 1; $j <= $numEntries; $j++) {
        //             // Tentukan nilai acak untuk entri
        //             $entryAmount = rand(10000, $totalAmount / $numEntries);

        //             // Pilih apakah entri ini berada di debit atau credit
        //             if (rand(0, 1) === 0) { // 50% chance untuk debit
        //                 $entryDebit = $entryAmount;
        //                 $entryCredit = 0;
        //             } else { // 50% chance untuk credit
        //                 $entryDebit = 0;
        //                 $entryCredit = $entryAmount;
        //             }

        //             // Buat entri jurnal
        //             JournalEntry::create([
        //                 'journal_id' => $journal->id,
        //                 'account_id' => $accounts[array_rand($accounts)], // random account
        //                 'description' => 'Entry ' . $j . ' for ' . $journal->code,
        //                 'debit' => $entryDebit,
        //                 'credit' => $entryCredit,
        //             ]);

        //             // Update total debit dan kredit
        //             $totalDebit += $entryDebit;
        //             $totalCredit += $entryCredit;
        //         }

        //         // Update jurnal dengan total debit dan kredit dari entries
        //         $journal->update([
        //             'debit' => $totalDebit,
        //             'credit' => $totalCredit,
        //         ]);
        //     }
        // }


    }
}
