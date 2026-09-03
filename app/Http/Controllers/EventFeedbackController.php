<?php

namespace App\Http\Controllers;

use App\Models\EventFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventFeedbackController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        $registration = $user->eventRegistration;

        if (!$registration) {
            return redirect()
                ->route('index')
                ->with('error', 'No event registration found for your account.');
        }

        if ($registration->status !== 'paid') {
            return redirect()
                ->route('index')
                ->with('error', 'Only confirmed event participants can submit feedback.');
        }

        $existingFeedback = EventFeedback::where(
            'event_registration_id',
            $registration->id
        )->first();

        if ($existingFeedback) {
            return view('event-feedback.thank-you', [
                'registration' => $registration,
            ]);
        }

        return view('event-feedback.create', [
            'registration' => $registration,
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $registration = $user->eventRegistration;

        if (!$registration) {
            return redirect()
                ->route('index')
                ->with('error', 'No event registration found.');
        }

        if ($registration->status !== 'paid') {
            return redirect()
                ->route('index')
                ->with('error', 'Only confirmed event participants can submit feedback.');
        }

        // Prevent duplicate submissions
        if (
            EventFeedback::where(
                'event_registration_id',
                $registration->id
            )->exists()
        ) {
            return redirect()
                ->route('event.feedback')
                ->with('error', 'You have already submitted your feedback.');
        }

        $validated = $request->validate([
            'experience_rating' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'session_quality' => [
                'required',
                'in:Excellent,Very Good,Good,Average,Poor',
            ],

            'content_usefulness' => [
                'required',
                'in:Extremely Useful,Very Useful,Useful,Slightly Useful,Not Useful',
            ],

            'networking_rating' => [
                'required',
                'in:Excellent,Very Good,Good,Average,Poor,Not Applicable',
            ],

            'most_valuable_session' => [
                'required',
                'string',
                'max:2000',
            ],

            'liked_most' => [
                'required',
                'string',
                'max:2000',
            ],

            'improvements' => [
                'required',
                'string',
                'max:2000',
            ],

            'recommendation' => [
                'required',
                'in:Definitely Yes,Probably Yes,Maybe,Probably No,Definitely No',
            ],
        ]);

        EventFeedback::create([
            'event_registration_id' => $registration->id,

            'experience_rating' => $validated['experience_rating'],
            'session_quality' => $validated['session_quality'],
            'content_usefulness' => $validated['content_usefulness'],
            'networking_rating' => $validated['networking_rating'],

            'most_valuable_session' => $validated['most_valuable_session'],
            'liked_most' => $validated['liked_most'],
            'improvements' => $validated['improvements'],

            'recommendation' => $validated['recommendation'],
        ]);

        return redirect()
            ->route('event.feedback')
            ->with('success', 'Thank you for your valuable feedback!');
    }
}