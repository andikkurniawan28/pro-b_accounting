<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\Journal;
use App\Models\Setting;
use App\Models\Currency;
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
                'app_name' => 'Pro-B Accounting',
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

        AccountGroup::insert([
            ["name" => Str::title(str_replace('_', ' ', 'asset'))],                 // 1: Asset
            ["name" => Str::title(str_replace('_', ' ', 'liability'))],             // 2: Liability
            ["name" => Str::title(str_replace('_', ' ', 'equity'))],                // 3: Equity
            ["name" => Str::title(str_replace('_', ' ', 'revenue'))],               // 4: Revenue
            ["name" => Str::title(str_replace('_', ' ', 'cost_of_goods_sold'))],    // 5: Cost of Goods Sold (HPP)
            ["name" => Str::title(str_replace('_', ' ', 'expense'))],               // 6: Expense
            ["name" => Str::title(str_replace('_', ' ', 'other_income'))],          // 7: Other Income
            ["name" => Str::title(str_replace('_', ' ', 'other_expense'))],         // 8: Other Expense
            ["name" => Str::title(str_replace('_', ' ', 'contra_account'))],        // 9: Contra Account
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

        $accounts = Account::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        // Tanggal mulai dan tanggal akhir untuk rentang
        $startDate = Carbon::createFromDate(2024, 11, 1);
        $endDate = Carbon::createFromDate(2024, 11, 30);

        // Generate 100 journals
        for ($i = 1; $i <= 100; $i++) {
            // Tentukan nilai total debit dan kredit yang sama
            $totalAmount = rand(100000, 1000000);

            // Pilih tanggal acak dalam rentang yang ditentukan
            $journalDate = $startDate->copy()->addDays(rand(0, $endDate->diffInDays($startDate)));

            // Buat jurnal
            $journal = Journal::create([
                'user_id' => $users[array_rand($users)], // random user ID
                'code' => 'JN' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'date' => $journalDate,
                'debit' => $totalAmount,
                'credit' => $totalAmount,
                'is_closing_entry' => rand(0, 1),
            ]);

            // Hitung total debit dan kredit untuk journal entries
            $totalDebit = 0;
            $totalCredit = 0;

            // Buat beberapa entri jurnal (misalnya, 2-4 entri)
            $numEntries = rand(2, 4);
            for ($j = 1; $j <= $numEntries; $j++) {
                // Tentukan nilai acak untuk entri
                $entryAmount = rand(10000, $totalAmount / $numEntries);

                // Pilih apakah entri ini berada di debit atau credit
                if (rand(0, 1) === 0) { // 50% chance untuk debit
                    $entryDebit = $entryAmount;
                    $entryCredit = 0;
                } else { // 50% chance untuk credit
                    $entryDebit = 0;
                    $entryCredit = $entryAmount;
                }

                // Buat entri jurnal
                JournalEntry::create([
                    'journal_id' => $journal->id,
                    'account_id' => $accounts[array_rand($accounts)], // random account
                    'description' => 'Entry ' . $j . ' for ' . $journal->code,
                    'debit' => $entryDebit,
                    'credit' => $entryCredit,
                ]);

                // Update total debit dan kredit
                $totalDebit += $entryDebit;
                $totalCredit += $entryCredit;
            }

            // Update jurnal dengan total debit dan kredit dari entries
            $journal->update([
                'debit' => $totalDebit,
                'credit' => $totalCredit,
            ]);
        }

    }
}
