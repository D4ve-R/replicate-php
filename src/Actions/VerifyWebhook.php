<?php

namespace D4veR\Replicate\Actions;

use Illuminate\Http\Request;

class VerifyWebhook 
{
    public function verify(Request $request, string $secret): bool
    {
        // https://replicate.com/docs/topics/webhooks/verify-webhook
        $id = $request->header('webhook-id');
        $timestamp = $request->header('webhook-timestamp');
        $body = $request->getContent();
        $payload = $id . '.' . $timestamp . '.' . $body;
        $expected = hash_hmac('sha256', $payload, explode('_', $secret)[1]);

        // list of (version,signature), separated by a space
        $signatures = explode(' ', $request->header('webhook-signature'));
        foreach ($signatures as $signature) {
            // check if at least one signature matches
            if (hash_equals($expected, explode(',', $signature)[1])) {
                return true;
            }
        }
        
        return false;
    }
}
