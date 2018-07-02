<?php

namespace App;

class FacebookMessage implements Message
{

    /** @var string */
    protected $message;

    /** @var string */
    protected $recipient;

    /** @var string */
    protected $apiEndpoint;

    public function __construct(string $message, string $recipient)
    {
        $this->message = $message;
        $this->recipient = $recipient;
        $this->apiEndpoint = 'https://graph.facebook.com/v3.0/me/messages?access_token='.getenv('FACEBOOK_PAGE_ACCESS_TOKEN');

    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function toArray()
    {
        return [
            'messaging_type' => 'RESPONSE',
            'recipient' => [
                'id' => $this->recipient,
            ],
            'message' => [
                'text' => $this->message,
            ],
        ];
    }

}