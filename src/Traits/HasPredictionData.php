<?php

namespace D4veR\Replicate\Traits;

use D4veR\Replicate\Data\PredictionData;
use D4veR\Replicate\Exceptions\InvalidDataException;
use Saloon\Http\Response;


trait HasPredictionData
{
    public function createDtoFromResponse(Response $response): PredictionData
    {
        return $this::fromResponse($response);
    }

    protected static function fromResponse(Response $response): PredictionData
    {
        $data = $response->json();
        if (!is_array($data)) {
            throw new InvalidDataException('Invalid response');
        }

        return new PredictionData(
            id: $data['id'],
            version: $data['version'],
            createdAt: $data['created_at'],
            completedAt: $data['completed_at'] ?? null,
            startedAt: $data['started_at'] ?? null,
            status: $data['status'],
            webhookCompleted: $data['webhook_completed'] ?? null,
            input: $data['input'],
            metrics: $data['metrics'] ?? null,
            urls: $data['urls'],
            error: $data['error'] ?? null,
            output: $data['output'] ?? null,
        );
    }
}