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
        $setting = self::get()->first();
        $permissions = Permission::where("role_id", Auth::user()->role_id)->with('menu')->get();
        $setting->permission = $permissions;
        /*
        $setting->permission =
        */

        return $setting;
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }
}
