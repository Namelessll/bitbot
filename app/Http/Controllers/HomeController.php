<?php

namespace App\Http\Controllers;

use App\bot_settings;
use App\Models\LogicModel;
use App\Models\SettingModel;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public $keyboard = [
        ['💰 Мой кошелек', '💸 Получить бонус'],
        ['👫 Пригласить друзей', '🗣 Задать вопрос']
    ];

    public function getHomepage()
    {
        $settingsModel = new SettingModel();
        $data['settings'] = $settingsModel->getSettins();

        return view('home', $data);
    }

    public function setSetting(Request $request) {
        $settingsModel = new SettingModel();
        $settingsModel->setSettings($request->all()['url']);

        return redirect()->back()->with('status', 'Настройка обновлена');
    }

    public function getBotSettings() {
        $botSettings = new bot_settings();
        $data['settings'] = $botSettings->getSettings()[0];

        return view('settings', $data);
    }

    public function getStatistic() {
        $botSettings = new bot_settings();
        $data['users'] = $botSettings->getUsers();

        return view('statistic', $data);
    }


    public function setWebhook(Request $request) {
        $settingsModel = new SettingModel();
        $url = $settingsModel->getSettins()->value;

        $result = Telegram::setWebhook([
            'url' => $url . '/944214855:AAF_Cd4MwxoFiCd0_i8Gkl_gcCmRcWs8cq8/webhook'
        ]);


        $status = Telegram::getWebhookInfo();

        //return response()->view('home', $status, 200);
        return redirect()->back()->with('status', (string) $status);
    }

    public function removeWebhook(Request $request) {
        $response = Telegram::removeWebhook();

        return redirect()->back()->with('status', (string) $response);
    }

    public function getWebhookUpdates(Request $request) {
        $logicModel = new LogicModel();
        $paramsModel = new bot_settings();
        $botParams = $paramsModel->getSettings()[0];

        if (!$logicModel->checkUser($request['message']['from']['id'])) {
            if (stristr($request['message']['text'], '/start')) {
                $arInvite = explode(' ', $request['message']['text']);
                if (count($arInvite) > 1)
                    $invite = $arInvite[1];
                else
                    $invite = 0;

                Telegram::sendMessage([
                    'chat_id' => $request['message']['from']['id'],
                    'text' => 'Добро пожаловать, чтобы завершить регистрацию, решите пример:' . chr(10) . chr(10) . '<b>' . $botParams->Registration_question . '</b>',
                    'parse_mode' => 'HTML'
                ]);

                $user = [
                    'id' => $request['message']['from']['id'],
                    'username' => $request['message']['from']['first_name'],
                    'inviteId' => $invite
                ];

                $logicModel->addUser($user);
            }
        } else {

            if ($logicModel->getBlockUserField($request['message']['from']['id'])->ban == 2) {
                if ($request['message']['text'] != $botParams->Registration_answer) {
                    Telegram::sendMessage([
                        'chat_id' => $request['message']['from']['id'],
                        'text' => '💢 Ответ неверный, попробуйте снова:' . chr(10) . chr(10) . '<b>' . $botParams->Registration_question . '</b>',
                        'parse_mode' => 'HTML'
                    ]);
                } else {
                    $reply_markup =  Keyboard::make([
                        'keyboard' => $this->keyboard,
                        'resize_keyboard' => true,
                        'one_time_keyboard' => true
                    ]);

                    Telegram::sendMessage([
                        'chat_id' => $request['message']['from']['id'],
                        'text' => '☑️ Аккаунт подтвержден!',
                        'parse_mode' => 'HTML',
                        'reply_markup' => $reply_markup
                    ]);

                    $logicModel->updateUserField($request['message']['from']['id'], 'ban', 0);
                }
            } elseif ($logicModel->getBlockUserField($request['message']['from']['id'])->ban == 1) {
                Telegram::sendMessage([
                    'chat_id' => $request['message']['from']['id'],
                    'text' => '🚫 Ваш аккаунт заблокирован!'
                ]);
            } else {
                Telegram::sendMessage([
                    'chat_id' => $request['message']['from']['id'],
                    'text' => $request['message']['text']
                ]);
            }

        }

        //return redirect()->back()->with('status', (string) $request);
    }



}
