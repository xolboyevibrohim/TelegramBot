<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TgController extends Controller
{
    public function webhook()
    {
        $telegram = new Api('5840109465:AAFofV7YKJrmKf4S3DRstgNMROhB5xC3wAM');
        $response = $telegram->getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();
        $params['chat_id']=787546517;
        $params['text']="Test uchun";
        $telegram->sendMessage($params);
        dd($botId,$firstName,$username,$response);
    }

    public function setWebhook()
    {
        $response = Telegram::setWebhook(['url' => 'https://back.bdk-stock/api/webhook']);
        dd($response);
    }
}
