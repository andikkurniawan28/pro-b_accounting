<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function journal(){
        return $this->belongsTo(Journal::class);
    }

    public function account(){
        return $this->belongsTo(Account::class);
    }

    protected static function booted()
    {
        static::created(function ($journal_entry) {
            $normal_balance = $journal_entry->account->normal_balance;

            if($normal_balance == "Debit") {
                $spent = $journal_entry->debit - $journal_entry->credit;
            } else {
                $spent = $journal_entry->credit - $journal_entry->debit;
            }

            // Menambahkan filter untuk start_date dan end_date
            $budget = Budget::where('account_id', $journal_entry->account_id)
                        ->where('start_date', '<=', $journal_entry->journal->date)
                        ->where('end_date', '>=', $journal_entry->journal->date)
                        ->latest() // Mengambil budget terakhir jika ada lebih dari satu hasil
                        ->first();

            if($budget) {
                Budget::updateBalance($budget->id, $spent);
                $journal_entry->update(['budget_id' => $budget->id]);
            }
        });

        static::deleted(function ($journal_entry) {
            $normal_balance = $journal_entry->account->normal_balance;

            if($normal_balance == "Debit") {
                $spent = $journal_entry->debit - $journal_entry->credit;
            } else {
                $spent = $journal_entry->credit - $journal_entry->debit;
            }

            $spent = $spent * -1;

            // Menambahkan filter untuk start_date dan end_date
            $budget = Budget::where('account_id', $journal_entry->account_id)
                        ->where('start_date', '<=', $journal_entry->journal->date)
                        ->where('end_date', '>=', $journal_entry->journal->date)
                        ->latest() // Mengambil budget terakhir jika ada lebih dari satu hasil
                        ->first();

            if($budget) {
                Budget::updateBalance($budget->id, $spent);
                $journal_entry->update(['budget_id' => $budget->id]);
            }
        });
    }
}
