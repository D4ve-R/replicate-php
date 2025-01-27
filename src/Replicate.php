<?php

declare(strict_types=1);

namespace D4veR\Replicate;

use Saloon\Http\Connector;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;


class Replicate extends Connector
{

    use AlwaysThrowOnErrors;
    use HasTimeout;

    public function __construct(
        protected readonly string $apiToken,
        protected readonly string $baseUrl = 'https://api.replicate.com/v1',
        protected int $requestTimeout = 60,
    ) 
    {
        //
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

    public function setTimeout(int $timeout)
    {
        $this->requestTimeout = $timeout;
    }

    protected function defaultAuth(): TokenAuthenticator
    {
        return new TokenAuthenticator($this->apiToken);
    }

    public function predictions(): PredictionsResource
    {
        return new PredictionsResource($this);
    }

    public function webhooks(): WebhooksResource
    {
        return new WebhooksResource($this);
    }
}
