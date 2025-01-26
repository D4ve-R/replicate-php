<?php

namespace D4veR\Replicate\Requests;

use D4veR\Replicate\Traits\HasPredictionData;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

class PostPrediction extends Request implements HasBody
{
    use HasJsonBody;
    use HasPredictionData;

    protected Method $method = Method::POST;

    /**
     * @param  array<string, float|int|string|null>  $input
     */
    public function __construct(
        protected string $version,
        protected array $input,
    ) {
    }

    public function resolveEndpoint(): string
    {
        return '/predictions';
    }

    /**
     * @return array<string, array<string, float|int|string|null>|string>
     */
    protected function defaultBody(): array
    {
        return [
            'version' => $this->version,
            'input' => $this->input,
        ];
    }
}
