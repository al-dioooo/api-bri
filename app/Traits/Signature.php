<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait Signature
{
    private function hashBody($data) {
        return Str::lower(hash('SHA256', $data));
    }

    protected function generateOAuthSignature($client_key, $timestamp)
    {
        $certificate = Storage::disk('local')->get('/certificate/privkey-bri-dev.pem');

        $string = "{$client_key}|{$timestamp}";

        openssl_sign($string, $signature, $certificate, "SHA256");

        $encoded_signature = base64_encode($signature);

        return $encoded_signature;
    }

    protected function generateXSignature($path, $verb, $token, $timestamp, $client_key, $body = null)
    {
        if (is_array($body)) {
            $encoded_body = json_encode($body, JSON_UNESCAPED_SLASHES);
            $hashed_body = $this->hashBody($encoded_body);
        } else {
            $encoded_body = '';
            $hashed_body = $this->hashBody($encoded_body);
        }

        $string = "{$verb}:{$path}:{$token}:{$hashed_body}:{$timestamp}";

        $signature = base64_encode(hash_hmac("SHA512", $string, $client_key, true));

        return [
            'signature' => $signature,
            'payload' => $string
        ];
    }
}
