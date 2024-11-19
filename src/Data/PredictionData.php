<?php

namespace BenBjurstrom\Replicate\Data;


final class PredictionData
{
    /**
     * @param  array<string, string|int|float>  $input
     * @param  array<string, string|int|float>  $metrics
     * @param  array<string, string>  $urls
     * @param  string|array<int, string>  $output
     * @param  null|array<string, string>  $error
     */
    public function __construct(
        public string $id,
        public string $version,
        public string $createdAt,
        public ?string $completedAt,
        public ?string $startedAt,
        public string $status,
        public ?bool $webhookCompleted,
        public array $input,
        public ?array $metrics,
        public array $urls,
        public array|string|null $error,
        public string|array|null $output,
    ) {
    }
}
