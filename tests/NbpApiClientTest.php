<?php

use ApiNbpRatesPlugin\NbpApiClient;
use WP_Mock\Tools\TestCase;

/**
 * Simple test for the fetchGoldPrice method.
 * Verifies that the response code is 200 and the message is 'OK'.
 * If not, it indicates a failure in connecting to the API.
 */
class NbpApiClientTest extends TestCase {

    /**
     * Setup Mock tests
     */
    public function setUp(): void {
        WP_Mock::setUp();
    }

    public function tearDown(): void {
        WP_Mock::tearDown();
    }

    /**
     * Test fetchGoldPrice method
     */
    public function testFetchGoldPrice() {
        $mockedResponse = [
            'response' => [
                'code' => 200,
                'message' => 'OK'
            ],
            'body' => json_encode([
                [
                    'data' => '2024-09-13',
                    'cena' => '319.00'
                ]
            ])
        ];

        /**
         * checking the response call wp_remote_get
         */
        WP_Mock::userFunction('wp_remote_get', [
            'times' => 1,
            'args' => ['http://api.nbp.pl/api/cenyzlota'],
            'return' => $mockedResponse
        ]);

        /**
         * checking the response call is_wp_error
         */
        WP_Mock::userFunction('is_wp_error', [
            'times' => 1,
            'args' => [$mockedResponse],
            'return' => false
        ]);

        /**
         * checking the response call wp_remote_retrieve_body
         */
        WP_Mock::userFunction('wp_remote_retrieve_body', [
            'times' => 1,
            'args' => [$mockedResponse],
            'return' => $mockedResponse['body']
        ]);

        $client = new NbpApiClient();

        $result = $client->fetchGoldPrice();

        $this->assertNotFalse($result, 'Client connection failed');
    }
}
