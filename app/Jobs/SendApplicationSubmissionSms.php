<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class SendApplicationSubmissionSms implements ShouldQueue
{
    use Queueable;

    public function __construct(public string $phoneNumber)
    {
    }

    public function handle(): void
    {
        $to = $this->formatMsisdn($this->phoneNumber);

        if ($to === null) {
            Log::warning('SMS not sent because phone number could not be normalized to MSISDN.', [
                'phone_number' => $this->phoneNumber,
            ]);

            return;
        }

        $baseUrl = (string) config('services.sms.base_url');
        $endpoint = (string) config('services.sms.single_sms_endpoint');
        $apiKey = (string) config('services.sms.api_key');
        $verifySsl = (bool) config('services.sms.verify_ssl', true);
        $caBundle = trim((string) config('services.sms.ca_bundle', ''));

        if ($apiKey === '') {
            Log::warning('SMS not sent because SMS_API_KEY is missing.');

            return;
        }

        $text = 'Asante, kwa kujisajili kushiriki maonyesho ya BIASHARA FORUM. Tafadhali, lipia package uliyochagua kupitia: CRDB Bank: 0150875721300 Jina la Akaunti: Voice Of Talent (VOT) Africa. Kwa maelezo zaidi, wasiliana nasi 0621666030';
        $reference = (string) Str::uuid();
        $payload = [
            'from' => (string) config('services.sms.sender_id', 'VOT AFRICA'),
            'to' => $to,
            'text' => $text,
            'flash' => (int) config('services.sms.flash', 0),
            'reference' => $reference,
        ];

        Log::info('Sending application submission SMS.', [
            'to' => $to,
            'base_url' => $baseUrl,
            'endpoint' => $endpoint,
            'reference' => $reference,
            'ssl_verify' => $verifySsl,
            'ca_bundle' => $caBundle !== '' ? $caBundle : null,
            'authorization' => 'Bearer '.$this->maskToken($apiKey),
            'payload' => $payload,
        ]);

        try {
            $request = Http::baseUrl($baseUrl)
                ->timeout((int) config('services.sms.timeout', 15))
                ->acceptJson()
                ->withToken($apiKey);

            if ($caBundle !== '') {
                $request = $request->withOptions(['verify' => $caBundle]);
            } elseif (! $verifySsl) {
                $request = $request->withoutVerifying();
            }

            $response = $request->post($endpoint, $payload);

            Log::info('SMS provider responded.', [
                'to' => $to,
                'reference' => $reference,
                'status' => $response->status(),
                'response' => $this->truncateForLog($response->body()),
            ]);

            $response->throw();
        } catch (RequestException $e) {
            Log::error('SMS provider request failed.', [
                'to' => $to,
                'reference' => $reference,
                'status' => $e->response?->status(),
                'response' => $this->truncateForLog($e->response?->body()),
                'error' => $e->getMessage(),
            ]);

            throw $e;
        } catch (Throwable $e) {
            Log::error('SMS job failed before provider response.', [
                'to' => $to,
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    private function formatMsisdn(string $phoneNumber): ?string
    {
        $digitsOnly = preg_replace('/\D+/', '', $phoneNumber) ?? '';

        if (strlen($digitsOnly) < 9) {
            return null;
        }

        $lastNine = substr($digitsOnly, -9);

        return '255'.$lastNine;
    }

    private function truncateForLog(?string $value, int $maxLength = 2000): ?string
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return strlen($value) > $maxLength
            ? substr($value, 0, $maxLength).'...[truncated]'
            : $value;
    }

    private function maskToken(string $token): string
    {
        $length = strlen($token);

        if ($length <= 8) {
            return str_repeat('*', $length);
        }

        return substr($token, 0, 4).str_repeat('*', $length - 8).substr($token, -4);
    }
}
