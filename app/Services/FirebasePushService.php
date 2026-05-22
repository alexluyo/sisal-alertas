<?php

namespace App\Services;

use App\Models\DeviceToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FirebasePushService
{
    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function getAccessToken(): ?string
    {
        $path = storage_path('app/firebase/firebase-service-account.json');

        if (!file_exists($path)) {
            Log::error('No existe firebase-service-account.json en storage/app/firebase/');
            return null;
        }

        $serviceAccount = json_decode(file_get_contents($path), true);

        if (!$serviceAccount || empty($serviceAccount['client_email']) || empty($serviceAccount['private_key'])) {
            Log::error('El archivo firebase-service-account.json no tiene el formato correcto.');
            return null;
        }

        $now = time();

        $header = [
            'alg' => 'RS256',
            'typ' => 'JWT',
        ];

        $claimSet = [
            'iss' => $serviceAccount['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        $encodedHeader = $this->base64UrlEncode(json_encode($header));
        $encodedClaimSet = $this->base64UrlEncode(json_encode($claimSet));

        $signatureInput = $encodedHeader . '.' . $encodedClaimSet;

        openssl_sign(
            $signatureInput,
            $signature,
            $serviceAccount['private_key'],
            OPENSSL_ALGO_SHA256
        );

        $jwt = $signatureInput . '.' . $this->base64UrlEncode($signature);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);

        if (!$response->successful()) {
            Log::error('Error obteniendo access token Firebase', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        }

        return $response->json('access_token');
    }

    public function enviarATodos(string $titulo, string $mensaje, string $url = '/dashboard'): void
    {
        $this->enviarPorAnexo($titulo, $mensaje, $url, null);
    }

    public function enviarPorAnexo(string $titulo, string $mensaje, string $url = '/dashboard', $idAnexo = null): void
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return;
        }

        $serviceAccount = json_decode(
            file_get_contents(storage_path('app/firebase/firebase-service-account.json')),
            true
        );

        $projectId = $serviceAccount['project_id'] ?? 'sisal-e8016';

        $tokensQuery = DeviceToken::where('estado', 1);

        /*
        |--------------------------------------------------------------------------
        | Filtro por anexo
        |--------------------------------------------------------------------------
        | Si $idAnexo viene NULL, la alerta es para todo el distrito y se envía
        | a todos los dispositivos activos.
        |
        | Si $idAnexo tiene valor, la alerta se envía solo a los dispositivos
        | registrados para ese anexo.
        */
        if (!is_null($idAnexo)) {
            $tokensQuery->where('id_anexo', $idAnexo);
        }

        $tokens = $tokensQuery
            ->pluck('token')
            ->filter()
            ->unique()
            ->values();

        foreach ($tokens as $token) {

            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $token,

                        'notification' => [
                            'title' => $titulo,
                            'body' => $mensaje,
                        ],

                        'webpush' => [
                            'notification' => [
                                'icon' => url('/icons/icon-192.png'),
                                'badge' => url('/icons/icon-192.png'),
                            ],
                            'fcm_options' => [
                                'link' => url($url),
                            ],
                        ],
                    ],
                ]);

            if (!$response->successful()) {
                Log::error('Error enviando push Firebase', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'id_anexo' => $idAnexo,
                ]);
            }
        }
    }
}

