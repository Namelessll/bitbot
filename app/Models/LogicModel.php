<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Carbon;

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
        DB::table('table_user_frame')
            ->insert([
                'userId' => $data['id'],
            ]);
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

    public function addToBalance($id, $value) {
        $balance = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.balance')
            ->get()[0];

        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->update([
                'balance' => $balance->balance + $value
            ]);
    }

    public function accessBalance($id) {
        $balance = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.balance')
            ->get()[0];

        return $balance->balance;
    }

    public function updateUserField($id, $field, $value) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->update([
                $field => $value
            ]);
    }

    public function getUserFrame($id) {
        return DB::table('table_user_frame')
            ->where('table_user_frame.userId', $id)
            ->select('table_user_frame.*')
            ->get();
    }

    public function getUserById($id) {
        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.*')
            ->get()[0];
    }

    public function updateUserFrame($id, $frame, $value) {
        return DB::table('table_user_frame')
            ->where('table_user_frame.userId', $id)
            ->update([
                $frame => $value
            ]);
    }

    public function addQuestion($id, $value) {
        return DB::table('table_questions')
            ->insert([
                'userId' => $id,
                'question' => $value,
                'status' => 0,
                'created_at' => Carbon::now()
            ]);
    }

    public function setMessageId($id, $params) {
        $count = DB::table('table_bonus')
            ->where('table_bonus.userId', $id)
            ->count();
        if ($count < 1) {
            return DB::table('table_bonus')
                ->insert([
                    'messageId' => $params['messageId'],
                    'userId' => $params['userId']
                ]);
        } else {
            DB::table('table_bonus')
                ->where('table_bonus.userId', $id)
                ->update([
                    'value' => $params['value'],
                    'dataLast' => $params['date']
                ]);
        }
        //
    }
}
