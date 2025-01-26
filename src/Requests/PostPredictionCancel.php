<?php

namespace D4veR\Replicate\Requests;

use D4veR\Replicate\Traits\HasPredictionData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PostPredictionCancel extends Request implements HasBody
{
    use HasJsonBody;
    use HasPredictionData;

    protected Method $method = Method::POST;

    public function __construct(
        protected string $id,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return sprintf('/predictions/%s/cancel', $this->id);
    }
}
