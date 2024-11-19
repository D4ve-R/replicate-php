<?php

namespace BenBjurstrom\Replicate;

use BenBjurstrom\Replicate\Data\PredictionData;
use BenBjurstrom\Replicate\Data\PredictionsData;
use BenBjurstrom\Replicate\Exceptions\TypeException;
use BenBjurstrom\Replicate\Requests\GetPrediction;
use BenBjurstrom\Replicate\Requests\GetPredictions;
use BenBjurstrom\Replicate\Requests\PostPrediction;

class PredictionsResource extends Resource
{
    protected ?string $webhookUrl = null;

    /**
     * @var array<string>
     */
    protected ?array $webhookEvents;

    /**
     * @param  string|null  $cursor
     * 
     * @throws TypeException
     */
    public function list(?string $cursor = null): PredictionsData
    {
        $request = new GetPredictions();

        if ($cursor) {
            $request->query()->add('cursor', $cursor);
        }

        $response = $this->connector->send($request);
        $data = $response->dtoOrFail();
        if (! $data instanceof PredictionsData) {
            throw new TypeException();
        }

        return $data;
    }

    /**
     * @param  string  $id
     * 
     * @throws TypeException
     */
    public function get(string $id): PredictionData
    {
        $request = new GetPrediction($id);
        $response = $this->connector->send($request);

        $data = $response->dtoOrFail();
        if (! $data instanceof PredictionData) {
            throw new TypeException();
        }

        return $data;
    }

    /**
     * @param  array<string, float|int|string|null>  $input
     *
     * @throws TypeException
     */
    public function create(string $version, array $input): PredictionData
    {
        $request = new PostPrediction($version, $input);
        if ($this->webhookUrl) {
            // https://replicate.com/changelog/2023-02-10-improved-webhook-events-and-event-filtering
            $request->body()->merge([
                'webhook' => $this->webhookUrl,
                'webhook_events_filter' => $this->webhookEvents,
            ]);
        }

        $response = $this->connector->send($request);

        $data = $response->dtoOrFail();
        if (! $data instanceof PredictionData) {
            throw new TypeException();
        }

        return $data;
    }

    /**
     * @param  array<string>  $events
     */
    public function withWebhook(string $url, ?array $events = ['completed']): self
    {
        $this->webhookUrl = $url;
        $this->webhookEvents = $events;

        return $this;
    }
}
