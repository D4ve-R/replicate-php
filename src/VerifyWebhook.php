<?php

namespace D4veR\Replicate;

use Psr\Http\Message\RequestInterface;

final class VerifyWebhook 
{
    private function __construct() {}

    public static function verify(RequestInterface $request, string $secret): bool
    {
        // https://replicate.com/docs/topics/webhooks/verify-webhook
        $id = $request->getHeaderLine('webhook-id');
        $timestamp = $request->getHeaderLine('webhook-timestamp');
        $body = $request->getBody()->getContents();
        $payload = $id . $timestamp . $body;
        $expected = hash_hmac('sha256', $payload, explode('_', $secret)[1]);

        // list of (version,signature), separated by a space
        $signatures = explode(' ', $request->getHeaderLine('webhook-signature'));
        foreach ($signatures as $signature) {
            // check if at least one signature matches
            if (hash_equals($expected, explode(',', $signature)[1])) {
                return true;
            }
        }
        
        return false;
    }
}
