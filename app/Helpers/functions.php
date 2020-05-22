<?php

function getAlpha() {
    return [
        'А',
        'Б',
        'В',
        'Г',
        'Д',
        'Е',
        'Ж',
        'З',
        'И',
        'Й',
        'К',
        'Л',
        'М',
        'Н',
        'П',
        'Р',
        'С',
        'Т',
        'О',
        'У',
        'Ф',
        'Х',
        'Ц',
        'Ч',
        'Ш',
        'Щ',
        'Ь',
        'Ъ',
        'Э',
        'Ю',
        'Я'
    ];
}

function telegram_log($data)
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