<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentGatewayService $payment) {}

    /**
     * Webhook handler for payment gateway.
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();
        $secret = config('services.payment.webhook_secret');

        // Verify webhook signature if provided by gateway
        $signature = $request->header('X-Razorpay-Signature');
        if ($signature) {
            $expected = hash_hmac('sha256', json_encode($payload), $secret);
            if (!hash_equals($expected, $signature)) {
                return response()->json(['status' => 'invalid_signature'], 400);
            }
        }

        if (isset($payload['event']) && $payload['event'] === 'payment.captured') {
            $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
            if ($paymentEntity) {
                $payment = Payment::where('gateway_order_id', $paymentEntity['order_id'])->first();
                if ($payment && $payment->status !== 'paid') {
                    $payment->update([
                        'gateway_payment_id' => $paymentEntity['id'],
                        'status' => 'paid',
                        'gateway_response' => $payload,
                        'paid_at' => now(),
                    ]);
                    $payment->registration->update(['status' => 'paid', 'paid_at' => now()]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
