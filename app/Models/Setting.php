<?php

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function init() {
        $user = Auth::user();
        $setting = self::get()->first();
        if(Auth()->check()) {
            $setting->user = $user;
            $setting->permissions = Permission::where("role_id", $setting->user->role_id)->with('menu')->get();
            $setting->list_of_permission = collect($setting->permissions)
                ->pluck('menu.route')
                ->toArray();
        }
        return $setting;
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
