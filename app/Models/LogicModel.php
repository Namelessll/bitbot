<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class LogicModel extends Model
{
    public function checkUser($id) {
        $query = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->count();

        if ($query > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
            $table->bigIncrements('telegramId');
            $table->string('telegramUsername')->nullable();
            $table->float('balance')->default(0);
            $table->integer('referalCount')->default(0);
            $table->bigInteger('inviteId')->default(0);
            $table->boolean('ban')->default(0);
     */

    public function addUser($data) {
        return DB::table('table_bot_users')
            ->insert([
                'telegramId' => $data['id'],
                'telegramUsername' => $data['username'],
                'inviteId' => $data['inviteId'],
                'ban' => 2
            ]);
    }

    public function getBlockUserField($id) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.ban')
            ->get()[0];
    }

    public function updateUserField($id, $field, $value) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->update([
                $field => $value
            ]);
    }
}
