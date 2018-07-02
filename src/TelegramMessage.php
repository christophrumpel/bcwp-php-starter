<?php

namespace App;

class TelegramMessage implements Message {

    /** @var string  */
    protected $message;

    /** @var string */
    protected $chatId;

    /** @var string  */
    protected $apiEndpoint;


    public function __construct(string $message, string $chatId) {
        $this->message = $message;
        $this->chatId = $chatId;
        $this->apiEndpoint = 'https://api.telegram.org/bot'.getenv('TELEGRAM_TOKEN').'/sendmessage';
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function toArray()
    {
        return [
            'chat_id' => $this->chatId,
            'text' => $this->message
        ];
    }

}