<?php

use App\ChatbotHelper;
use App\FacebookMessage;
use App\HttpClient;
use App\TelegramMessage;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once __DIR__.'/vendor/autoload.php';
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$log = new Logger('general');
$log->pushHandler(new StreamHandler('debug.log'));

$chatbotHelper = new ChatbotHelper();

$input = json_decode(file_get_contents('php://input'), true) ?? $_GET;
$log->info('Request: ', $input);

$messenger = $chatbotHelper->detectMessenger($input);

switch ($messenger) {
    case 'facebook':
        $reply = new FacebookMessage('This is a reply', '1615290031920309');
        break;
    case 'facebook-verify-webhook':
        $chatbotHelper->verifyFacebookWebhook($input);
        break;
    case 'telegram':
        $reply = new TelegramMessage('This is a reply', '39310553');
        break;
    default:
        $reply = false;
}

if ($reply) {
    $client = new HttpClient();
    $client->send($reply);
}
