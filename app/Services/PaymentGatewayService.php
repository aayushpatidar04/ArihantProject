<?php

namespace App\Services;

use App\Models\EventRegistration;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentGatewayService
{
    protected string $gateway;
    protected string $keyId;
    protected string $keySecret;
    protected string $apiUrl;

    public function __construct()
    {
        $this->gateway = config('services.payment.gateway', 'razorpay');
        $this->keyId = config('services.payment.key_id');
        $this->keySecret = config('services.payment.key_secret');
        $this->apiUrl = config('services.payment.api_url', 'https://api.razorpay.com/v1');
    }

    /**
     * Create an order for the registration.
     * Existing clients: ₹299 | New users: ₹999
     */
    public function createOrder(EventRegistration $registration): ?array
    {
        $amount = $registration->is_existing_client ? 29900 : 99900; // paise

        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->post("{$this->apiUrl}/orders", [
                    'amount' => $amount,
                    'currency' => 'INR',
                    'receipt' => $registration->registration_number,
                    'notes' => [
                        'registration_id' => $registration->id,
                        'email' => $registration->email,
                        'phone' => $registration->phone,
                        'client_type' => $registration->is_existing_client ? 'existing' : 'new',
                    ],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                Payment::create([
                    'event_registration_id' => $registration->id,
                    'gateway' => $this->gateway,
                    'gateway_order_id' => $data['id'],
                    'amount' => $amount / 100,
                    'currency' => 'INR',
                    'status' => 'created',
                ]);
                return $data;
            }

            Log::error('Payment order creation failed: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('Payment gateway exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verify payment signature (Razorpay standard).
     */
    public function verifySignature(array $payload): bool
    {
        $generated = hash_hmac('sha256', $payload['order_id'] . '|' . $payload['payment_id'], $this->keySecret);
        return hash_equals($generated, $payload['signature']);
    }

    /**
     * Fetch payment details from gateway.
     */
    public function fetchPayment(string $paymentId): ?array
    {
        try {
            $response = Http::withBasicAuth($this->keyId, $this->keySecret)
                ->get("{$this->apiUrl}/payments/{$paymentId}");
            return $response->successful() ? $response->json() : null;
        } catch (\Exception $e) {
            Log::error('Fetch payment failed: ' . $e->getMessage());
            return null;
        }
    }
}
