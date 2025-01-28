<?php

use D4veR\Replicate\Requests\GetWebhookSecret;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

test('get webhook secret endpoint', function () {
    $mockClient = new MockClient([
        GetWebhookSecret::class => MockResponse::fixture('getWebhookSecret'),
    ]);

    $connector = getConnector();
    $connector->withMockClient($mockClient);

    $request = new GetWebhookSecret();
    $response = $connector->send($request);

    /* @var PredictionData $data */
    $data = $response->dtoOrFail();

    expect($response->ok())
        ->toBeTrue()
        ->and($data->key)
        ->toBe('whsec_test_key');
});

