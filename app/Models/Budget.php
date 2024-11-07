<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($budget) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Budget '{$budget->description}' was created.",
            ]);
        });

        static::updated(function ($budget) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Budget '{$budget->description}' was updated.",
            ]);
        });

        static::deleted(function ($budget) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Budget '{$budget->description}' was deleted.",
            ]);
        });
    }

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
