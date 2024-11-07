<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ActivityLog;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    protected static function booted()
    {
        static::created(function ($user) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "User '{$user->name}' was created.",
            ]);
        });

        static::updated(function ($user) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "User '{$user->name}' was updated.",
            ]);
        });

        static::deleted(function ($user) {
            ActivityLog::create([
                'user_id' => Auth()->user()->id,
                'description' => "User '{$user->name}' was deleted.",
            ]);
        });
    }
}
