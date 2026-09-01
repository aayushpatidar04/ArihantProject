<?php

namespace App\Http\Controllers;

use App\Models\InfluencerPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InfluencerController extends Controller
{
    /**
     * Influencer dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        $this->ensureInfluencer($user);

        $posts = $user->influencerPosts()
            ->latest()
            ->get();

        $totalPosts = $posts->count();

        $approvedPosts = $posts->where('status', 'approved')->count();

        $pendingPosts = $posts->where('status', 'pending')->count();

        $rejectedPosts = $posts->where('status', 'rejected')->count();

        $totalScore = (int) $posts
            ->where('status', 'approved')
            ->sum('points_awarded');

        return view('influencer.dashboard', compact(
            'user',
            'posts',
            'totalPosts',
            'approvedPosts',
            'pendingPosts',
            'rejectedPosts',
            'totalScore'
        ));
    }

    /**
     * Show post submission form.
     */
    public function createPost()
    {
        $this->ensureInfluencer(Auth::user());

        return view('influencer.posts.create');
    }

    /**
     * Submit influencer post.
     */
    public function storePost(Request $request)
    {
        $user = Auth::user();

        $this->ensureInfluencer($user);

        $validated = $request->validate([
            'platform' => [
                'required',
                'string',
                'in:instagram,facebook,youtube,x,linkedin'
            ],
            'post_type' => [
                'required',
                'string',
                'in:reel,post,video,story'
            ],
            'post_url' => [
                'required',
                'url',
                'max:1000'
            ],
        ]);

        InfluencerPost::create([
            'user_id' => $user->id,
            'platform' => $validated['platform'],
            'post_type' => $validated['post_type'],
            'post_url' => $validated['post_url'],
            'status' => 'pending',
            'points_awarded' => 0,
        ]);

        return redirect()
            ->route('influencer.dashboard')
            ->with(
                'success',
                'Your post has been submitted for approval.'
            );
    }

    /**
     * Show influencer's own posts.
     */
    public function posts()
    {
        $user = Auth::user();

        $this->ensureInfluencer($user);

        $posts = $user->influencerPosts()
            ->latest()
            ->paginate(15);

        return view('influencer.posts.index', compact('posts'));
    }

    /**
     * Logout influencer.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('influencer.login')
            ->with('success', 'You have been logged out.');
    }

    /**
     * Make sure only influencers can access these pages.
     */
    protected function ensureInfluencer($user): void
    {
        if (!$user || $user->role !== 'influencer') {
            abort(403, 'Unauthorized.');
        }
    }
}