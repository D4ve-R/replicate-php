<?php

declare(strict_types=1);

namespace BenBjurstrom\Replicate;

use Saloon\Http\Connector;

/**
 * @internal
 */
final class Replicate extends Connector
{
    public function __construct(
        public string $apiToken,
        public string $baseUrl = 'https://api.replicate.com/v1'
    ) {
        $this->withTokenAuth($this->apiToken, 'Token');
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function predictions(): PredictionsResource
    {
        return new PredictionsResource($this);
    }
}
