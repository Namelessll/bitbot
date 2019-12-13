<?php


Auth::routes();
Route::get('/', function () {
    return view('welcome');
});

Route::post('/944214855:AAF_Cd4MwxoFiCd0_i8Gkl_gcCmRcWs8cq8/webhook', 'HomeController@getWebhookUpdates')->name('getWebhookUpdates');

Route::group(['middleware' => 'auth'], function () {
    Route::post('/setwebhook', 'HomeController@setWebhook')->name('setWebhook');
    Route::post('/removewebhook', 'HomeController@removeWebhook')->name('removeWebhook');
    Route::post('/setsettings', 'HomeController@setSetting')->name('setSetting');

    Route::get('/bot/server', 'HomeController@getHomepage')->name('getHomepage');
    Route::get('/bot/settings', 'HomeController@getBotSettings')->name('getBotSettings');
    Route::get('/bot/statistic', 'HomeController@getStatistic')->name('getStatistic');

    Route::post('/bot/settings/save', 'BotSettingsController@saveSettings')->name('saveSettings');
});

