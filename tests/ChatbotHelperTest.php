<?php

namespace Tests;

use App\ChatbotHelper;
use PHPUnit\Framework\TestCase;

class ChatbotHelperTest extends TestCase
{
    /**
     * @test
     **/
    public function it_detects_the_messenger()
    {
        // Given
        $chatbotHelper = new ChatbotHelper();
        $fbRequestArray = [
            'entry' => [
                [
                    'messaging' => [
                        [
                            'message' => [
                                'text' => 'FB message',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $fbWebhookRequest = [
            'hub_challenge' => [],
        ];

        $twitterWebhookRequest = ['message' => ['from' => '1234']];

        // When
        $messenger1 = $chatbotHelper->detectMessenger($fbRequestArray);
        $messenger2 = $chatbotHelper->detectMessenger($fbWebhookRequest);
        $messenger3 = $chatbotHelper->detectMessenger($twitterWebhookRequest);

        // Then
        $this->assertEquals('facebook', $messenger1);
        $this->assertEquals('facebook-verify-webhook', $messenger2);
        $this->assertEquals('telegram', $messenger3);
    }
}