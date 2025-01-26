<?php

namespace D4veR\Replicate;

use D4veR\Replicate\Data\PredictionData;
use D4veR\Replicate\Data\PredictionsData;
use D4veR\Replicate\Exceptions\TypeException;
use D4veR\Replicate\Requests\GetPrediction;
use D4veR\Replicate\Requests\GetPredictions;
use D4veR\Replicate\Requests\PostPrediction;

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
