<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

$input = json_decode(file_get_contents('php://input'), true);
$log->info('Request: ', $input ?? []);

if (isset($_REQUEST['hub_challenge'])) {

    $fbHubMode = $_GET['hub_mode'];
    $fbHubVerifyToken = $_GET['hub_verify_token'];
    $fbHubChallenge = $_GET['hub_challenge'];

    if ($fbHubMode === 'subscribe' && $fbHubVerifyToken === getenv('FACEBOOK_VERIFY_TOKEN')) {
        $log->info('Inside verify method');
        echo $fbHubChallenge;
    }

    exit;
}

$telegramReply = [
    'chat_id' => '39310553',
    'text' => 'This is a reply',
];

$facebookReply = [
    'messaging_type' => 'RESPONSE',
    'recipient' => [
        'id' => '1615290031920309',
    ],
    'message' => [
        'text' => 'This is a reply.',
    ],
];

$url = 'https://graph.facebook.com/v2.6/me/messages?access_token='.getenv('FACEBOOK_PAGE_ACCESS_TOKEN');
//$url = 'https://api.telegram.org/bot'.getenv('TELEGRAM_TOKEN').'/sendmessage';
$ch = curl_init($url);

// Tell cURL to send POST request.
curl_setopt($ch, CURLOPT_POST, 1);
// Attach JSON string to post fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($facebookReply));
// Set the content type
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
// Execute
curl_exec($ch);
if (curl_error($ch)) {
    $this->log->warning('Curl error: '.curl_error($ch));
}
curl_close($ch);