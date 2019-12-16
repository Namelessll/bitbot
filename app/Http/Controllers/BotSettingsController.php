<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\bot_settings;

class BotSettingsController extends Controller
{
    public function saveSettings(Request $request) {
        //dd($request->all());
        $botSettings = new bot_settings();
        $botSettings->saveSettings($request->all());

        return redirect()->back()->with('status', 'Настройки бота сохранены');
    }


}
