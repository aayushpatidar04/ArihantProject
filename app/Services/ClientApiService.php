<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ClientApiService
{
    public function checkClient(string $phone): ?array
    {
        $url = config('services.arihant_client.url');
        $auth = config('services.arihant_client.auth');

        if (empty($url)) {
            return null;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $auth,
                'X-ENCRYPT' => 'false',
                'Content-Type' => 'application/json',
            ])->post($url, [
                'request' => [
                    'data' => [
                        'mobNo' => $phone,
                    ],
                ],
            ]);

            if (!$response->successful()) {
                Log::error('Client API HTTP error: ' . $response->body());
                return null;
            }

            $json = $response->json();

            // Not found
            if (($json['response']['infoID'] ?? '') !== '0') {
                return null;
            }

            $users = $json['response']['data']['userDetails'] ?? [];

            if (empty($users)) {
                return null;
            }

            return [
                'is_client' => true,
                'users' => $users, // array of ['uid' => '...', 'uName' => '...']
            ];

        } catch (\Exception $e) {
            Log::error('Client API exception: ' . $e->getMessage());
            return null;
        }
    }
}