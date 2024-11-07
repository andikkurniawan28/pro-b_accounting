<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function account_group(){
        return $this->belongsTo(AccountGroup::class);
    }

    protected static function booted()
    {
        static::created(function ($account) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Account '{$account->code} - {$account->name}' was created.",
            ]);
        });

        static::updated(function ($account) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Account '{$account->code} - {$account->name}' was updated.",
            ]);
        });

        static::deleted(function ($account) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Account '{$account->code} - {$account->name}' was deleted.",
            ]);
        });
    }
}
