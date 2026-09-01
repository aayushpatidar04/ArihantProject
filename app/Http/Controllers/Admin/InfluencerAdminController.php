<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\InfluencerPost;
use App\Services\InfluencerScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class InfluencerAdminController extends Controller
{

    public function __construct(
        protected InfluencerScoringService $influencerScore
    ) {
    }
    /**
     * Display all influencers.
     */
    public function index()
    {
        $influencers = User::query()
            ->where('role', 'influencer')
            ->withCount([
                'influencerPosts',
                'influencerPosts as approved_posts_count' => function ($query) {
                    $query->where('status', 'approved');
                },
                'influencerPosts as pending_posts_count' => function ($query) {
                    $query->where('status', 'pending');
                },
            ])
            ->withSum([
                'influencerPosts as total_points' => function ($query) {
                    $query->where('status', 'approved');
                }
            ], 'points_awarded')
            ->latest()
            ->paginate(15);

        return view('admin.influencers.index', compact('influencers'));
    }

    /**
     * Show create influencer form.
     */
    public function create()
    {
        return view('admin.influencers.create');
    }

    /**
     * Store a new influencer account.
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
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'influencer',
        ]);

        return redirect()
            ->route('admin.influencers.index')
            ->with('success', 'Influencer account created successfully.');
    }

    /**
     * Show influencer details.
     */
    public function show(User $user)
    {
        abort_unless($user->role === 'influencer', 404);

        $user->load([
            'influencerPosts' => function ($query) {
                $query->latest();
            },
        ]);

        $stats = [
            'total_posts' => $user->influencerPosts->count(),

            'approved_posts' => $user->influencerPosts
                ->where('status', 'approved')
                ->count(),

            'pending_posts' => $user->influencerPosts
                ->where('status', 'pending')
                ->count(),

            'rejected_posts' => $user->influencerPosts
                ->where('status', 'rejected')
                ->count(),

            'total_points' => $user->influencerPosts
                ->where('status', 'approved')
                ->sum('points_awarded'),
        ];

        return view(
            'admin.influencers.show',
            compact('user', 'stats')
        );
    }

    /**
     * Show edit influencer form.
     */
    public function edit(User $user)
    {
        abort_unless($user->role === 'influencer', 404);

        return view('admin.influencers.edit', compact('user'));
    }

    /**
     * Update influencer account.
     */
    public function update(Request $request, User $user)
    {
        abort_unless($user->role === 'influencer', 404);

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
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.influencers.show', $user)
            ->with('success', 'Influencer account updated successfully.');
    }

    /**
     * Delete influencer account.
     */
    public function destroy(User $user)
    {
        abort_unless($user->role === 'influencer', 404);

        $user->delete();

        return redirect()
            ->route('admin.influencers.index')
            ->with('success', 'Influencer account deleted successfully.');
    }

    public function approvePost(InfluencerPost $post)
    {
        if ($post->status === 'approved') {
            return back()->with(
                'error',
                'This post has already been approved.'
            );
        }

        $this->influencerScore->approvePost($post);

        return back()->with(
            'success',
            'Post approved and 20 points awarded.'
        );
    }

    public function rejectPost(
        InfluencerPost $post,
        Request $request
    ) {
        $request->validate([
            'reason' => 'nullable|string|max:1000',
        ]);

        if ($post->status === 'rejected') {
            return back()->with(
                'error',
                'This post has already been rejected.'
            );
        }

        $this->influencerScore->rejectPost(
            $post,
            $request->input('reason')
        );

        return back()->with(
            'success',
            'Post rejected.'
        );
    }
}