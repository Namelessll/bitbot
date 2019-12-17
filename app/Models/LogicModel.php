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

    public function addToInviteBalance($id, $value) {
        $balance = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.balance')
            ->get();


        if ($balance[0]->inviteId != 0) {
            $balanceInv = DB::table('table_bot_users')
                ->where('table_bot_users.telegramId', $balance[0]->inviteId)
                ->select('table_bot_users.balance')
                ->get()[0];

            return DB::table('table_bot_users')
                ->where('table_bot_users.telegramId', $balance[0]->inviteId)
                ->update([
                    'balance' => $balanceInv->balance + $value
                ]);
        } else {
            return false;
        }

    }

    public function removeToBalance($id, $value) {
        $balance = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.balance')
            ->get()[0];

        return DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->update([
                'balance' => $balance->balance - $value
            ]);
    }

    public function getUserBalance($id) {
        $balance = DB::table('table_bot_users')
            ->where('table_bot_users.telegramId', $id)
            ->select('table_bot_users.balance')
            ->get();

        return $balance;
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
                    'userId' => $params['userId'],
                    'dataLast' => $params['date']
                ]);
        } else {
            DB::table('table_bonus')
                ->where('table_bonus.userId', $id)
                ->update([
                    'messageId' => $params['messageId'],
                    'dataLast' => $params['date']
                ]);
        }
    }

    public function checkMessageDate($id) {
        $query = DB::table('table_bonus')
            ->where('table_bonus.userId', $id)
            ->get();
//2019-12-16 20:58:12
        if (isset($query[0])) {
            $item = $query[0];
            if (Carbon::parse($item->dataLast)->diffInMinutes(Carbon::now()) > 1440) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getLastMessageDate($id) {
        return DB::table('table_bonus')
            ->where('table_bonus.userId', $id)
            ->get();
    }

    public function setPaymentTransaction($params) {
        $count = DB::table('table_payment_requests')
            ->where('table_payment_requests.userId', $params['userId'])
            ->count();

        if ($count < 1) {
            return DB::table('table_payment_requests')
                ->insert([
                    'userId' => $params['userId'],
                    'value' => $params['value']
                ]);
        } else {
            return DB::table('table_payment_requests')
                ->where('table_payment_requests.userId', $params['userId'])
                ->update([
                    'btc' => $params['btc'],
                    'created_at' => Carbon::now()
                ]);
        }

    }

    public function getPaymentTransaction($id) {
        return DB::table('table_payment_requests')
            ->where('table_payment_requests.userId', $id)
            ->select('table_payment_requests.*')
            ->latest()
            ->first();
    }

    public function removePaymentTransaction($id) {
        return DB::table('table_payment_requests')
            ->where('table_payment_requests.userId', $id)
            ->delete();
    }

    public function setPaymentList($params) {
        return DB::table('table_payment_lists')
            ->insert([
                'userId' => $params['userId'],
                'value' => $params['value'],
                'btc' =>  $params['btc'],
                'created_at' => Carbon::now()
            ]);
    }

    public function getPaymentList() {
        return DB::table('table_payment_lists')
            ->select('table_payment_lists.*')
            ->get();
    }

    public function updatePayment($id, $status) {
        return DB::table('table_payment_lists')
            ->where('table_payment_lists.id', $id)
            ->update([
                'status' => $status
            ]);
    }

}
