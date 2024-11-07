<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function booted()
    {
        static::created(function ($role) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Role '{$role->name}' was created.",
            ]);
        });

        static::updated(function ($role) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Role '{$role->name}' was updated.",
            ]);
        });

        static::deleted(function ($role) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "Role '{$role->name}' was deleted.",
            ]);
        });
    }
}
