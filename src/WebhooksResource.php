<?php

namespace D4veR\Replicate;

use D4veR\Replicate\Data\WebhookSecretData;
use D4veR\Replicate\Exceptions\TypeException;
use D4veR\Replicate\Requests\GetWebhookSecret;


class WebhooksResource extends Resource
{
    /**
     * @param  string  $id
     * 
     * @throws TypeException
     */
    public function secret(): string
    {
        $request = new GetWebhookSecret();
        $response = $this->connector->send($request);

        $data = $response->dtoOrFail();
        if (! $data instanceof WebhookSecretData) {
            throw new TypeException();
        }

        return $data->key;
    }

    public function verify($request, $secret): bool
    {
        return VerifyWebhook::verify($request, $secret);
    }
}
