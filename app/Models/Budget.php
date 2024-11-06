<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account(){
        return $this->belongsTo(Account::class);
    }

    public function journal_entry(){
        return $this->hasMany(JournalEntry::class);
    }

    public static function updateBalance($budget_id, $spent) {
        $budget = self::whereId($budget_id)->get()->last();
        $new_spent = $budget->spent + $spent;
        $new_left = $budget->amount - $new_spent;
        Budget::whereId($budget_id)->update([
            "spent" => $new_spent,
            "left" => $new_left,
        ]);
    }
}
