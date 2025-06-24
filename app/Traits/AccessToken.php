<?php

namespace App\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

trait AccessToken
{
    protected function getAccessToken($client_id, $signature, $timestamp)
    {
        $client = new Client();

        $base_url = env('SANDBOX_API_URL', "https://sandbox.partner.api.bri.co.id");

        try {
            $res = $client->post("{$base_url}/snap/v1.0/access-token/b2b", [
                'headers' => [
                    "Content-Type" => "application/json",
                    "X-TIMESTAMP" => $timestamp,
                    "X-CLIENT-KEY" => $client_id,
                    "X-SIGNATURE" => $signature
                ],

                'json' => [
                    "grantType" => "client_credentials"
                ]
            ]);

            return (object) [
                'body' => json_decode($res->getBody()->getContents()),
                'code' => $res->getStatusCode()
            ];
        } catch (ClientException $e) {
            return (object) [
                'body' => json_decode($e->getResponse()->getBody()->getContents()),
                'code' => $e->getCode()
            ];
        } catch (RequestException $e) {
            return (object) [
                'body' => json_decode($e->getResponse()->getBody()->getContents()),
                'code' => $e->getCode()
            ];
        }
    }
}
