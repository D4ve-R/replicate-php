<?php

namespace D4veR\Replicate\Data;

use Saloon\Http\Response;

final class WebhookSecretData
{
    public function __construct(
        readonly public string $key,
    ) {
    }

    public static function fromResponse(Response $response): self
    {
        $data = $response->json();
        return new self(
            key: $data['key'],
        );
    }
}
