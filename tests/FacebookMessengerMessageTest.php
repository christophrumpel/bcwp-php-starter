<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\FacebookMessage;

class FacebookMessengerMessageTest extends TestCase
{

    /**
     * @test
     **/
    public function it_creates_an_instance()
    {
        // When
        $message = new FacebookMessage('hi', '1234');

        // Then
        $this->assertInstanceOf(FacebookMessage::class, $message);
    }

    /**
     * @test
     **/
    public function it_gets_api_endpoint()
    {
        // Given
        $message = new FacebookMessage('hi', '1234');

        // When
        $apiEndpoint = $message->getApiEndpoint();

        // Then
        $this->assertEquals('https://graph.facebook.com/v3.0/me/messages?access_token='.getenv('FACEBOOK_PAGE_ACCESS_TOKEN'),
            $apiEndpoint);
    }

    /**
     * @test
     **/
    public function it_create_array_of_message()
    {
        // Given
        $message = new FacebookMessage('hi', '1234');

        // When
        $messageArray = $message->toArray();

        // Then
        $array = [
            'messaging_type' => 'RESPONSE',
            'recipient' => [
                'id' => '1234',
            ],
            'message' => [
                'text' => 'hi',
            ],
        ];
        $this->assertEquals($array, $messageArray);
    }

}