<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class bot_settings extends Model
{
    public function getSettings() {
        return DB::table('bot_settings')
            ->where('bot_settings.id', 1)
            ->select('bot_settings.*')
            ->get();
    }

    public function getUsers() {
        return DB::table('table_bot_users')
            ->select('table_bot_users.*')
            ->paginate(16);
    }

    public function getSetting($key) {
        return DB::table('bot_settings')
            ->where('bot_settings.id', 1)
            ->select('bot_settings.' . $key)
            ->first();
    }

    public function saveSettings($data) {
        $req = DB::table('bot_settings')
            ->count();
        foreach ($data as $key => &$item) {
            if ($key!= 'Welcome_message' && $key!= '_token')
                $item = str_replace(',', '.', $item);
        }
        if ($req > 0) {
            return DB::table('bot_settings')
                ->where('bot_settings.id', 1)
                ->update([
                    'Registration_question' => $data['Registration_question'],
                    'Registration_answer' => $data['Registration_answer'],
                    'Welcome_message' => $data['Welcome_message'],
                    'Registration_sum' => $data['Registration_sum'],
                    'Minimal_windrow_sum' => $data['Minimal_windrow_sum'],
                    'Random_sum_start' => $data['Random_sum_start'],
                    'Random_sum_end' => $data['Random_sum_end'],
                    'Referal_sum' => $data['Referal_sum'],
                    'Referal_procent' => $data['Referal_procent'],
                ]);
        } else {
            return DB::table('bot_settings')
                ->insert([
                    'Registration_question' => $data['Registration_question'],
                    'Registration_answer' => $data['Registration_answer'],
                    'Welcome_message' => $data['Welcome_message'],
                    'Registration_sum' => $data['Registration_sum'],
                    'Minimal_windrow_sum' => $data['Minimal_windrow_sum'],
                    'Random_sum_start' => $data['Random_sum_start'],
                    'Random_sum_end' => $data['Random_sum_end'],
                    'Referal_sum' => $data['Referal_sum'],
                    'Referal_procent' => $data['Referal_procent'],
                ]);
        }
    }
}
