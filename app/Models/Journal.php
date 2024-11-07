<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($journal) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Journal '{$journal->code}' was created.",
            ]);
        });

        static::updated(function ($journal) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Journal '{$journal->code}' was updated.",
            ]);
        });

        static::deleted(function ($journal) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Journal '{$journal->code}' was deleted.",
            ]);
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function journal_entry(){
        return $this->hasMany(JournalEntry::class);
    }

    public static function generateCode()
    {
        $prefix = 'JRN';
        $date = date('Ymd');
        $lastJournal = self::whereDate('date', today())->latest('created_at')->first();
        $sequence = $lastJournal ? intval(substr($lastJournal->code, -4)) + 1 : 1;
        $sequence = str_pad($sequence, 4, '0', STR_PAD_LEFT);
        return "{$prefix}-{$date}-{$sequence}";
    }

}
