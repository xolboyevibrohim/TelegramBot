<?php

namespace App\Http\Controllers;

use Telegram\Bot\Api;
use Telegram\Bot\Keyboard\Keyboard;

class TgController extends Controller
{
        public function webhook()
        {
        $telegram = new Api('6191706706:AAFPTPb1P2tlD7HG3inMhG0mI3pmvTdRh4U');
            $info = $telegram->getWebhookUpdate();
//            $lname = $info['message']['chat']['last_name'];
//            $fname = $info['message']['chat']['first_name'];
            $chat_id = $info['message']['chat']['id'];
            $text = $info['message']['text'];
            if ($text == '/start') {
                $keyboard = Keyboard::inlineButton(['text'=>'Отправите номер телефона','request_contact' => true]);

                $response = $telegram->sendMessage([
                    'chat_id' => 'CHAT_ID',
                    'text' => 'Hello World',
                    'reply_markup' => $keyboard
                ]);
                return response()->json(['success' => 1]);
            } elseif (isset($info['message']['entities']) && $info['message']['entities'][0]['type'] == 'phone_number') {
                $text = $this->sendSms($text);
            } else {
                $text = "Botdan foydalanish uchun /start tugmasini bosing----$info";
            }
            $params['chat_id'] = $chat_id;
            $params['text'] = $text;
            $telegram->sendMessage($params);
            return response()->json(['success' => 1]);
        }
        public function sendSms($phone)
        {
            $phone_num = substr($phone, 1, 12);
            // $client = ApplicationCards::where([['phone',$phone_num],['is_verify',1]])->first();
            $client = false;
            if ($client) {
                $code = rand(1000, 9999);
                $mes = "N-Qulay botni faollashtirish uchun kod: $code";
                $sms = (new SmsService())->sendSms($phone, $mes);
                if (isset($sms['success'])) {
                    // bazaga kodni saqlash
                    $message = "$phone raqamiga sms kod yubordik, Iltimos kodni yuboring";
                } else {
                    $message = "sms yuborishda xatolik yuz berdi. Iltimos telefon raqamingizni qayta yuboring";
                }
            } else {
                $message = "$phone raqamidan kredit uchun ariza berilmagan!!!";
            }
            return $message;
        }
    }


