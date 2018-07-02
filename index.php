<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

$input = json_decode(file_get_contents('php://input'), true) ?? $_GET;
$log->info('Request: ', $input);

if (isset($input['hub_challenge'])) {

    $fbHubMode = $input['hub_mode'];
    $fbHubVerifyToken = $input['hub_verify_token'];
    $fbHubChallenge = $input['hub_challenge'];

    if ($fbHubMode === 'subscribe' && $fbHubVerifyToken === getenv('FACEBOOK_VERIFY_TOKEN')) {
        $log->info('Inside verify method');
        echo $fbHubChallenge;
    }

    exit;
}

if(isset($input['entry'][0]['messaging'][0]['message']['text'])) {
    // Message is from Facebook
    $url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.getenv('FACEBOOK_PAGE_ACCESS_TOKEN');
    $reply = [
        'messaging_type' => 'RESPONSE',
        'recipient' => [
            'id' => '1615290031920309',
        ],
        'message' => [
            'text' => 'This is a reply.',
        ],
    ];
} else {
    $url = 'https://api.telegram.org/bot'.getenv('TELEGRAM_TOKEN').'/sendmessage';
    $reply = [
        'chat_id' => '39310553',
        'text' => 'This is a reply',
    ];
}


$ch = curl_init($url);

// Tell cURL to send POST request.
curl_setopt($ch, CURLOPT_POST, 1);
// Attach JSON string to post fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($reply));
// Set the content type
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
// Execute
curl_exec($ch);
if (curl_error($ch)) {
    $this->log->warning('Curl error: '.curl_error($ch));
}
curl_close($ch);