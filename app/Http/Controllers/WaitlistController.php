<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WaitlistController extends Controller
{
    /**
     * Show waitlist form.
     */
    public function create()
    {
        return view('registration.waitlist');
    }

    /**
     * Submit waitlist lead to CRM.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'regex:/^[6-9][0-9]{9}$/',
            ],

            'city' => [
                'required',
                'string',
                'max:100',
            ],
        ], [
            'phone.regex' => 'Please enter a valid 10-digit mobile number.',
        ]);

        // Push lead to CRM
        try {

            $crmResponse = Http::withHeaders([
                'Authorization' => 'Bearer 62c6067304882a00a922dcb4d89c51aab7c812f1d4371badedc531b5f737f8d3',
                'Content-Type' => 'application/json',
            ])
                ->timeout(15)
                ->post(
                    'https://ekycadminapi.arihantcapital.com/api/users/admin/createEventLead',
                    [
                        'name' => $validated['name'],

                        'mobileNumber' => $validated['phone'],

                        'email' => $validated['email'],

                        'city' => $validated['city'],

                        'sourceUrl' => 'https://event.arihantplus.com',

                        'source' => 'AI & Algo Conclave',

                        'clientType' => 'Waitlist Submission',
                    ]
                );

            Log::info('Waitlist lead pushed to CRM', [
                'name' => $validated['name'],
                'mobileNumber' => $validated['phone'],
                'email' => $validated['email'],
                'city' => $validated['city'],
                'crm_status' => $crmResponse->status(),
                'crm_response' => $crmResponse->json(),
            ]);

        } catch (\Throwable $e) {

            Log::error('Waitlist CRM lead push failed', [
                'name' => $validated['name'],
                'mobileNumber' => $validated['phone'],
                'email' => $validated['email'],
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()
            ->route('index')
            ->with(
                'success',
                'Thank you! You have been added to the waitlist.'
            );
    }
}