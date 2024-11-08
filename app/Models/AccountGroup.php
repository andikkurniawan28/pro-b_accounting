<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccountGroup extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "AccountGroup '{$account_group->name}' was created.",
            ]);
        });

        static::updated(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "AccountGroup '{$account_group->name}' was updated.",
            ]);
        });

        static::deleted(function ($account_group) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "AccountGroup '{$account_group->name}' was deleted.",
            ]);
        });
    }
}
