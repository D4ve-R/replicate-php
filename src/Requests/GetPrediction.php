<?php

namespace BenBjurstrom\Replicate\Requests;

use BenBjurstrom\Replicate\Traits\HasPredictionData;
use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetPrediction extends Request
{

    use HasPredictionData;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/predictions/%s', $this->id);
    }
}
