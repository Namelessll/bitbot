<?php


Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect('/bot/server');
});

Route::post('/944214855:AAF_Cd4MwxoFiCd0_i8Gkl_gcCmRcWs8cq8/webhook', 'HomeController@getWebhookUpdates')->name('getWebhookUpdates');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/setwebhook', 'HomeController@setWebhook')->name('setWebhook');
    Route::post('/removewebhook', 'HomeController@removeWebhook')->name('removeWebhook');
    Route::post('/setsettings', 'HomeController@setSetting')->name('setSetting');

    Route::get('/bot/server', 'HomeController@getHomepage')->name('getHomepage');
    Route::get('/bot/settings', 'HomeController@getBotSettings')->name('getBotSettings');
    Route::get('/bot/statistic', 'HomeController@getStatistic')->name('getStatistic');
    Route::get('/bot/questions', 'HomeController@getQuestions')->name('getQuestions');
    Route::get('/bot/mails', 'HomeController@getMailsPage')->name('getMailsPage');
    Route::get('/bot/payment/list', 'HomeController@getPaymentsList')->name('getPaymentsList');

    Route::post('/bot/payment/list/update', 'HomeController@updatePaymentList')->name('updatePaymentList');
    Route::post('/bot/mails/send', 'HomeController@sendMailToUsers')->name('sendMailToUsers');

    Route::post('/bot/questions/answer', 'HomeController@answerQuestion')->name('answerQuestion');

    Route::post('/bot/settings/save', 'BotSettingsController@saveSettings')->name('saveSettings');
});

