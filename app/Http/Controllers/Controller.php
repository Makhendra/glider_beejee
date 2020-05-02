<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function makeReport(Request $request)
    {
        $request->validate(['message' => 'required']);
        $email = $request->get('email', '');
        $message = $request->get('message');
        Report::create(compact('email', 'message'));
        $this->telegram_log(compact('email', 'message'));
        return back();
    }

    public function lk($title = 'Личный кабинет')
    {
        return view('lk', compact('title'));
    }

    public function telegram_log($data)
    {
        // http://amolsky.blogspot.com/2015/12/telegram-php.html
        // Это телеграмм токен для бота @LUbdEIk4CJd08wQPBot
        $_token = '958399018:AAGVBa-4GEdveJOdUAr2uAbAP9hdIWfrNjM';
        $chat = '228868196'; // Это чат
        $url = "https://api.telegram.org/bot$_token/sendMessage?chat_id=$chat";
        $content = json_encode(['text' => $data], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Content-type: application/json"]);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_exec($curl);
    }
}
