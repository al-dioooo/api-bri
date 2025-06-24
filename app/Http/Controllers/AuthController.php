<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenerateOAuthSignatureRequest;
use App\Http\Requests\GenerateXSignatureRequest;
use App\Http\Requests\GenerateTokenRequest;
use App\Traits\AccessToken;
use App\Traits\Signature;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use Signature, AccessToken;

    public function token(GenerateTokenRequest $request)
    {
        $client_key = $request->input('client_key');
        // $timestamp = $request->input('timestamp');
        $timestamp = Carbon::now(config()->get('app.timezone'))->toIso8601String();

        $signature = $this->generateOAuthSignature($client_key, $timestamp);

        $get_token = $this->getAccessToken($client_key, $signature, $timestamp);

        if (@$get_token->code === 200) {
            $token = @$get_token->body->accessToken;

            $get_token->body->timestamp = $timestamp;

            return response()->json($get_token->body);
        } else {
            return response()->json($get_token->body, $get_token->code);
        }
    }

    public function oAuthSignature(GenerateOAuthSignatureRequest $request) {
        $client_key = $request->input('client_key');
        // $timestamp = Carbon::parse($request->input('timestamp'))->toIso8601String();
        $timestamp = Carbon::now(config()->get('app.timezone'))->toIso8601String();

        $signature = $this->generateOAuthSignature($client_key, $timestamp);

        return response()->json([
            'signature' => $signature,
            'timestamp' => $timestamp
        ]);
    }

    public function xSignature(GenerateXSignatureRequest $request)
    {
        $path = Str::start($request->input('path'), '/');
        $verb = $request->input('verb');
        $token = $request->input('token');
        $client_key = $request->input('client_key');
        $timestamp = $request->input('timestamp');
        $body = $request->input('body');

        $signature = $this->generateXSignature($path, $verb, $token, $timestamp, $client_key, $body);

        return response()->json([
            'signature' => $signature['signature'],
            'payload' => $signature['payload'],
        ]);
    }
}
