<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\InfluencerPost;
use App\Services\LeadScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfluencerController extends Controller
{
    public function __construct(protected LeadScoringService $leadScore) {}

    /**
     * Show submission form and user's posts.
     */
    public function index()
    {
        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('registration.form');
        }
        $posts = $reg->influencerPosts()->latest()->get();
        return view('influencer.submit', compact('reg', 'posts'));
    }

    /**
     * Submit a post/reel URL.
     */
    public function submit(Request $request)
    {
        $request->validate([
            'platform' => 'required|in:instagram,meta,x,youtube',
            'post_url' => 'required|url|max:500',
            'post_type' => 'required|in:reel,post,story,video',
        ]);

        $reg = $this->getCurrentRegistration();
        if (!$reg) {
            return redirect()->route('registration.form');
        }

        InfluencerPost::create([
            'event_registration_id' => $reg->id,
            'platform' => $request->platform,
            'post_url' => $request->post_url,
            'post_type' => $request->post_type,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Post submitted for verification.');
    }

    protected function getCurrentRegistration(): ?EventRegistration
    {
        if (!Auth::check()) return null;
        return EventRegistration::where('user_id', Auth::id())->latest()->first();
    }
}
