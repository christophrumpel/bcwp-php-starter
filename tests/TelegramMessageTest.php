<?php

namespace Tests;

use App\TelegramMessage;
use PHPUnit\Framework\TestCase;

class TelegramMessageTest extends TestCase
{
    /**
     * @test
     **/
    public function it_creates_an_instance()
    {
        // When
        $message = new TelegramMessage('hi', '1234');

        // Then
        $this->assertInstanceOf(TelegramMessage::class, $message);
    }

    /**
     * @test
     **/
    public function it_gets_api_endpoint()
    {
        // Given
        $message = new TelegramMessage('hi', '1234');

        // When
        $apiEndpoint = $message->getApiEndpoint();

        // Then
        $this->assertEquals('https://api.telegram.org/bot'.getenv('TELEGRAM_TOKEN').'/sendmessage', $apiEndpoint);
    }

    /**
     * @test
     **/
    public function it_create_array_of_message()
    {
        // Given
        $message = new TelegramMessage('hi', '1234');

        // When
        $messageArray = $message->toArray();

        // Then
        $array = [
            'chat_id' => '1234',
            'text' => 'hi',
        ];

        $this->assertEquals($array, $messageArray);
    }
}