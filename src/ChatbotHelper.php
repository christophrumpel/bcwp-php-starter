<?php

namespace App;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ChatbotHelper
{
    public function detectMessenger(array $input)
    {
        if (isset($input['entry'][0]['messaging'][0]['message']['text'])) {
            $messenger = 'facebook';
        } elseif (isset($input['hub_challenge'])) {
            $messenger = 'facebook-verify-webhook';
        } elseif (isset($input['message']['from'])) {
            $messenger = 'telegram';
        } else {
            $messenger = false;
        }

        return $messenger;
    }

    public function verifyFacebookWebhook($input)
    {
        $fbHubMode = $input['hub_mode'];
        $fbHubVerifyToken = $input['hub_verify_token'];
        $fbHubChallenge = $input['hub_challenge'];

        if ($fbHubMode === 'subscribe' && $fbHubVerifyToken === getenv('FACEBOOK_VERIFY_TOKEN')) {
            echo $fbHubChallenge;
        }

        exit;
    }
}