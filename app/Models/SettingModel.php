<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class SettingModel extends Model
{
    public function getSettins() {
        return DB::table('settings')
            ->select('settings.*')
            ->first();
    }

    public function setSettings($url) {
        $sett = DB::table('settings')
            ->select('settings.*')
            ->first();

        if ($sett) {
            return DB::table('settings')
                ->where('settings.id', $sett->id)
                ->update([
                    'value' => $url
                ]);
        } else {
            return DB::table('settings')
                ->insert([
                    'value' => $url
                ]);
        }
    }
}
