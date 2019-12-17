<?php

namespace App\Http\Controllers;

use App\bot_settings;
use App\Models\LogicModel;
use App\Models\SettingModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Self_;
use Telegram\Bot\Api;
use Telegram;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Exceptions\TelegramResponseException;
use Telegram\Bot\HttpClients\GuzzleHttpClient;

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

    public $paymentKeyboard = [
        ['💸 Вывести', '🔙 Назад'],
    ];

    public $paymentKeyboardFrame = [
        ['🔙 Назад'],
    ];

    public $questionKeyboard = [
        ['🔙 Назад'],
    ];
    public static $bonusKeyboard = [];
    private static $_token = '944214855:AAF_Cd4MwxoFiCd0_i8Gkl_gcCmRcWs8cq8';
    public $bitcoin = 100000000;

    function __construct() {
        $paramsModel = new bot_settings();
        $botParams = $paramsModel->getSettings()[0];
        self::$bonusKeyboard =  [
            [['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)]],
            [['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)]],
            [['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)]],
            [['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)]],
            [['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)], ['text' => '🔲', 'callback_data' => rand($botParams->Random_sum_start * $this->bitcoin, $botParams->Random_sum_end * $this->bitcoin)]],
        ];
    }
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
        $data['settings'] = $botSettings->getSettings();

        return view('settings', $data);
    }

    public function getStatistic() {
        $botSettings = new bot_settings();
        $data['users'] = $botSettings->getUsers();

        return view('statistic', $data);
    }

    public function getQuestions() {
        $botSettings = new bot_settings();
        $data['questions'] = $botSettings->getQuestions();

        return view('questions', $data);
    }

    public function getMailsPage() {
        $botSettings = new bot_settings();

        return view('mails-page');
    }

    public function getPaymentsList() {
        $logicModel = new LogicModel();
        $data['payments'] = $logicModel->getPaymentList();
        return view('payments', $data);
    }

    public function updatePaymentList(Request $request) {
        $logicModel = new LogicModel();
        $logicModel->updatePayment($request->all()['id'], $request->all()['status']);
        if ($request->all()['status'] == 1) {
            Telegram::sendMessage([
                'chat_id' => $request->all()['userId'],
                'text' => "<b>✅ Ваша заявка была одобрена!</b>\n Сумма в " . $request->all()['value'] . " BTC, скоро поступит на ваш счет",
                'parse_mode' => 'HTML',
            ]);
        } elseif ($request->all()['status'] == 2) {
            Telegram::sendMessage([
                'chat_id' => $request->all()['userId'],
                'text' => "<b>❌ Ваша заявка была отклонена!</b>",
                'parse_mode' => 'HTML',
            ]);
        }
        return redirect()->back()->with('status', 'Статус заявки обновлен');
    }

    public function sendMailToUsers(Request $request) {
        $botSettings = new bot_settings();
        $users = $botSettings->getUsers();
        $mail = $request->all()['mail'];
        $success = 0;
        $errors = 0;


        foreach ($users as $user) {
            try {
                Telegram::sendMessage([
                    'chat_id' => $user->telegramId,
                    'text' => $mail,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true
                ]);
                $success++;
            } catch (TelegramResponseException $e) {
                $errorData = $e->getResponseData();
                if ($errorData['ok'] === false) {
                    $errors++;
                }

            }
        }
        return redirect()->back()->with('status', 'Сообщение отправлено. Успешно: ' . $success . ', С ошибкой: ' . $errors);
    }


    public function answerQuestion(Request $request) {
        $botSettings = new bot_settings();
        $data = $request->all();
        $botSettings->answerQuestion($data['ticket'], $data['userId']);

        Telegram::sendMessage([
            'chat_id' => $data['userId'],
            'text' => "#техподдержка\n\n" . $data['answerUser'],
            'parse_mode' => 'HTML'
        ]);

        return redirect()->back()->with('status', 'Сообщение отправлено пользователю ID:' . $data['userId']);
    }


    public function setWebhook(Request $request) {
        $settingsModel = new SettingModel();
        $url = $settingsModel->getSettins()->value;

        $result = Telegram::setWebhook([
            'url' => $url . '/' . self::$_token . '/webhook'
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

        if (isset($request['message']['text'])) {
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
                    if ($invite != 0)
                        $logicModel->addToBalance($invite, $botParams->Referal_sum);
                }
            }
            else {

                if ($logicModel->getBlockUserField($request['message']['from']['id'])->ban == 2) {
                    if ($request['message']['text'] != $botParams->Registration_answer) {
                        Telegram::sendMessage([
                            'chat_id' => $request['message']['from']['id'],
                            'text' => '💢 Ответ неверный, попробуйте снова:' . chr(10) . chr(10) . '<b>' . $botParams->Registration_question . '</b>',
                            'parse_mode' => 'HTML'
                        ]);
                    }
                    else {
                        $reply_markup =  Keyboard::make([
                            'keyboard' => $this->keyboard,
                            'resize_keyboard' => true,
                        ]);

                        Telegram::sendMessage([
                            'chat_id' => $request['message']['from']['id'],
                            'text' => "☑️ Аккаунт подтвержден!\nЗа регистрацию вам на баланс зачислено " . $botParams->Registration_sum * $this->bitcoin . " сатоши.",
                            'parse_mode' => 'HTML',
                        ]);
                        $params = [
                            'userId' => $request['message']['from']['id'],
                            'date' => '2019-12-01 21:00:01'
                        ];
                        $logicModel->setMessageId($request['message']['from']['id'], $params);
                        $logicModel->addToBalance($request['message']['from']['id'], $botParams->Registration_sum);

                        Telegram::sendMessage([
                            'chat_id' => $request['message']['from']['id'],
                            'text' => $botParams->Welcome_message,
                            'parse_mode' => 'HTML',
                            'reply_markup' => $reply_markup
                        ]);

                        $logicModel->updateUserField($request['message']['from']['id'], 'ban', 0);
                    }
                }
                elseif ($logicModel->getBlockUserField($request['message']['from']['id'])->ban == 1) {
                    Telegram::sendMessage([
                        'chat_id' => $request['message']['from']['id'],
                        'text' => '🚫 Ваш аккаунт заблокирован!'
                    ]);
                }
                else {
                    $userFrames = $logicModel->getUserFrame($request['message']['from']['id']);
                    if ($userFrames[0]->paymentFrame == 0 && $userFrames[0]->bonusFrame == 0 && $userFrames[0]->questionFrame == 0) {
                        /*Команда старт*/
                        if (stristr($request['message']['text'], '/start') || $request['message']['text'] == '🔙 Назад') {
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);

                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => $botParams->Welcome_message,
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'questionFrame', 0);
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'bonusFrame', 0);
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 0);

                        }
                        elseif ($request['message']['text'] == '🗣 Задать вопрос') {
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'questionFrame', 1);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->questionKeyboard,
                                'resize_keyboard' => true,
                            ]);
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => '📝 Напишите свой вопрос и мы скоро ответим вам.',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                        elseif ($request['message']['text'] == '👫 Пригласить друзей') {
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => "🎁 Зарабатывайте серьезные деньги приглашая друзей в бота. Каждый человек кто пришел в бота по вашей ссылке будет считаться вашим рефералом. \n\n💵Вознаграждения за рефералов:\n - " . $botParams->Referal_sum  * $this->bitcoin . " сатоши за каждого реферала, который пришел по вашей ссылке. \n - " . $botParams->Referal_procent . " % от каждого бонуса полученным вашим рефералом. \n\n<b>Ваша ссылка для приглашения:</b> https://t.me/bitcoinManinerr_bot?start=" . $request['message']['from']['id'],
                                'parse_mode' => 'HTML',
                            ]);
                        }
                        elseif ($request['message']['text'] == '💰 Мой кошелек') {
                            $user = $logicModel->getUserById($request['message']['from']['id']);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->paymentKeyboard,
                                'resize_keyboard' => true,
                            ]);
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => "<b>Мой профиль:</b>\nID: " . $user->telegramId . "\n\nБаланс: " . $user->balance * $this->bitcoin . " сатоши.\nВаши рефералы : " . $user->referalCount . "  человека.",
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                        elseif ($request['message']['text'] == '💸 Вывести') {
                            $balance = $logicModel->accessBalance($request['message']['from']['id']);
                            if ($balance > $botParams->Minimal_windrow_sum) {
                                $reply_markup =  Keyboard::make([
                                    'keyboard' => $this->paymentKeyboardFrame,
                                    'resize_keyboard' => true,
                                ]);

                                Telegram::sendMessage([
                                    'chat_id' => $request['message']['from']['id'],
                                    'text' => "💰 Введите сумму вывода в BTC\n\n<i>Например: 0.0002</i>",
                                    'parse_mode' => 'HTML',
                                    'reply_markup' => $reply_markup
                                ]);
                                $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 1);
                            } else {
                                $reply_markup =  Keyboard::make([
                                    'keyboard' => $this->keyboard,
                                    'resize_keyboard' => true,
                                ]);
                                Telegram::sendMessage([
                                    'chat_id' => $request['message']['from']['id'],
                                    'text' => "⚠ Недостаточно BTC для вывода\n\nМинимальная сумма вывода: <b>" . number_format($botParams->Minimal_windrow_sum, 4, ".", "") . " BTC</b>",
                                    'parse_mode' => 'HTML',
                                    'reply_markup' => $reply_markup
                                ]);
                            }
                        }
                        elseif ($request['message']['text'] == '💸 Получить бонус') {
                            $keyboard = array("inline_keyboard"=>self::$bonusKeyboard, 'one_time_keyboard' => true);
                            $keyboard = json_encode($keyboard);

                            if ($logicModel->checkMessageDate($request['message']['from']['id'])) {
                                $response = Telegram::sendMessage([
                                    'chat_id' => $request['message']['from']['id'],
                                    'text' => (string) 'Ты перешел в раздел "Получить бонус". Выбери один из квадратов и получи приз.',
                                    'reply_markup' => $keyboard
                                ]);
                                $params = [
                                    'messageId' => $response['message_id'],
                                    'userId' => $response['chat']['id'],
                                    'date' => Carbon::now()
                                ];
                                $logicModel->setMessageId($response['chat']['id'], $params);
                            } else {
                                $date = $logicModel->getLastMessageDate($request['message']['from']['id']);
                                if (isset($date[0])) {
                                     $answer = Carbon::parse($date[0]->dataLast)->addMinutes(1440)->diffAsCarbonInterval(Carbon::now())->locale('ru');
                                } else {
                                    $answer = 'Бонус недоступен';
                                }
                                Telegram::sendMessage([
                                    'chat_id' => $request['message']['from']['id'],
                                    'text' => "⏱ До следющего получения бонуса: <b>" . (string) $answer . "</b>",
                                    'parse_mode' => 'HTML',
                                ]);
                            }

                        }
                    }

                    if ($userFrames[0]->questionFrame == 1) {
                        if ($request['message']['text'] != '🔙 Назад') {
                            $logicModel->addQuestion($request['message']['from']['id'], $request['message']['text']);
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'questionFrame', 0);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => '❓ Ваш вопрос сохранен.',
                                'reply_markup' => $reply_markup
                            ]);
                        } else {
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'questionFrame', 0);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);

                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => $botParams->Welcome_message,
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                    }
                    elseif ($userFrames[0]->paymentFrame == 1) {
                        if ($request['message']['text'] != '🔙 Назад') {
                            if ((double)str_replace(',', '.', $request['message']['text'])) {
                                $sum = (double)str_replace(',', '.', $request['message']['text']);
                                $balanceAr = $logicModel->getUserBalance($request['message']['from']['id']);
                                if (isset($balanceAr[0])) {
                                    if ((double)$balanceAr[0]->balance < $sum) {
                                        Telegram::sendMessage([
                                            'chat_id' => $request['message']['from']['id'],
                                            'text' => '🚫 Ошибка. Недостаточно средств на балансе!',
                                            'parse_mode' => 'HTML'
                                        ]);
                                        $reply_markup =  Keyboard::make([
                                            'keyboard' => $this->keyboard,
                                            'resize_keyboard' => true,
                                        ]);
                                        Telegram::sendMessage([
                                            'chat_id' => $request['message']['from']['id'],
                                            'text' => $botParams->Welcome_message,
                                            'parse_mode' => 'HTML',
                                            'reply_markup' => $reply_markup
                                        ]);
                                        $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 0);
                                    } else {
                                        $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 2);
                                        $params = [
                                            'userId' => $request['message']['from']['id'],
                                            'value' => $sum
                                        ];
                                        $logicModel->setPaymentTransaction($params);
                                        Telegram::sendMessage([
                                            'chat_id' => $request['message']['from']['id'],
                                            'text' => '✅ Успех! Введите ваш BTC кошелек',
                                            'parse_mode' => 'HTML',
                                        ]);
                                    }
                                }
                            }
                            else {

                                    Telegram::sendMessage([
                                        'chat_id' => $request['message']['from']['id'],
                                        'text' => '🚫 Ошибка. Сообщение не возможно преобразовать в число!',
                                        'parse_mode' => 'HTML'
                                    ]);

                            }
                        }
                        else {
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 0);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);

                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => $botParams->Welcome_message,
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                    }
                    elseif ($userFrames[0]->paymentFrame == 2) {
                        if ($request['message']['text'] != '🔙 Назад') {
                            $params = [
                                'btc' => $request['message']['text'],
                                'userId' => $request['message']['from']['id'],
                            ];
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);
                            $logicModel->setPaymentTransaction($params);
                            $dataLogin = $logicModel->getPaymentTransaction($request['message']['from']['id']);
                            $logicModel->removeToBalance($request['message']['from']['id'], $dataLogin->value);
                            $paramsList = [
                                'btc' => $request['message']['text'],
                                'userId' => $request['message']['from']['id'],
                                'value' => $dataLogin->value
                            ];
                            $logicModel->setPaymentList($paramsList);
                            $logicModel->removePaymentTransaction($request['message']['from']['id']);
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 0);
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => '✅ Успех! Заявка на вывод оформлена',
                                'parse_mode' => 'HTML',
                            ]);
                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => $botParams->Welcome_message,
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                        else {
                            $logicModel->updateUserFrame($request['message']['from']['id'], 'paymentFrame', 0);
                            $logicModel->removePaymentTransaction($request['message']['from']['id']);
                            $reply_markup =  Keyboard::make([
                                'keyboard' => $this->keyboard,
                                'resize_keyboard' => true,
                            ]);

                            Telegram::sendMessage([
                                'chat_id' => $request['message']['from']['id'],
                                'text' => $botParams->Welcome_message,
                                'parse_mode' => 'HTML',
                                'reply_markup' => $reply_markup
                            ]);
                        }
                    }
                }
            }
        }
        elseif(isset($request['callback_query']))  {

            Telegram::editMessageText([
                'chat_id' => $request['callback_query']['message']['chat']['id'],
                'text' => "<b>Поздравляем!</b>\n\n 💸 Вы получили приз в размере: " . (string) $request['callback_query']['data'] . " сатоши",
                'message_id' => $request['callback_query']['message']['message_id'],
                'parse_mode' => 'HTML',
            ]);
            $logicModel->addToBalance($request['callback_query']['message']['chat']['id'], $request['callback_query']['data'] / $this->bitcoin);
            $logicModel->addToInviteBalance($request['callback_query']['message']['chat']['id'], ($request['callback_query']['data'] * ($botParams->Referal_procent / 100))  / $this->bitcoin);
        }


        //return redirect()->back()->with('status', (string) $request);
    }



}
